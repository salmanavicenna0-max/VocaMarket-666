<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        $product = Product::findOrFail($productId);

        if ($product->type !== 'jasa') {
            return back()->with('error', 'Produk ini bukan merupakan jasa.');
        }

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengajukan pesanan jasa.');
        }

        ServiceRequest::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'seller_id' => $product->user_id, // assuming product belongs to user
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pengajuan jasa berhasil dikirim. Silakan tunggu penawaran harga dari penjual.');
    }

    public function quote(Request $request, $id)
    {
        $request->validate([
            'quoted_price' => 'required|numeric|min:0',
            'seller_notes' => 'nullable|string|max:1000',
        ]);

        $serviceRequest = ServiceRequest::findOrFail($id);

        if ($serviceRequest->seller_id !== Auth::id()) {
            abort(403);
        }

        $serviceRequest->update([
            'quoted_price' => $request->quoted_price,
            'seller_notes' => $request->seller_notes,
            'status' => 'quoted',
        ]);

        return back()->with('success', 'Penawaran harga berhasil dikirim ke pembeli.');
    }

    public function accept(Request $request, $id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);

        if ($serviceRequest->user_id !== Auth::id()) {
            abort(403);
        }

        if ($serviceRequest->status !== 'quoted') {
            return back()->with('error', 'Pengajuan ini tidak dapat disetujui saat ini.');
        }

        // Add to cart with custom price
        // To do this simply without modifying Cart model schema too much, 
        // we can create a custom product variation or just use the cart if it supports price override.
        // Actually, VocaMarket's cart uses product_id, but the price is fetched dynamically from Product model in CheckoutController.
        // If we want a custom price, we might need to store `service_request_id` or `custom_price` in the cart.

        // Wait, since we are doing an MVP, let's update the ServiceRequest status to 'accepted' and redirect directly to checkout with this specific request.
        // Let's create an Order directly.
        
        $serviceRequest->update(['status' => 'accepted']);
        
        // Since VocaMarket uses CheckoutController which reads from Cart, we might need a direct Checkout method for Services.
        // Let's just create an Order right here for simplicity.
        
        $order = \App\Models\Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => Auth::id(),
            'seller_id' => $serviceRequest->seller_id,
            'total' => $serviceRequest->quoted_price,
            'status' => 'menunggu_pembayaran',
        ]);

        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $serviceRequest->product_id,
            'quantity' => 1,
            'price' => $serviceRequest->quoted_price,
            'subtotal' => $serviceRequest->quoted_price,
        ]);

        return redirect()->route('orders.show', $order->id)->with('success', 'Penawaran disetujui! Silakan selesaikan pembayaran Anda.');
    }
}
