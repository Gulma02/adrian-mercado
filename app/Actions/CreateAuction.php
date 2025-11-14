<?php

namespace App\Actions;

use App\Events\AuctionCreated;
use App\Events\AuctionCreationFailed;
use App\Repostiories\AuctionRepository;
use Exception;

class CreateAuction {
    public static function execute(array $data): void {
        try {
            $auction = AuctionRepository::storeAuction($data);
            broadcast(new AuctionCreated($auction))->toOthers();
        } catch (Exception) {
            broadcast(new AuctionCreationFailed());
        }
    }
}
