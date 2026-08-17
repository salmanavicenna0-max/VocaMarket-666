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
        $groupedItems = collect();
        $total = 0;

        if (Auth::check()) {
            $cartItems = Auth::user()->cart()->with(['product.images', 'product.seller'])->get();
            $groupedItems = $cartItems->groupBy(function ($item) {
                return $item->product->user_id ?? 0;
            });
            $total = $cartItems->sum(fn ($item) => $item->product?->price * $item->quantity ?? 0);
            
            // Mark items as read
            Auth::user()->cart()->where('is_read', false)->update(['is_read' => true]);
        }

        return view('cart.index', compact('groupedItems', 'cartItems', 'total'));
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

        $cartItem = Cart::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        $cartItem->quantity = $cartItem->exists ? $cartItem->quantity + $quantity : $quantity;
        $cartItem->status = 'aktif';
        $cartItem->is_read = false;
        $cartItem->save();

        return back()->with('success', $product->name . ' masuk keranjang.');
    }

    /**
     * Update quantity of product in cart.
     */
    public function update(Request $request, $id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->with('product')->findOrFail($id);

        if ($request->action === 'increase') {
            if ($cartItem->quantity < $cartItem->product->stock) {
                $cartItem->increment('quantity');
            } else {
                return back()->with('error', 'Stok maksimum tercapai.');
            }
        } elseif ($request->action === 'decrease') {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
            }
        }

        return back();
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
