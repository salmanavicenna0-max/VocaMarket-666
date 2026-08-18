<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class SellerOrderController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('seller_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'status' => 'required|string|max:50'
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
