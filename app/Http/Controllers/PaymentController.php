<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Upload payment proof for an order.
     */
    public function store(Request $request, $orderId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);

        if ($order->status !== Order::STATUS_MENUNGGU_PEMBAYARAN) {
            return back()->with('error', 'Status pesanan tidak bisa bayar sekarang.');
        }

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'method' => ['nullable', 'string', 'max:50'],
            'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $proofPath = $request->file('payment_proof')->store('payments', 'public');

        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $validated['amount'],
            'method' => $validated['method'] ?? 'transfer',
            'payment_proof' => $proofPath,
            'status' => Payment::STATUS_PENDING,
        ]);

        $order->update(['status' => Order::STATUS_MENUNGGU_VERIFIKASI]);

        return back()->with('success', 'Bukti pembayaran terkirim, menunggu verifikasi admin.');
    }

    /**
     * Admin: approve a payment.
     */
    public function approve($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'status' => Payment::STATUS_APPROVED,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);
        $payment->order->update(['status' => Order::STATUS_DIPROSES]);

        return back()->with('success', 'Pembayaran disetujui, pesanan diproses.');
    }

    /**
     * Admin: reject a payment.
     */
    public function reject(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $validated = $request->validate([
            'note' => ['required', 'string', 'max:1000'],
        ]);

        $payment->update([
            'status' => Payment::STATUS_REJECTED,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
            'note' => $validated['note'],
        ]);
        $payment->order->update(['status' => Order::STATUS_DITOLAK]);

        return back()->with('success', 'Pembayaran ditolak: ' . $validated['note']);
    }
}
