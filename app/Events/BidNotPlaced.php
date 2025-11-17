<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BidNotPlaced implements ShouldBroadcast{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $reason;
    /**
     * Create a new event instance.
     */
    public function __construct(string $reason) {
        $this->reason = $reason;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel {
        return new Channel('auctions');
    }

    public function broadcastWith(): array {
        return [
            'reason' => $this->reason,
        ];
    }

    public function broadcastAs(): string {
        return 'bid.not-placed';
    }
}
