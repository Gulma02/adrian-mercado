<template>
    <ElTable :data="Object.values(finishedAuctions)" stripe>
        <ElTableColumn label="Descripción" prop="description">
            <template #default="{row}">
                {{row.description}}
            </template>
        </ElTableColumn>
        <ElTableColumn label="Vendedor" prop="seller_name">
            <template #default="{row}">
                {{row.seller_name}}
            </template>
        </ElTableColumn>
        <ElTableColumn label="Precio ganador" prop="price">
            <template #default="{row}">
                {{row.price}}
            </template>
        </ElTableColumn>
        <ElTableColumn label="&nbsp;" align="right">
            <template #default="{row}">
                <ElIcon
                    class="hover:text-blue-500 hover:scale-125"
                    @click="viewAuctionDetail(row)"
                >
                    <View />
                </ElIcon>
            </template>
        </ElTableColumn>
    </ElTable>

    <FinishedAuctionDetail />
</template>

<script setup lang="ts">
    import {View} from "@element-plus/icons-vue";
    import {provide, ref} from "vue";
    import FinishedAuctionDetail from "@/Components/Auctions/FinishedAuctionDetail.vue";

    const { finishedAuctions } = defineProps({
        finishedAuctions: Object
    })

    const activeAuction = ref({})
    const auctionDetailDialogVisible = ref(false)

    const viewAuctionDetail = (auction) => {
        activeAuction.value = auction
        auctionDetailDialogVisible.value = true
    }

    provide("finishedAuction", { activeAuction, auctionDetailDialogVisible })
</script>
