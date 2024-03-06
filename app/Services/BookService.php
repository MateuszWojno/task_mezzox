<?php

namespace App\Services;

use App\Models\Book as BookModel;
use App\Transformers\BookTransformer;

class BookService
{
    public function __construct(protected BookModel $model)
    {
    }

    public function getItem($id)
    {
        $customer = $this->model->findOrFail($id);

        return fractal()
            ->item($customer, new BookTransformer())
            ->toArray()['data'];
    }


}
