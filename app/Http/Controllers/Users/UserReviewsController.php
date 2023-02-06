<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserReviewsController extends Controller
{
    public function myReviews()
    {
        $userId = Auth::user()->id;
        $myReviews = Review::where('user_id', $userId)->latest()->paginate(10);
//        dd($myReviews[0]->book->image->file);
        return view('public.users.reviews', compact('myReviews'));
    }

    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('alert_message', 'Your review deleted');
    }
}
