<?php

namespace App\Enums;

class PaymentMethod
{
    const Cash   = 'Cash';
    const Online = 'Online';
    const Cheque = 'Cheque';
    // const Due = 'Due';
    const Other  = 'Other';

    public static function values(): array
    {
        return [
            self::Cash,
            self::Online,
            self::Cheque,
            self::Other,
        ];
    }
}
