<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Session;

class ProductController extends Controller
{
    function index()
    {
        // return "Welcome to product page";
        // return Product::all();
        // return view('product');
        $data = Product::all();
        return view('product', ['products'=>$data]);
    }
    function detail($id)
    {
        // return Product::find($id);
        $data = Product::find($id);
        return view('detail', ['product'=>$data]);
    }
    function search(Request $req)
    {
        // return $req->input();
        // return $data = Product::where('name', 'like', '%'.$req->input('query').'%')->get();
        $data = Product::where('name', 'like', '%'.$req->input('query').'%')->get();
        return view('search', ['products'=>$data]);
    }
    function addToCart(Request $req)
    {
        if($req->session()->has('user'))
        {
            // return "Hello";
            $cart = new Cart;
            $cart->user_id = $req->session()->get('user')['id'];
            $cart->product_id = $req->product_id;
            $cart->save();
            return redirect('/');
        }
        else
        {
            return redirect('/login');
        }
    }
    static function cartItem()
    {
        $userId = Session::get('user')['id'];
        return Cart::where('user_id', $userId)->count();
    }
}
