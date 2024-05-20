<?php

namespace App\Http\Controllers\Home;

use Exception;
use App\Models\Book;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $books = Book::latest()->get();
        $user = backpack_auth()->user();
        $categories = Category::latest()->get();
        foreach ($books as $item) {
            $item->rate = $this->averageRating($item->id);
        }
        return view('home', compact('user', 'books', 'categories'));
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

    public function averageRating($id)
    {
        $reviews = Review::where('book_id', $id)->get();
        $totalStars = $reviews->sum('rate');
        $reviewCount = $reviews->count();

        if ($reviewCount > 0) {
            $averageRating = $totalStars / $reviewCount;
        } else {
            $averageRating = 0;
        }

        $averageRating = round($averageRating * 2) / 2;
        return $averageRating;
    }
}
