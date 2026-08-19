<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\PaymentMethod;

class OrderController extends Controller
{

    /**
     * List current user's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', '!=', Order::STATUS_DIBATALKAN)
            ->with(['items.product', 'payments', 'refunds'])
            ->latest()
            ->get();

        $serviceRequests = \App\Models\ServiceRequest::where('user_id', Auth::id())
            ->with('product.seller')
            ->latest()
            ->get();

        return view('order.index', compact('orders', 'serviceRequests'));
    }

    /**
     * Show order detail.
     */
    public function show($id)
    {
        $order = Order::with(['items.product.images', 'payments', 'refunds'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $paymentMethods = PaymentMethod::active()->orderBy('sort_order')->get();

        return view('order.show', compact('order', 'paymentMethods'));
    }

    public function invoice($id)
    {
        $order = Order::with(['user', 'seller', 'items.product.images', 'payments', 'refunds'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('order.invoice', compact('order'));
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
    public function refund(Request $request, $id)
    {
        $validated = $request->validate([
            'reason' => 'required|string|min:10'
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if (Auth::user()->isRefundRestricted()) {
            return back()->with('error', 'Akun Anda sedang dibatasi dari pengajuan refund karena pelanggaran sebelumnya.');
        }

        if (!in_array($order->status, [Order::STATUS_DIPROSES, Order::STATUS_SELESAI])) {
            return back()->with('error', 'Status pesanan tidak dapat diajukan pengembalian.');
        }

        \App\Models\Refund::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'status' => \App\Models\Refund::STATUS_REQUESTED,
            'reason' => $validated['reason'],
        ]);

        $order->update([
            'status' => Order::STATUS_MENUNGGU_PENGEMBALIAN
        ]);

        return back()->with('success', 'Pengajuan pengembalian beserta catatan berhasil dikirim. Menunggu tinjauan Admin.');
    }

    /**
     * Pembeli mengonfirmasi bukti transfer refund dari admin.
     */
    public function confirmRefund($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status !== Order::STATUS_MENUNGGU_KONFIRMASI_PEMBELI) {
            return back()->with('error', 'Refund tidak sedang menunggu konfirmasi Anda.');
        }

        $refund = $order->refunds()->whereIn('status', [
            \App\Models\Refund::STATUS_PROOF_SENT,
        ])->first();

        if (!$refund) {
            return back()->with('error', 'Bukti transfer refund tidak ditemukan.');
        }

        $refund->update([
            'status' => \App\Models\Refund::STATUS_CONFIRMED,
            'confirmed_at' => now(),
        ]);

        $order->update(['status' => Order::STATUS_PENGEMBALIAN]);

        return back()->with('success', 'Refund dikonfirmasi. Pengembalian dana dinyatakan selesai.');
    }

    /**
     * Pembeli menolak bukti transfer admin (disangkakan palsu) -> kembali ke investigasi admin.
     */
    public function disputeRefund(Request $request, $id)
    {
        $validated = $request->validate([
            'reason' => 'required|string|min:10'
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status !== Order::STATUS_MENUNGGU_KONFIRMASI_PEMBELI) {
            return back()->with('error', 'Refund tidak sedang menunggu konfirmasi Anda.');
        }

        $refund = $order->refunds()->where('status', \App\Models\Refund::STATUS_PROOF_SENT)->first();

        if (!$refund) {
            return back()->with('error', 'Bukti transfer refund tidak ditemukan.');
        }

        $refund->update([
            'status' => \App\Models\Refund::STATUS_DISPUTED,
            'dispute_reason' => $validated['reason'],
        ]);

        $order->update(['status' => Order::STATUS_MENUNGGU_PENGEMBALIAN]);

        return back()->with('success', 'Bukti transfer Anda tolak dan dikembalikan ke Admin untuk investigasi ulang. Refund belum ditandai selesai.');
    }
}
