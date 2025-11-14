<?php

namespace App\Repostiories;

use App\Models\Auction;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AuctionRepository {
    /**
     * @throws Exception
     */
    public static function storeAuction(array $auctionData) {
        try {
            return Auction::create([
                'seller_name'   => $auctionData['seller_name'],
                'description'   => $auctionData['description'],
                'initial_price' => $auctionData['initial_price'],
                'scheduled_at'  => $auctionData['scheduled_at'],
            ]);
        } catch (QueryException $ex) {
            Log::error("There was an error creating the auction: {$ex->getMessage()}");
            throw new Exception("Error creating auction.");
        }
    }

    public static function getAuctions(?int $auctionId = null): Collection {
        return Auction::when($auctionId, fn($query) => $query->whereKey($auctionId))->get();
    }
}
