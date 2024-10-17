<?php

namespace App\Notifications;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderChangeStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Order $order;
    private array $postData;

    public function __construct(Order $order, array $postData)
    {
        $this->order = $order;
        $this->postData = $postData;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $orderStatusEnum = OrderStatusEnum::array();

        return (new MailMessage)
                    ->line('Статус заказа "' . $this->order->product_name . '" изменён на - ' . data_get($orderStatusEnum, $this->postData['status']))
                    ->line('Спасибо за заказ!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
