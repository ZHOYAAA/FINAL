<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display cart items.
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product', 'product.category'])
            ->get();

        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        $menu = \App\Models\Page::where(['is_group'=>0,'is_active'=>1])->get();
        $submenu = \App\Models\Page::where(['is_group'=>1,'is_active'=>1])->get();
        $categories = \App\Models\Category::all();
        $appname = config('app.name');

        return view('cart.index', compact('cartItems', 'total', 'menu', 'submenu', 'categories', 'appname'));
    }

    /**
     * Add item to cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            $cart->update([
                'quantity' => $cart->quantity + $request->quantity
            ]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Produk berhasil ditambahkan ke keranjang',
                'cartCount' => $cartCount
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->update([
            'quantity' => $request->quantity
        ]);

        $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Jumlah produk berhasil diupdate',
                'cartCount' => $cartCount,
                'itemTotal' => number_format($cart->product->price * $cart->quantity, 0, ',', '.'),
                'cartTotal' => number_format(Cart::where('user_id', auth()->id())->get()->sum(function($item) {
                    return $item->quantity * $item->product->price;
                }), 0, ',', '.')
            ]);
        }

        return redirect()->back()->with('success', 'Jumlah produk berhasil diupdate');
    }

    /**
     * Remove item from cart.
     */
    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Produk berhasil dihapus dari keranjang',
                'cartCount' => $cartCount
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang');
    }
} 