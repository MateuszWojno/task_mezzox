<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Book as BookModel;
use App\Models\Customer;
use App\Transformers\BookTransformer;

class BookService
{
    public function __construct(protected BookModel $model)
    {
    }

    public function getList()
    {
        $customersList = $this->getPaginatedData();

        $transformedData = $this->transformData($customersList->getCollection());

        return [
            'data' => $transformedData,
            'meta' => [
                'total' => $customersList->total(),
                'per_page' => $customersList->perPage(),
                'current_page' => $customersList->currentPage(),
                'last_page' => $customersList->lastPage(),
            ]
        ];
    }

    protected function getPaginatedData()
    {
        $perPage = 20;
        return $this->model::paginate($perPage);
    }

    protected function transformData($data)
    {
        return $data->map(function($customer) {
            return [
                'author' => $customer->author,
                'status' => $customer->status,
                'borrower' => [
                    'first_name' => $customer->borrower->first_name,
                    'last_name' => $customer->borrower->last_name,
                ]
            ];
        });
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
            return response()->json(['message' => 'This book is not borrowed by this customer'] );
        }
    }


}
