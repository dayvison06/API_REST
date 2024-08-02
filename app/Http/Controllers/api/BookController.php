<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function getBooks(){
        $books = Book::all(); // Forma para pegar todos os dados

        return response()->json($books);
    }

    public function getBookForId($id){
        $book = Book::findorFail($id)->first();
        return response()->json($book);
    }

    public function addBook(Request $request){
        $validBook = $request->validate([
            'nome' => 'required|unique:books',
            'autor' => 'required',
            'data_publicacao' => 'required',
        ]);

        Carbon::parse($validBook['data_publicacao'])->format('Y-m-d');

        Book::create($validBook);

        return response()->json([
            'message' => 'Book created successfully'
        ], 201);
    }

    public function updateBook(Request $request, $id){
        $validBook = $request->validate([
            'nome' => 'required|unique:books',
            'autor' => 'required',
            'data_publicacao' => 'required',
        ]);

        Carbon::parse($validBook['data_publicacao'])->format('Y-m-d');

        Book::findorFail($id)->update($validBook);

        return response()->json([
            'message' => 'Book updated successfully'
            ],200);
    }
}
