<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    use EnumToArray;

    case new = 'новый';
    case processed = 'в обработке';
    case shipped = 'отправлен';
    case delivered = 'доставлен';
}
