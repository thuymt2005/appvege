<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    // /**
    //  * Add an item to the cart.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\RedirectResponse
    //  */
    // public function add(Request $request)
    // {
    //     // Logic to add item to cart
    //     return redirect()->route('cart.index')->with('success', 'Item added to cart.');
    // }

    // /**
    //  * Remove an item from the cart.
    //  *
    //  * @param  int  $itemId
    //  * @return \Illuminate\Http\RedirectResponse
    //  */
    // public function remove($itemId)
    // {
    //     // Logic to remove item from cart
    //     return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    // }
}
