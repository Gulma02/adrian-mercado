<template>
    <AppLayout>
        <div class="p-6">
            <div class="pb-4 flex justify-end">
                <PrimaryButton @click="openNewAuction">Nueva Subasta</PrimaryButton>
            </div>
            <div class="bg-white rounded-lg w-full">
                <ElTabs class="p-6">
                    <ElTabPane label="Activas">
                        <ActiveAuctionsTab :auctions="activeAuctions" />
                    </ElTabPane>
                    <ElTabPane label="Finalizadas">
                        <FinishedAuctionsTab :finishedAuctions="finishedAuctions"/>
                    </ElTabPane>
                </ElTabs>
            </div>
        </div>
    </AppLayout>

    <AuctionDialog :auctionDialogVisible="newAuctionDialogVisible" @close="newAuctionDialogVisible = false"/>
</template>

<script setup>
    import {useAuctionChannel} from "@/Components/Socket/useAuction.js";
    import {onMounted, provide} from "vue";
    import AppLayout from "@/Layouts/AppLayout.vue";
    import PrimaryButton from "@/Components/PrimaryButton.vue";
    import { ref } from "vue";
    import AuctionDialog from "@/Components/Socket/AuctionDialog.vue";
    import ActiveAuctionsTab from "@/Components/Auctions/ActiveAuctions.vue";
    import FinishedAuctionsTab from "@/Components/Auctions/FinishedAuctions.vue";

    const { auctions } = defineProps({
        auctions: Object,
    })

    const { joinChannel } = useAuctionChannel()

    const newAuctionDialogVisible = ref(false)
    const activeAuctions = ref({})
    const finishedAuctions = ref({})

    onMounted(() => {
        joinChannel(auctions, filterTables)
    })

    const filterTables = () => {
        activeAuctions.value = Object.values(auctions).filter(auction => !auction.finished)
        finishedAuctions.value = Object.values(auctions).filter(auction => auction.finished)
    }

    const openNewAuction = () => {
        newAuctionDialogVisible.value = true
    }

    provide("auctions", { auctionDialogVisible: newAuctionDialogVisible})
</script>
