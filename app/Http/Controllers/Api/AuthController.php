<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Mail\UserVerification;
use App\Models\Verification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

            $code = rand(0000000, 999999);

            Verification::create([
                'user_id' => $user->id,
                'code' =>  $code,
                'expired_in' => now()->addMinutes(60)
            ]);

            Mail::to($user->email)->send(new UserVerification($code));

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

    public function verify($code)
    {
        try {
            $verification = Verification::where([['code', $code], ['expired_in', '>', now()]])->first();
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
}
