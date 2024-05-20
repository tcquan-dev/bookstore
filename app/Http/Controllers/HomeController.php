<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $user = backpack_auth()->user();
        $books = $user->cart->books ?? array();
        return view('home', compact('user', 'books'));
    }

    public function getProfileForm()
    {
        $user = backpack_auth()->user();
        $addresses = $user->addresses ?? array();
        return view('forms.profile', compact('user', 'addresses'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = backpack_auth()->user();
            $profile = Profile::where('user_id', $user->id)->first();

            $path = $user->profile->avatar;
            if ($request->hasFile('avatar')) {
                if (isset($path)) {
                    Storage::delete('public/' . $path);
                }
                $path = $request->file('avatar')->store('public/avatar');
            }

            $profileData = [
                'avatar' => substr($path, strlen('public/')),
                'gender' => $request->post('gender'),
                'phone_number' => $request->post('phone_number'),
                'address' => $request->post('address'),
                'bio' => $request->post('bio')
            ];

            $profile->update($profileData);
            toast('Cập nhật thông tin thành công!', 'success');
            return redirect()->back();
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
