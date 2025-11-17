<?php

namespace App\Actions;

use App\Events\AuctionFinished;
use App\Events\BidNotPlaced;
use App\Events\BidPlaced;
use App\Exceptions\AuctionClosedException;
use App\Exceptions\BidAmountException;
use App\Repostiories\AuctionRepository;
use App\Repostiories\BidRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class PlaceBid {
    public static function execute(array $data, int $auctionId): void {
        try {
            $auction = AuctionRepository::getAuctions($auctionId)->first();
            $bid = BidRepository::createBid($data, $auction);
            broadcast(new BidPlaced($bid));
        } catch (BidAmountException) {
            Log::info("El monto debe ser superior al anterior.");
            broadcast(new BidNotPlaced("Su monto ha sido superado"));
        } catch (AuctionClosedException) {
            Log::info("La subasta ya ha finalizado.");
            broadcast(new BidNotPlaced("La subasta ya ha finalizado"));
            broadcast(new AuctionFinished($auctionId));
        } catch (Exception $ex) {
            Log::error("Error placing bid: {$ex->getMessage()}" . json_encode($ex->getTrace()));
            broadcast(new BidNotPlaced("Error al realizar la oferta. Contactar con soporte"));
        }
    }
}
