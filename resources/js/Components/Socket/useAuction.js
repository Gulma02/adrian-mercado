import {useEchoPublic} from "@laravel/echo-vue";
import {ElNotification} from "element-plus";

export function useAuctionChannel() {
    return { joinChannel }
}

const joinChannel = (auctions, filterTables) =>  {
    useEchoPublic("auctions", ".bid.placed", (e) => {placeNewBid(e, auctions)}).listen()
    useEchoPublic("auctions", ".bid.not-placed", (e) => { displayError(e) }).listen()
    useEchoPublic("auctions", ".auction.finished", (e) => { closeAuction(e, auctions, filterTables) }).listen()
    useEchoPublic("auctions", ".auction.created", (e) => { addAuction(e, auctions, filterTables) }).listen()
    filterTables()
}

const placeNewBid = (e, auctions) => {
    const auction = auctions[e.bid.auction_id] ?? null
    if ((isNaN(Number(auction.price)) && Number(e.bid.amount) >= Number(auction.initial_price)) || Number(e.bid.amount) > Number(auction.price)) {
        auction.price = Number(e.bid.amount).toFixed(2)
        if (auction.bids === undefined || auction.bids === null) {
            auction.bids = []
        }

        auction.bids.push(e.bid)
    }
}

const closeAuction = (e, auctions, filterTables) => {
    auctions[e.auctionId].finished = true
    filterTables()
}

const addAuction = (e, auctions, filterTables) => {
    auctions[e.auction.id] = e.auction

    filterTables()
}

const displayError = (e) => {
    ElNotification({
        type: "info",
        message: e.reason,
        position: 'bottom-right',
    })
}
