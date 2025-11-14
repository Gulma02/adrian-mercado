<?php

namespace App\Actions;

use App\Events\BidNotPlaced;
use App\Events\BidPlaced;
use App\Exceptions\BidAmountException;
use App\Repostiories\AuctionRepository;
use App\Repostiories\BidRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class PlaceBid {
    public static function execute(array $data): void {
        try {
            $auction = AuctionRepository::getAuctions($data['auction_id'])->first();
            $bid = BidRepository::createBid($data, $auction);
            broadcast(new BidPlaced($bid));
        } catch (BidAmountException) {
            broadcast(new BidNotPlaced("Su monto ha sido superado"));
        } catch (Exception $ex) {
            Log::error("Error placing bid: {$ex->getMessage()}" . json_encode($ex->getTrace()));
            broadcast(new BidNotPlaced("Error al realizar la oferta. Contactar con soporte"));
        }
    }
}
