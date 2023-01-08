<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ShoppingCartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        $id = $request->input('book_id');
        $book = DB::table('books')->find($id);
        if ($book->quantity >= $request->input('quantity')) {
            if ($request->input('quantity') >= 1) {
                $cart = Session::get('cart');
                if (isset($cart['total_price']) && isset($cart['total_quantity'])) {
                    $total_price = $cart['total_price'];
                    $total_quantity = $cart['total_quantity'];
                } else {
                    $total_price = (double)0;
                    $total_quantity = (int)0;
                }

                if (isset($cart['products'][$id])) {
                    $cart['products'][$id]['quantity'] += $request->input('quantity');
                    $cart['products'][$id]['sub_total'] += (int)$request->input('quantity') * (double)$cart['products'][$id]['price'];
                    $total_quantity += $request->input('quantity');
                    $total_price += (int)$request->input('quantity') * (double)$cart['products'][$id]['price'];
                } else {
                    $cart['products'][$id] = [
                        'id' => $book->id,
                        'name' => $book->title,
                        'quantity' => $request->input('quantity'),
                        'price' => $book->price,
                        'image_id' => $book->image_id,
                        'sub_total' => $book->price * (int)$request->input('quantity')
                    ];
                    $total_quantity += (int)$cart['products'][$id]['quantity'];
                    $total_price += (double)$cart['products'][$id]['sub_total'];
                }
                $cart['total_price'] = $total_price;
                $cart['total_quantity'] = $total_quantity;
                Session::put('cart', $cart);
                return redirect()->back()->with('success_message', 'Product added to cart successfully!');
            } else {
                return redirect()->back()
                    ->with('cart_alert', "Quantity must be larger than 0");
            }
        } else {
            return redirect()->back()
                ->with('cart_alert', "We don't have that much quantity.");
        }
    }

    public function cart()
    {
        $cart = Session::get('cart');
        if (!empty($cart)) {
            foreach ($cart['products'] as $key => $value) {
                $image = DB::table('images')->find($value['image_id']);
                $cart['products'][$key]['image_file'] = $image->file;
            }
            return view('public.cart', compact('cart'));
        } else {
            return view('public.cart', compact('cart'));
        }

    }

    public function cart_delete_all()
    {
        Session::remove('cart');
        return redirect()->back()->with('success_message', 'Delete all products success');
    }

    public function cart_delete($id)
    {
        $cart = Session::get('cart');
        $cart['total_price'] -= $cart['products'][$id]['sub_total'];
        $cart['total_quantity'] -= $cart['products'][$id]['quantity'];
        unset($cart['products'][$id]);
        Session::put('cart', $cart);
        return redirect()->back();
    }

    public function cart_update(Request $request)
    {
        dd($request->input());
    }

    public function cart_decrement($id, $qty)
    {
        if ($qty > 1) {
            $cart = Session::get('cart');
            $cart['products'][$id]['quantity']--;
            $cart['products'][$id]['sub_total'] -= $cart['products'][$id]['price'];
            $cart['total_quantity']--;
            $cart['total_price'] -= $cart['products'][$id]['price'];
            Session::put('cart', $cart);
        }
//        Session::remove('cart');
        return redirect()->back();

    }

    public function cart_increment($id, $qty)
    {
        $cart = Session::get('cart');
        $cart['products'][$id]['quantity']++;
        $cart['products'][$id]['sub_total'] += $cart['products'][$id]['price'];
        $cart['total_quantity']++;
        $cart['total_price'] += $cart['products'][$id]['price'];
        Session::put('cart', $cart);
        return redirect()->back();

    }


}
