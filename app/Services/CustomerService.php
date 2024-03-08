<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Customer as CustomerModel;
use App\Transformers\CustomerTransformer;

class CustomerService
{
    public function __construct(protected CustomerModel $model)
    {
    }

    public function getList()
    {
        $customersList = $this->model::all();

        return fractal()
            ->collection($customersList, new CustomerTransformer())
            ->toArray();
    }

    public function getCustomerDetails($id)
    {
        $customer = $this->model->findOrFail($id);
        $borrowedBooks = Book::where('borrower_id', $customer->id)->get();

        $responseData = [
            'first_name'     => $customer->first_name,
            'last_name'      => $customer->last_name,
            'borrowed_books' => [],
        ];


        if ($borrowedBooks->isNotEmpty()) {
            $responseData['borrowed_books'] = $borrowedBooks->map(function ($book) {
                return [
                    'title'            => $book->title,
                    'author'           => $book->author,
                    'publication_year' => $book->publication_year,
                    'publisher'        => $book->publisher,
                    'status'           => $book->status,
                ];
            });

        }

        return $responseData;
    }


//    public function getCustomerDetails($id)
//    {
//        $customer = $this->model->findOrFail($id);
//        $borrowedBooks = Book::where('borrower_id', $customer->id)->get();
//
//        // Inicjalizacja Fractal Managera
//        $fractal = new Manager();
//
//        // Wykorzystanie transformera dla klienta
//        $customerResource = new Item($customer, new CustomerTransformer());
//
//        // Wykorzystanie transformera dla wypożyczonych książek
//        $booksResource = new Collection($borrowedBooks, new BookTransformer());
//
//        // Pobranie przekształconych danych
//        $responseData = [
//            'customer' => $fractal->createData($customerResource)->toArray(),
//            'borrowed_books' => $fractal->createData($booksResource)->toArray(),
//        ];
//
//        $abc = $responseData;
//        dd($abc);
//        return $abc;
//
//    }


    public function create(array $attributes)
    {

        $attributes['user_id'] = 1;

        $customer = $this->model->create($attributes);

        return fractal()
            ->item($customer, new CustomerTransformer())
            ->toArray();
    }

    public function destroy($id)
    {
        $deleted = $this->model->findOrFail($id);
        $deleted->delete();

        return fractal()
            ->item($deleted, new CustomerTransformer())
            ->toArray();
    }

}
