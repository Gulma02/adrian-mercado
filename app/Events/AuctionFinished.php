<?php

namespace App\Events;

use App\Models\Auction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionFinished implements ShouldBroadcast {
    use SerializesModels, Dispatchable, InteractsWithSockets;

    public function __construct(public int $auctionId) {}

    public function broadcastOn(): Channel {
        return new Channel("auctions");
    }

    public function broadcastAs(): string {
        return 'auction.finished';
    }
}
