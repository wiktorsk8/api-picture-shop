<?php

namespace App\Http\Controllers\Api;

use App\DTO\UserInfoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\PaymentsService;


class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->authorizeResource(Order::class, 'order');
    }

    public function index()
    {
        return Order::all();
    }

    public function store(StoreOrderRequest $request)
    {
        (array)$product_ids = $request->product_id;

        $dto = new UserInfoDTO(

            $request->first_name,
            $request->last_name,
            $request->email,
            $request->phone,
            $request->city,
            $request->postal_code,
            $request->street_name,
            $request->street_number,
            $request->flat_number,
            $request->company_name,
            $request->NIP,
            $request->extra_info,
        );

        $order = $this->orderService->store($dto, $product_ids);

        $orderResource = new OrderResource($order);

        return $orderResource;
    }   


    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $updatedOrder = $this->orderService->update($request, $order);

        return new OrderResource($updatedOrder);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(['message' => 'Order deleted succesfully'], 200);
    }

    public function tracking($id)
    {
        $orders = Order::where('user_id', '=', $id)->get();

        return OrderResource::collection($orders);
    }

    public function trackingGuest(Order $order)
    {
        $this->authorize('trackingGuest', $order);

        return new OrderResource($order);
    }
}
