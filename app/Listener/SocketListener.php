<?php

namespace App\Listener;

use App\Actions\CreateAuction;
use App\Actions\PlaceBid;

class SocketListener {
    public function handle(array $payload): void {
        info("MENSAJE RECIBIDO POR SOCKET:", json_encode($payload));
        match ($payload['type']) {
            'create-auction' => CreateAuction::execute($payload['data']),
            'place-bid' => PlaceBid::execute($payload['data']),
            default => null,
        };
    }
}
