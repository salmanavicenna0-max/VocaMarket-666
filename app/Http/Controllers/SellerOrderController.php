<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class SellerOrderController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->isAdmin()) {
            $order = Order::findOrFail($id);
        } else {
            $order = Order::where('seller_id', Auth::id())->findOrFail($id);
        }
        
        $request->validate([
            'status' => 'required|string|max:50'
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function sellerApproveRefund($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === Order::STATUS_MENUNGGU_PENGEMBALIAN_PENJUAL) {
            $order->update(['status' => Order::STATUS_PENGEMBALIAN]);
            return back()->with('success', 'Pengembalian dana disetujui penjual. Proses refund selesai!');
        }

        return back()->with('error', 'Pesanan tidak dalam status menunggu persetujuan penjual.');
    }

    public function sellerRejectRefund($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === Order::STATUS_MENUNGGU_PENGEMBALIAN_PENJUAL) {
            $order->update(['status' => Order::STATUS_SELESAI]);
            return back()->with('success', 'Pengembalian dana ditolak penjual. Status pesanan kembali Selesai.');
        }

        return back()->with('error', 'Pesanan tidak dalam status menunggu persetujuan penjual.');
    }
}
