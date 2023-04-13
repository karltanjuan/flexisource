<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = DB::table('customers')
                        ->select(DB::raw("CONCAT(first_name, ' ', last_name) AS full_name"), 'email', 'country')
                        ->get();

        return response()->json($customers);
    }

    public function show($customerId)
    {
        $customer = DB::table('customers')
                        ->select(DB::raw("CONCAT(first_name, ' ', last_name) AS full_name"), 'email', 'gender', 'country', 'city', 'phone')
                        ->where('id', $customerId)
                        ->first();

        return response()->json($customer);
    }
}
