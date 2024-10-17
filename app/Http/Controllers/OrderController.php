<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\ChangeStatusOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Notifications\OrderChangeStatusNotification;
use App\Notifications\OrderNewNotification;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        return OrderResource::collection($this->orderService->getAll());
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            $order = $this->orderService->save($request->validated());

            Auth::user()->notify(new OrderNewNotification($order));

            return OrderResource::make($order);
        } catch (\Throwable $exception) {
            Log::error('failed to create an order');

            return response()->json([
                'result' => false,
                'message' => 'failed to create an order',
                'description' => $exception->getMessage(),
            ], 400);
        }
    }

    public function show($order)
    {
        try {
            return OrderResource::make($this->orderService->getOne($order));
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'result' => false,
                'message' => 'could not find order by id ' . $order,
                'description' => $exception->getMessage(),
            ], 400);
        }
    }

    public function update(UpdateOrderRequest $request, $order)
    {
        try {
            $order = $this->orderService->update($order, $request->validated());
            return OrderResource::make($order);
        } catch (ModelNotFoundException $exception) {
            Log::error('could not find an order for id ' . $order . ' for the update');

            return response()->json([
                'result' => false,
                'message' => 'could not find an order for id ' . $order . ' for the update',
                'description' => $exception->getMessage(),
            ], 400);
        }
    }

    public function destroy($order)
    {
        if($this->orderService->destroy($order)) {
            return response()->json([
                'status' => true,
                'message' => 'Order deleted'
            ]);
        }

        Log::error('failed to delete order for id ' . $order);

        return response()->json([
            'status' => false,
            'message' => 'failed to delete order for id ' . $order,
        ], 400);
    }

    public function changeStatus(ChangeStatusOrderRequest $request, $order)
    {
        try {
            $order = $this->orderService->changeStatus($order, $request->validated());

            Auth::user()->notify(new OrderChangeStatusNotification($order, $request->validated()));

            return response()->json([
                'result' => true,
                'message' => 'status update',
            ]);
        } catch (ModelNotFoundException $exception) {
            Log::error('could not find an order for id ' . $order . ' for the update status');

            return response()->json([
                'result' => false,
                'message' => 'could not find an order for id ' . $order . ' for the update status',
                'description' => $exception->getMessage(),
            ], 400);
        }
    }

    public function listStatus()
    {
        return OrderStatusEnum::array();
    }
}
