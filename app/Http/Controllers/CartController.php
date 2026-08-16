<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Show the cart page.
     */
    public function index()
    {
        $cartItems = collect();

        if (Auth::check()) {
            // NOTE: tabel carts masih kosong (belum ada kolom user_id/product_id/quantity).
            // Migration carts perlu di-update dulu sebelum fitur cart jalan penuh.
            $cartItems = Auth::user()->cart()->with('product.images')->get();
        }

        $total = $cartItems->sum(fn ($item) => $item->product?->price * $item->quantity ?? 0);

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Login dulu untuk masuk keranjang.');
        }

        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:' . max(1, $product->stock)],
        ]);

        $quantity = $validated['quantity'] ?? 1;

        $cartItem = Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ],
            ['quantity' => $quantity]
        );

        return back()->with('success', $product->name . ' masuk keranjang.');
    }

    /**
     * Remove product from cart.
     */
    public function destroy($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}
