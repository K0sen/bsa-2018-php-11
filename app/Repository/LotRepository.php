<?php

namespace App\Repository;

use App\Entity\Lot;
use App\Repository\Contracts\LotRepository as ILotRepository;

class LotRepository implements ILotRepository
{
    public function add(Lot $lot): Lot
    {
        return Lot::create([
            'currency_id' => $lot->currency_id,
            'seller_id' => $lot->seller_id,
            'date_time_open' => $lot->date_time_open,
            'date_time_close' => $lot->date_time_close,
            'price' => $lot->price
        ]);
    }

    public function getById(int $id): ?Lot
    {
        return Lot::find($id);
    }

    public function findAll()
    {
        return Lot::all();
    }

    public function findActiveLot(int $userId): ?Lot
    {
        return Lot::where(['seller_id' => $userId])->first();
    }

    public function findBySellerAndCurrency(int $userId, int $currencyId): ?Lot
    {
        return Lot::where(['seller_id' => $userId, 'currency_id' => $currencyId])->first();
    }
}
