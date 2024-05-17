<?php

namespace App\Http\Controllers\Api;

use App\Models\Profile;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProfileCollection;
use Tymon\JWTAuth\Exceptions\JWTException;

class ProfileController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        try {
            $this->user = JWTAuth::parseToken($request->bearerToken())->authenticate();
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Get user profile.
     */
    public function getProfile()
    {
        return new ProfileCollection($this->user->profile);
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        try {
            $profile = $this->user->profile;

            if ($request->has('name')) {
                $this->user->update([
                    'name' => $request->post('name')
                ]);
            }

            $path = $this->user->profile->avatar;
            if ($request->hasFile('avatar')) {
                if (isset($path)) {
                    Storage::delete($path);
                }
                $path = Storage::putFile('uploads', $request->file('avatar'));
            }

            $profileData = [
                'avatar' => $path,
                'gender' > $request->post('gender'),
                'phone_number' => $request->post('phone_number'),
                'address' => $request->post('address'),
                'bio' => $request->post('bio')
            ];

            $profile->update($profileData);

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thông tin người dùng thành công!',
                'data' => new ProfileCollection($profile)
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
