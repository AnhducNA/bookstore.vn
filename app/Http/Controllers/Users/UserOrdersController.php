<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class UserOrdersController extends Controller
{
    public function myOrders()
    {
        $userId = Auth::user()->id;
        $myOrders = Order::where('user_id', $userId)->latest()->get();
        return view('public.users.orders', compact('myOrders'));
    }
    public function order_details($id)
    {
        $order = Order::findOrFail($id);
        $order_details = OrderDetail::where('order_id', $id)->get();

        return view('public.users.order-details', compact('order_details', 'order'));
    }
}
