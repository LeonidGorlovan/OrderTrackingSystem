<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function getAll(): LengthAwarePaginator
    {
        return Order::query()->orderBy('id')->paginate();
    }

    public function getOne(int|null $id): Order|Collection|Builder|array|null
    {
        return Order::query()->findOrFail($id);
    }

    public function save(array $data): Order|Collection|Builder|array|null
    {
        return Order::query()->create($data);
    }

    public function update(int $id, array $data): Order|Collection|Builder|array|null
    {
        $order = Order::query()->findOrFail($id);

        if(!empty($order)) {
            $order->update($data);
        }

        return $order;
    }

    public function destroy(int $id): bool
    {
        $order = Order::query()->find($id);

        if(!empty($order)) {
            $order->delete();
            return true;
        }

        return false;
    }

    public function changeStatus(int $id, array $data): Order
    {
        $order = Order::query()->findOrFail($id);

        if(!empty($order)) {
            $order->status = $data['status'];
            $order->save();
        }

        return $order;
    }
}
