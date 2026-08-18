<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Get all conversations for the authenticated user.
     */
    public function getConversations()
    {
        $userId = Auth::id();

        $conversations = Conversation::where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->with(['buyer.profile', 'seller.profile', 'product', 'messages' => function($q) {
                $q->latest();
            }])
            ->get()
            ->map(function ($conv) use ($userId) {
                // Determine who the other person is
                $otherPerson = $conv->buyer_id == $userId ? $conv->seller : $conv->buyer;
                $lastMessage = $conv->messages->first();

                // Count unread messages
                $unreadCount = $conv->messages()->where('sender_id', '!=', $userId)->where('is_read', false)->count();

                return [
                    'id' => $conv->id,
                    'other_user_id' => $otherPerson->id,
                    'name' => $otherPerson->name,
                    'avatar' => $otherPerson->profile && ($otherPerson->profile->photo || $otherPerson->profile->foto) 
                                ? asset('storage/' . ($otherPerson->profile->photo ?? $otherPerson->profile->foto)) 
                                : null,
                    'last_message' => $lastMessage ? $lastMessage->message : '',
                    'last_message_time' => $lastMessage ? $lastMessage->created_at->diffForHumans() : '',
                    'unread_count' => $unreadCount,
                    'product' => $conv->product ? [
                        'id' => $conv->product->id,
                        'name' => $conv->product->name,
                        'price' => $conv->product->price,
                        'thumbnail' => $conv->product->thumbnail
                    ] : null
                ];
            })
            // Sort by latest message time
            ->sortByDesc(function($conv) {
                return Conversation::find($conv['id'])->messages()->max('created_at');
            })->values();

        return response()->json(['conversations' => $conversations]);
    }

    /**
     * Get messages for a specific conversation.
     */
    public function getMessages($id)
    {
        $userId = Auth::id();
        $conversation = Conversation::where('id', $id)
            ->where(function($q) use ($userId) {
                $q->where('buyer_id', $userId)->orWhere('seller_id', $userId);
            })->firstOrFail();

        // Mark messages as read
        Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::where('conversation_id', $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) use ($userId) {
                return [
                    'id' => $msg->id,
                    'is_mine' => $msg->sender_id == $userId,
                    'message' => $msg->message,
                    'time' => $msg->created_at->format('H:i')
                ];
            });

        $productData = $conversation->product ? [
            'id' => $conversation->product->id,
            'name' => $conversation->product->name,
            'price' => $conversation->product->price,
            'thumbnail' => $conversation->product->thumbnail
        ] : null;

        return response()->json(['messages' => $messages, 'conversation_id' => $conversation->id, 'product' => $productData]);
    }

    /**
     * Send a new message.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string'
        ]);

        $userId = Auth::id();
        $conversation = Conversation::where('id', $request->conversation_id)
            ->where(function($q) use ($userId) {
                $q->where('buyer_id', $userId)->orWhere('seller_id', $userId);
            })->firstOrFail();

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'message' => $request->message,
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'is_mine' => true,
                'message' => $message->message,
                'time' => $message->created_at->format('H:i')
            ]
        ]);
    }

    /**
     * Start a conversation or get existing one.
     */
    public function startChat(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id'
        ]);

        $buyerId = Auth::id();
        $sellerId = $request->seller_id;

        if ($buyerId == $sellerId) {
            return response()->json(['error' => 'You cannot chat with yourself'], 400);
        }

        // Check if conversation exists
        $conversation = Conversation::where(function($q) use ($buyerId, $sellerId) {
            $q->where('buyer_id', $buyerId)->where('seller_id', $sellerId);
        })->orWhere(function($q) use ($buyerId, $sellerId) {
            // Also check the reverse just in case, though normally buyer_id is the initiator
            $q->where('buyer_id', $sellerId)->where('seller_id', $buyerId);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'buyer_id' => $buyerId,
                'seller_id' => $sellerId,
                'product_id' => $request->product_id
            ]);
        } else {
            // Update product context if provided
            if ($request->product_id) {
                $conversation->update(['product_id' => $request->product_id]);
            }
        }

        return response()->json([
            'success' => true,
            'conversation_id' => $conversation->id
        ]);
    }
}
