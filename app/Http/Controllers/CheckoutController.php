<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function index()
    {
        $cart = Session::get('cart');
        if (!empty($cart)) {
            return view('public.checkout-page', compact('cart'));
        } else {
            abort(403, 'Cart is empty! you can not checkout');
        }
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentTime = (string)date('Y-m-d H:i:s', time());

//        $shipping_address
        $shipping_address = $request->all();
        if (Auth::check()) {
            $shipping_address['user_id'] = Auth::user()->id;
        } else {
            $shipping_address['user_id'] = 0;
        }
        if (!empty($shipping_address['_token'])) {
            unset($shipping_address['_token']);
        }
        $shipping_address['created_at'] = $currentTime;
        DB::table('shipping_addresses')->insert($shipping_address);
        $shipping_address = implode('+', $shipping_address);
//        end $shipping_address

        $cart = Session::get('cart');
        if (!empty($cart)) {
            return view('public.payment', compact('shipping_address', 'cart'));
        } else {
            abort(403, 'Cart is empty! you can not checkout');
        }
    }

    public function show()
    {
        $cart = Session::get('cart');
        if (!empty($cart)) {
            return view('public.payment', compact('cart'));
        } else {
            abort(403, 'Cart is empty! you can not checkout');
        }
    }

    public function payment_method($payment_method)
    {
        $cart = Session::get('cart');
        if (!empty($cart)) {
            if (!Auth::check()) {
                if ($payment_method == "bank") {
                    return view('public.payment', compact('cart'))->with('alert_message', 'Wait for confirmation');
                } else if ($payment_method == "cash") {
                    return view('public.payment', compact('cart'))->with('success_message', 'Payment success');
                } else {
                    return view('public.payment', compact('cart'));
                }
            } else {

            }
        } else {
            abort(403, 'Cart is empty! you can not checkout');
        }
    }

    public function pay(Request $request)
    {
//        $shipping_address[] = explode('+', $request->input('shipping_address'));
//        dd($shipping_address);
        if (Auth::check()) {
        } else {
            if ($request->input('btn-bankMethod')) {
                dd($request->input('btn-bankMethod'));
            } elseif ($request->input('btn-cashMethod')) {
                DB::table('orders')
                    ->insert();
                dd($request->input('btn-cashMethod'));
            } else {
                dd($request->input());
            }
        }
        return redirect('/')->with('success_message', 'ok');

    }
}
