<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    public function __construct(protected CustomerService $service)
    {
    }


    public function store(StoreCustomerRequest $request)
    {
        $inputs = $request->validated();
        $result = $this->service->create($inputs);

        return response()->json([
            'data'    => $result,
            'message' => 'Customer has been created!'
        ]);
    }


}
