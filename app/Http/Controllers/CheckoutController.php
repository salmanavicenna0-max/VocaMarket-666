<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Login dulu untuk checkout.');
        }

        $cartItems = Auth::user()->cart()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);
        $total = $subtotal;

        return view('checkout.index', compact('cartItems', 'subtotal', 'total'));
    }

    /**
     * Place the order: create order + order_items inside DB::transaction.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Login dulu untuk checkout.');
        }

        $validated = $request->validate([
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $cartItems = Auth::user()->cart()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }

        try {
            $order = DB::transaction(function () use ($cartItems, $validated) {
                $subtotal = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

                $order = Order::create([
                    'code_order' => Order::generateCode(),
                    'user_id' => Auth::id(),
                    'status' => Order::STATUS_MENUNGGU_PEMBAYARAN,
                    'subtotal' => $subtotal,
                    'discount' => 0,
                    'total' => $subtotal,
                    'note' => $validated['note'] ?? null,
                ]);

                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'name_snapshot' => $item->product->name,
                        'price_snapshot' => $item->product->price,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->product->price * $item->quantity,
                    ]);
                }

                // Kosongkan keranjang
                Auth::user()->cart()->delete();

                return $order;
            });
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal buat pesanan: ' . $e->getMessage());
        }

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pesanan dibuat! Kode: ' . $order->code_order);
    }
}
