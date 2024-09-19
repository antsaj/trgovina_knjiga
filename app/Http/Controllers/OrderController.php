<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $book = Book::find($request->book_id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        if ($book->stock < $request->quantity) {
            return response()->json(['message' => 'Not enough stock'], 400);
        }

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'order_date' => now(),
            'total_price' => $book->price * $request->quantity,
        ]);

        // Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'book_id' => $book->id,
            'quantity' => $request->quantity,
            'price' => $book->price,
        ]);

        // Update book stock
        $book->stock -= $request->quantity;
        $book->save();

        // Return orderId in response so it can be used later for cancellation
        return response()->json([
            'message' => 'Order successfully created!',
            'orderId' => $order->id, // Return orderId
        ]);
    }

    public function getCartItems(Request $request)
    {
        $user = $request->user();
        
        $orders = Order::where('user_id', $user->id)
                    ->with('orderItems.book') // Load order items and the book details
                    ->get();
        
        return response()->json($orders);
    }

    public function checkout(Request $request)
    {
        $user = $request->user();
        $orders = Order::where('user_id', $user->id)->get();

        // Process payment or any additional steps here
        // Clear user's cart
        foreach ($orders as $order) {
            $order->delete();
        }

        return response()->json(['message' => 'Checkout completed']);
    }

    public function cancelOrder($orderId, Request $request)
    {
        $user = $request->user(); // Dohvati prijavljenog korisnika

        // Pronađi narudžbu
        $order = Order::where('user_id', $user->id)->findOrFail($orderId);

        // Prođi kroz sve stavke narudžbe
        foreach ($order->orderItems as $item) {
            // Povećaj stock za odgovarajuću knjigu
            $book = Book::findOrFail($item->book_id);
            $book->stock += $item->quantity;
            $book->save();
        }

        // Izbriši stavke narudžbe
        $order->orderItems()->delete();

        // Izbriši narudžbu
        $order->delete();

        return response()->json(['message' => 'Narudžba uspješno poništena i stock ažuriran!'], 200);
    }
}
