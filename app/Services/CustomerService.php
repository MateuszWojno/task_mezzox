<?php

namespace App\Services;

use App\Models\Customer as CustomerModel;
use App\Transformers\CustomerTransformer;

class CustomerService
{
    public function __construct(protected CustomerModel $model)
    {
    }


    public function create(array $attributes)
    {

        $attributes['user_id'] = 1;

        $customer = $this->model->create($attributes);

        return fractal()
            ->item($customer, new CustomerTransformer())
            ->toArray();
    }

}
