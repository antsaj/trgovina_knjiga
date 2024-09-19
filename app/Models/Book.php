<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Definiraj naziv tablice ako se ne poklapa s nazivom modela
    protected $table = 'books';

    // Popis atributa koji se mogu masovno dodijeliti
    protected $fillable = ['title', 'author', 'price', 'stock'];
}

