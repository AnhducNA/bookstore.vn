<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewsController extends Controller
{
    public function store($book_id, Request $request)
    {
        //        get $currentTime
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentTime = (string)date('Y-m-d H:i:s', time());
//        validate
        $request->validate([
            'body' => 'required'
        ], [
                'required' => "Comment body can't be empty"
            ]
        );
        $input['body']=$request->input('body');
        $input['user_id'] = Auth::user()->id;
        $input['product_id'] = $book_id;
        $input['created_at'] = $currentTime;
        DB::table('reviews')->insert($input);
        return redirect()->back()->with('success_message', 'Your review added');
    }
}
