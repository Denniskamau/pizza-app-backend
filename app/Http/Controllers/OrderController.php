<?php

namespace App\Http\Controllers;

use App\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function index()
    {
        return Orders::all();
    }

    public function show(Orders $order)
    {
        return $order;
    }

    public function store(Request $request)
    {
        return Orders::create($request->all());
    }

    public function update(Request $request, Orders $order)
    {

        $order->update($request->all());

        return response() ->json($order,200);
    }

    public function delete(Orders $order)
    {

        $order->delete();

        return response() ->json(null,204);
    }
}
