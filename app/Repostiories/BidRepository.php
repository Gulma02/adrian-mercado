<?php

namespace App\Repostiories;

use App\Exceptions\AuctionClosedException;
use App\Exceptions\BidAmountException;
use App\Models\Bid;

class BidRepository {
    /**
     * @throws BidAmountException
     * @throws AuctionClosedException
     */
    public static function createBid(array $data, $auction) {
        if ($data['amount'] <= $auction->bids()->max('amount') ?? 0 || $data["amount"] < $auction->initial_price) {
            throw new BidAmountException();
        }

        if ($auction->scheduled_at < now()) {
            throw new AuctionClosedException();
        }

        return Bid::create([
            'auction_id' => $auction->id,
            'document'        => $data['dni'],
            'amount'     => $data['amount'],
        ]);
    }
}
