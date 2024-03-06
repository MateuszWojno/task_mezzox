<?php

namespace App\Transformers;

use App\Models\Book;
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract
{


    public function transform(Book $book)
    {
        $borrower = $book->borrower;
        return [
            'title'            => $book->title,
            'author'           => $book->author,
            'publication_year' => $book->publication_year,
            'publisher'        => $book->publisher,
            'status'           => $book->status,
            'borrower' => $borrower ? [
                'first_name' => $borrower->first_name,
                'last_name' => $borrower->last_name
            ] : null

        ];
    }




}
