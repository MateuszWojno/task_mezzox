<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Book as BookModel;
use App\Models\Customer;
use App\Transformers\BookTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class BookService
{
    public function __construct(protected BookModel $model)
    {
    }

    public function getList()
    {
        $booksList = $this->model::with('borrower')->paginate(20);

        return fractal()
            ->collection($booksList, function ($book) {
                return [
                    'id'       => $book->id,
                    'title'    => $book->title,
                    'author'   => $book->author,
                    'borrower' => $book->borrower ? [
                        'first_name' => $book->borrower->first_name,
                        'last_name'  => $book->borrower->last_name
                    ] : null
                ];
            })
            ->toArray();
    }

    public function getItem($id)
    {
        $customer = $this->model->findOrFail($id);

        return fractal()
            ->item($customer, new BookTransformer())
            ->toArray()['data'];
    }

    public function borrowBook($customerId, $bookId)
    {
        $customer = Customer::findOrFail($customerId);
        $book = Book::findOrFail($bookId);

        if ($book->status === 'av') {
            $book->status = 'unav';
            $book->borrower_id = $customer->id;
            $book->save();

            return fractal()->item($book, new BookTransformer())->toArray();

        } else {
            return response()->json(['message' => 'Book is not available for borrowing']);
        }
    }

    public function returnBook($customerId, $bookId)
    {
        $customer = Customer::findOrFail($customerId);
        $book = Book::findOrFail($bookId);

        if ($book->status === 'unav') {
            $book->status = 'av';
            $book->borrower_id = null;
            $book->save();

            return fractal()->item($book, new BookTransformer())->toArray();
        } else {
            return response()->json(['message' => 'This book is not borrowed by this customer']);
        }
    }


    public function searchBook($search)
    {
        $books = Book::where('title', 'like', '%' . $search . '%')
            ->orWhere('author', 'like', '%' . $search . '%')
            ->orWhereHas('borrower_id', function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%');
            })
            ->paginate(20);


        return fractal()
            ->collection($books->items(), new BookTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($books))
            ->toArray();

    }


}
