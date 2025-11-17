<?php

namespace App\Actions;

use App\Events\AuctionCreated;
use App\Events\AuctionCreationFailed;
use App\Repostiories\AuctionRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateAuction {
    /**
     * @throws Exception
     */
    public static function execute(array $data): void {
        try {
            $auction = AuctionRepository::storeAuction($data);
            broadcast(new AuctionCreated($auction));
        } catch (Exception $ex) {
            Log::error("Error creating auction: {$ex->getMessage()}" . json_encode($ex->getTrace()));
            throw new Exception();
        }
    }
}
