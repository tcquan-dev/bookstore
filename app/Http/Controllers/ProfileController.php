<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\ProfileCollection;
use Tymon\JWTAuth\Exceptions\JWTException;

class ProfileController extends Controller
{
    /**
     * Get user profile.
     */
    public function getProfile(Request $request)
    {
        try {
            $user = JWTAuth::parseToken($request->bearerToken())->authenticate();
            $profileData = Profile::where('user_id', $user->id)->first();
            return new ProfileCollection($profileData);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        try {
            $user = JWTAuth::parseToken($request->bearerToken())->authenticate();
            $profile = Profile::where('user_id', $user->id)->first();
            $profile->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thông tin người dùng thành công!'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
