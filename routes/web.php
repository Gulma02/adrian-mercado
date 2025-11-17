<?php

use App\Http\Controllers\AuctionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [AuctionController::class, "index"])->name("auction.index");

Route::group(["prefix" => "auction"], function () {
   Route::post("store", [AuctionController::class, "createAuction"])->name("auction.store");
   Route::post("{auctionId}/bid", [AuctionController::class, "placeBid"])->name("auction.bid");
});
