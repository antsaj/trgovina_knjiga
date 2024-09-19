<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addOrder(Request $request)
    {
        $user = Auth::user();
        $bookId = $request->input('book_id');
        $quantity = $request->input('quantity');

        // Provjeri da li je korisnik prijavljen
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Validiraj unos
        if ($quantity <= 0) {
            return response()->json(['message' => 'Invalid quantity'], 400);
        }

        // Dodaj narudžbu u bazu podataka
        $order = Order::create([
            'user_id' => $user->id,
            'order_date' => now(),
            'total_price' => $this->calculateTotalPrice($bookId, $quantity)
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'book_id' => $bookId,
            'quantity' => $quantity,
            'price' => $this->getBookPrice($bookId)
        ]);

        return response()->json(['message' => 'Order placed successfully']);
    }
    public function checkout(Request $request) {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'delivery' => 'required|string'
        ]);
    
        // Pretpostavimo da ovdje obrađuješ checkout proces i spremaš podatke u bazu
        // Provjeri da li metoda vraća ispravan odgovor
        return response()->json(['message' => 'Kupovina uspješno završena!'], 200);
    }
    

    private function calculateTotalPrice($bookId, $quantity)
    {
        // Funkcija za izračun ukupne cijene (implementiraj prema potrebi)
    }

    private function getBookPrice($bookId)
    {
        // Funkcija za dohvat cijene knjige (implementiraj prema potrebi)
    }
}

