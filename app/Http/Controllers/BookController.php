<?php

namespace App\Http\Controllers;

use App\Services\BookService;

class BookController extends Controller
{

    public function __construct(protected BookService $service)
    {
    }

    public function index()
    {
        $customers = $this->service->getList();

        return response()->json($customers);

    }


    public function show($id)
    {
        $book = $this->service->getItem($id);

        return response()->json([
            'data' => $book
        ]);

    }

    public function borrowBook($customerId, $bookId)
    {
        $borrowedBook = $this->service->borrowBook($customerId, $bookId);

        return response()->json($borrowedBook);
    }

    public function returnBook($customerId, $bookId)
    {
        $returnedBook = $this->service->returnBook($customerId, $bookId);

        return response()->json($returnedBook);
    }

    public function searchBook($search)
    {
        $result = $this->service->searchBook($search);

        return response()->json([
            'data' => $result
        ]);
    }
}
