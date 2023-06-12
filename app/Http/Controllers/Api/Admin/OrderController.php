<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\DTO\OrderDTO;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
//        $this->authorizeResource(Order::class, 'order');
    }

    public function index(){
        return response()->json(Order::all());
    }

    public function store(StoreOrderRequest $request){
        $orderData = new OrderDTO(
            $request->product_id,
            $request->customer_id,
            $request->city,
            $request->postal_code,
            $request->street_name,
            $request->street_number,
            $request->flat_number,
        );

        $order = $this->orderService->store($orderData);

        return new OrderResource($order);
    }

    public function show(Order $order){
        return response()->json($order);
    }

    public function update(UpdateOrderRequest $request){
        return throw new Exception('Checkout not made yet');
    }

    public function destroy(Order $order){
        $order->delete();

        return response()->json(['message' => 'Product deleted succesfully'], 200);
    }
}
