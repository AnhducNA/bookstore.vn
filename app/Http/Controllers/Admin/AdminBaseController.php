<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminBaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('auth');
    }

    public function index(){
        $users = User::all();
        $books_quantity = Book::sum('quantity');
        $total_earning = Order::where('order_status', 1)->sum('total_price');
        $pending_orders = Order::where('order_status', 0)->get();
        return view('admin.dashboard', compact('users', 'books_quantity', 'total_earning', 'pending_orders'));
    }
}
