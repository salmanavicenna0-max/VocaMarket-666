<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Order;

class ReviewController extends Controller
{

    /**
     * Store a review for a product.
     */
    public function store(Request $request, $productId)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ]);

        $orderId = $request->input('order_id');

        if ($orderId) {
            $order = Order::where('user_id', Auth::id())->findOrFail($orderId);
        }

        // Unique (product_id, user_id) — DB constraint enforce, catch error
        try {
            $review = Review::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                ],
                [
                    'order_id' => $orderId ?? null,
                    'rating' => $validated['rating'],
                    'comment' => $validated['comment'] ?? null,
                    'status' => Review::STATUS_APPROVED,
                ]
            );
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Kamu sudah pernah mengulas produk ini.');
        }

        return back()->with('success', 'Ulasan terkirim.');
    }
}
