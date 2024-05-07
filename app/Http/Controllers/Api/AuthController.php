<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Mail\ResetPassword;
use App\Mail\UserVerification;
use App\Models\Verification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{


    /**
     * Create a new account.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AuthRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->post('name'),
                'email' => $request->post('email'),
                'password' => Hash::make($request->post('password'))
            ]);

            $token = Password::createToken($user);

            Verification::create([
                'user_id' => $user->id,
                'token' =>  $token,
                'expired_in' => now()->addMinutes(60)
            ]);

            Mail::to($user->email)->send(new UserVerification($token));

            return response()->json([
                'status' => 'success',
                'message' => 'Đăng ký thành công, hãy kiểm tra hộp thư để xác thực tài khoản của bạn!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function verify($token)
    {
        try {
            $verification = Verification::where([['token', $token], ['expired_in', '>', now()]])->first();
            if ($verification) {
                $user = User::findOrFail($verification->user_id);
                $user->update([
                    'email_verified_at' => now(),
                    'active' => true
                ]);
                $verification->delete();
                return redirect('/admin/login');
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Liên kết kích hoạt đã hết hạn!'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a JWT given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = array(
            'email' => $request->post('email'),
            'password' => $request->post('password'),
        );

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sai email hoặc mật khẩu!'
                ], 422);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đăng nhập thành công!',
            'token' => $token
        ]);
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);
            $user = User::where('email', $request->post('email'))->first();

            $token = Password::createToken($user);

            $verification = Verification::create([
                'user_id' => $user->id,
                'token' =>  $token,
                'expired_in' => now()->addMinutes(60)
            ]);

            Mail::to($user->email)->send(new ResetPassword($token));
            $verification->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Hãy kiểm tra hộp thư để tiến hành đặt lại mật khẩu của bạn!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function changePassword(Request $request) {
        try {
            $user = JWTAuth::parseToken($request->bearerToken())->authenticate();
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|string|min:8',
                'confirm_password' => 'required|string|min:8|same:new_password'
            ]);
            $user->update([
                'password' => Hash::make($request->post('new_password'))
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật mật khẩu thành công!'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
