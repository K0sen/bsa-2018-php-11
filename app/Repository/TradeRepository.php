<?php

namespace App\Repository;

use App\Entity\Trade;
use App\Repository\Contracts\TradeRepository as ITradeRepository;

class TradeRepository implements ITradeRepository
{
    public function add(Trade $trade): Trade
    {
        return Trade::create([
            'user_id' => $trade->user_id,
            'lot_id' => $trade->lot_id,
            'amount' => $trade->amount
        ]);
    }
}
