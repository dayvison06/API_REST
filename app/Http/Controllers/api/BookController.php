<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class BookController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v1/books",
     *     summary="Exibir livros",
     *     tags={"Books"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de livros",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="ID do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Título do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="autor",
     *                     type="string",
     *                     description="Autor do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="data_publicacao",
     *                     type="string",
     *                     format="date",
     *                     description="Data de publicação do livro"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *      security={{"bearer":{}}},
     * )
     */

    public function getBooks(){
        $books = Book::all(); // Forma para pegar todos os dados

        return response()->json($books);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/book/{id}",
     *     summary="Exibir livro",
     *     tags={"Books"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *          description="ID do livro desejado"
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Livro correspondente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="ID do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Nome do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="autor",
     *                     type="string",
     *                     description="Autor do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="data_publicacao",
     *                     type="date",
     *                     format="date",
     *                     description="Data de publicação do livro"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     security={{"bearer":{}}},
     * )
     */

    public function getBookForId($id){
        $book = Book::findorFail($id)->first();
        return response()->json($book);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/books",
     *     summary="Cadastrar livro",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="nome",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         description="Nome"
     *     ),
     *     @OA\Parameter(
     *          name="autor",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          ),
     *          description="Autor"
     *      ),
     *     @OA\Parameter(
     *          name="data_publicacao",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="date"
     *          ),
     *          description="Data de publicacao"
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Livro adicionado a biblioteca",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="ID do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Título do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="autor",
     *                     type="string",
     *                     description="Autor do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="data_publicacao",
     *                     type="date",
     *                     format="date",
     *                     description="Data de publicação do livro"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     security={{"bearer":{}}},
     * )
     */

    public function addBook(Request $request){
        $validBook = $request->validate([
            'nome' => 'required|unique:books',
            'autor' => 'required',
            'data_publicacao' => 'required|date:d-m-Y',
        ]);

        Carbon::parse($validBook['data_publicacao'])->format('Y-m-d');

        Book::create($validBook);

        return response()->json([
            'message' => 'Book created successfully'
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/book/",
     *     summary="Atualizar informações do livro",
     *     tags={"Books"},
     *          @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  description="ID do livro"
     *              ),
     *              @OA\Property(
     *                  property="nome",
     *                  type="string",
     *                  description="Título do livro"
     *              ),
     *              @OA\Property(
     *                   property="autor",
     *                   type="string",
     *                   description="Autor do livro"
     *               ),
     *              @OA\Property(
     *                   property="data_publicacao",
     *                   type="string",
     *                   description="Data de publicação do livro"
     *               )
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Informações do livro atualizada!",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="ID do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Título do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="autor",
     *                     type="string",
     *                     description="Autor do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="data_publicacao",
     *                     type="string",
     *                     format="date",
     *                     description="Data de publicação do livro"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     security={{"bearer":{}}},
     * )
     */

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

    /**
     * @OA\Delete(
     *     path="/api/v1/book/{id}",
     *     summary="Remover livro",
     *     tags={"Books"},
     *     @OA\Parameter(
     *          name="ID",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *          description="ID do livro desejado"
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Livro excluído",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="ID do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Nome do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="autor",
     *                     type="string",
     *                     description="Autor do livro"
     *                 ),
     *                 @OA\Property(
     *                     property="data_publicacao",
     *                     type="string",
     *                     format="date",
     *                     description="Data de publicação do livro"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     security={{"bearer":{}}},
     * )
     */

    public function deleteBook($id){
        $book = Book::findorFail($id);
        $book->delete();
    }
}
