<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{

    /**
     * List current user's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', '!=', Order::STATUS_DIBATALKAN)
            ->with(['items.product', 'payments'])
            ->latest()
            ->get();

        return view('order.index', compact('orders'));
    }

    /**
     * Show order detail.
     */
    public function show($id)
    {
        $order = Order::with(['items.product.images', 'payments'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('order.show', compact('order'));
    }

    /**
     * Cancel order (only when still menunggu_pembayaran).
     */
    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status !== Order::STATUS_MENUNGGU_PEMBAYARAN) {
            return back()->with('error', 'Pesanan sudah diproses, tidak bisa dibatalkan.');
        }

        $order->update(['status' => Order::STATUS_DIBATALKAN]);

        return back()->with('success', 'Pesanan dibatalkan.');
    }
    public function refund($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if (!in_array($order->status, [Order::STATUS_DIPROSES, Order::STATUS_SELESAI])) {
            return back()->with('error', 'Status pesanan tidak dapat diajukan pengembalian.');
        }

        $order->update([
            'status' => Order::STATUS_MENUNGGU_PENGEMBALIAN
        ]);

        return back()->with('success', 'Pengajuan pengembalian berhasil dikirim. Menunggu tinjauan Admin.');
    }
}
