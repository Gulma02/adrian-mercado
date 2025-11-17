<?php

namespace App\Http\Controllers;

use App\Actions\CreateAuction;
use App\Actions\PlaceBid;
use App\Http\Requests\AuctionRequest;
use App\Http\Requests\BidRequest;
use App\Repostiories\AuctionRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class AuctionController extends Controller {
    public function index() {
        return Inertia::render('Home', [
            "auctions" => AuctionRepository::getAuctionsTableData(),
        ]);
    }

    public function placeBid(BidRequest $request, int $auctionId): RedirectResponse {
        try {
            (new PlaceBid())->execute($request->validated(), $auctionId);
            return back()->with(["status" => "OK", "errMsg" => ""]);
        } catch (Exception $ex) {
            return back()->withErrors(["errMsg" => "Se produjo un error al poner el precio."]);
        }
    }

    public function createAuction(AuctionRequest $request): RedirectResponse {
        try {
            (new CreateAuction())->execute($request->validated());
            return back()->with(["status" => "OK", "errMsg" => ""]);
        } catch (Exception) {
            return back()->withErrors(["errMsg" => "Se produjo un error al crear la subasta."]);
        }
    }
}
