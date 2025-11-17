<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('auctions', fn (): bool => true);
