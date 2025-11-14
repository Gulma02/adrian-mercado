<?php

namespace App\Events;

use App\Models\Auction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class AuctionCreated implements ShouldBroadcast {
    use SerializesModels;

    public function __construct(public Auction $auction) {}

    public function broadcastOn(): Channel {
        return new Channel('auctions'); // canal público general de subastas
    }

    public function broadcastAs(): string {
        return 'auction.created';
    }
}
