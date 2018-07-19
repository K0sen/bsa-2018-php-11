<?php

namespace App\Repository;

use App\Entity\Lot;
use App\Repository\Contracts\LotRepository as ILotRepository;

class LotRepository implements ILotRepository
{
    public function add(Lot $lot): Lot
    {
        // TODO: Implement add() method.
    }

    public function getById(int $id): ?Lot
    {
        // TODO: Implement getById() method.
    }

    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    public function findActiveLot(int $userId): ?Lot
    {
        // TODO: Implement findActiveLot() method.
    }
}
