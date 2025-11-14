<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('auctions', fn (): bool => true);

Broadcast::channel('auctions.{auctionId}', fn ($user, $auctionId): bool => true);
