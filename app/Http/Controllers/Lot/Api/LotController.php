<?php

namespace App\Http\Controllers\Lot\Api;


use App\Http\Controllers\Controller;
use App\Repository\Contracts\LotRepository;
use App\Request\BuyLotRequest;
use App\Request\Contracts\AddLotRequest;
use App\Service\MarketService;

class LotController extends Controller
{
    private $lotRepository;
    private $marketService;

    /**
     * LotController constructor.
     *
     * @param LotRepository $lotRepository
     * @param MarketService $marketService
     */
    public function __construct(LotRepository $lotRepository, MarketService $marketService)
    {
        $this->lotRepository = $lotRepository;
        $this->marketService = $marketService;
    }

    public function getLot($id)
    {
        $lot = $this->lotRepository->getById($id);
        if (!$lot) {
            return response()->json(['error' => [
                'message' => 'Have no lot with the id',
                'status_code' => 400
            ]], 400);
        }

        return response()->json($lot);
    }

    public function getLots()
    {
        $lots = $this->lotRepository->findAll();
        if (!$lots) {
            return response()->json(['error' => [
                'message' => 'Have no lots',
                'status_code' => 400
            ]], 400);
        }

        return response()->json($lots);
    }

    public function addLot(AddLotRequest $addLotRequest)
    {
        $lot = $this->marketService->addLot($addLotRequest);

        return response()->json($lot);
    }

    public function addTrade(BuyLotRequest $buyLotRequest)
    {
        $lot = $this->marketService->buyLot($buyLotRequest);

        return response()->json($lot);
    }
}