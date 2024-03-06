<?php

namespace App\Http\Controllers;

use App\Services\BookService;

class BookController extends Controller
{

    public function __construct(protected BookService $service)
    {
    }


    public function show($id)
    {
        $book = $this->service->getItem($id);

        return response()->json([
            'data' => $book
        ]);

    }
}
