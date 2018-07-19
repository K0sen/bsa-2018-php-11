<?php

namespace App\Request;


use App\Request\Contracts\BuyLotRequest as IBuyLotRequest;

class BuyLotRequest implements IBuyLotRequest
{
    public function getUserId(): int
    {
        // TODO: Implement getUserId() method.
    }

    public function getLotId(): int
    {
        // TODO: Implement getLotId() method.
    }

    public function getAmount(): float
    {
        // TODO: Implement getAmount() method.
    }
}