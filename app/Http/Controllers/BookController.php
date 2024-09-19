<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // Dohvati sve knjige iz baze
        $books = Book::all();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->price = $request->price;
        $book->stock = $request->stock;
        $book->save();

        return response()->json(['message' => 'Knjiga uspješno dodana!']);
    }

    public function update(Request $request, $id)
    {
        // Validacija podataka
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Pronalaženje knjige na osnovu ID-a
        $book = Book::findOrFail($id);

        // Ažuriranje podataka
        $book->update($validatedData);

        // Vraćanje uspješne poruke
        return response()->json(['message' => 'Knjiga je uspješno ažurirana']);
    }

    public function updateByTitle(Request $request, $title)
    {
        // Pronađi knjigu po naslovu
        $book = Book::where('title', $title)->first();

        // Provjeri postoji li knjiga
        if (!$book) {
            return response()->json(['message' => 'Knjiga nije pronađena'], 404);
        }

        // Ažuriraj knjigu s novim podacima
        $book->price = $request->price;
        $book->stock = $request->stock;
        $book->save();

        return response()->json(['message' => 'Knjiga uspješno ažurirana!']);
    }

    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();

            return response()->json(['message' => 'Knjiga uspješno obrisana!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Greška prilikom brisanja knjige'], 500);
        }
    }
}
