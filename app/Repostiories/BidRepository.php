<?php

namespace App\Repostiories;

use App\Exceptions\BidAmountException;
use App\Models\Bid;

class BidRepository {
    /**
     * @throws BidAmountException
     */
    public static function createBid(array $data, $auction) {
        $currentMax = max($auction->initial_price, $auction->bids()->max('amount') ?? 0); # Compara el precio inicial contra el maximo postor

        if ($data['amount'] <= $currentMax) {
            throw new BidAmountException();
        }

        return Bid::create([
            'auction_id' => $auction->id,
            'dni'        => $data['dni'],
            'amount'     => $data['amount'],
        ]);
    }
}
