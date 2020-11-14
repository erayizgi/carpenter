<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'products' => 'required|array'
        ]);
        $orderService = new OrderService();

        $createdOrder = $orderService->create($request->all());
        if(!$createdOrder){
            return response()->json(['message'=> 'something went wrong'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['message'=> 'Order created','data'=> $createdOrder], Response::HTTP_CREATED);
    }
    public function getOrders(Request $request)
    {
        $orderService = new OrderService();
        $orders = $orderService->getOrders();
        return response()->json(['message'=> 'Orders', 'data' => $orders], Response::HTTP_OK);
    }
}
