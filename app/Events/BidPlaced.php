<?php

namespace App\Events;

use App\Models\Bid;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class BidPlaced implements ShouldBroadcast {
    use SerializesModels;

    public function __construct(public Bid $bid) {}

    public function broadcastOn(): Channel {
        return new Channel("auctions.{$this->bid->auction_id}");
    }

    public function broadcastAs(): string {
        return 'bid.placed';
    }
}
