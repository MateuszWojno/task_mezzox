<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    public function __construct(protected CustomerService $service)
    {
    }

    public function index()
    {
        $customers = $this->service->getList();

        return response()->json($customers);
    }

    public function show($id)
    {
        $customerDetails = $this->service->getCustomerDetails($id);

        return response()->json($customerDetails);
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

    public function destroy($id)
    {
        $result = $this->service->destroy($id);

        return response()->json([
            'message' => 'Customer has been deleted!'
        ]);
    }
}
