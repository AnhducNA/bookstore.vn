<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Stripe;

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
//        dd($cart);
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
        Stripe::setApiKey('pk_test_TYooMQauvdEDq54NiTphI7jx');
        $token = $request->stripeToken;
        $total = $request->cart_total;

        $order = new Order();
        $user = Auth::user();

        $shipping_address = ShippingAddress::where('user_id', $user->id)->latest()->first();
        $order->user_id = $user->id;
        $order->shipping_id = $shipping_address->id;
        $order->total_price = $total;
        $order->payment_type = 'card';
        $order->save();
        $order_id = $order->id;
        $cart = Session::get('cart');
//        dd($cart);
        foreach ($cart['products'] as $key=> $cartItem) {
            $orderDetails = new OrderDetail();

            $orderDetails->order_id = $order_id;
            $orderDetails->book_id = $cartItem['id'];
            $orderDetails->book_name = $cartItem['name'];
            $orderDetails->price = $cartItem['price'];
            $orderDetails->book_quantity = $cartItem['quantity'];
            $orderDetails->save();
            Session::remove('cart')['products'][$key];

//            Cart::remove($cartItem->rowId);

            $remove_product = Book::findOrFail($orderDetails->book_id);
            $remove_product->update([
                'quantity' => $remove_product->quantity - $orderDetails->book_quantity,
            ]);
        }
        return redirect()->route('user.orders')
            ->with('success_message', 'Order placed successfully. Wait for confirmation.');
    }
}
