<template>
    <ElDialog v-model="auctionDetailDialogVisible">
        <div class="flex p-4">
            <div class="w-1/2">
                <h1 class="text-[24px] text-gray-700 font-bold">Detalle subasta:</h1>
                <h2 class="text-[18px] text-gray-700 font-bold">Descripción: {{activeAuction.description}}</h2>
                <h2 class="text-[16px] text-gray-600">Vendedor: {{activeAuction.seller_name}}</h2>
            </div>
            <div class="w-1/2">
                <div class="p-6 border rounded-lg">
                    <div v-if="activeAuction.bids.length > 0">
                        <h3 class="text-[14px] font-bold">Ganador: {{activeAuction.bids[activeAuction.bids.length -1].document}}</h3>
                        <h2 class="text-[14px]">Precio: ${{activeAuction.bids[activeAuction.bids.length -1].amount}}</h2>
                    </div>
                    <div v-else>
                        <h3 class="text-[14px] font-bold">Esta subasta finalizo sin un ganador.</h3>
                    </div>
                </div>
            </div>
        </div>
    </ElDialog>
</template>

<script setup lang="ts">
    import {inject, ref, watch} from "vue";
    import {dayjs} from "element-plus";
    import {useForm} from "@inertiajs/vue3";

    const { auctionDetailDialogVisible, activeAuction} = inject("finishedAuction")

    const countdown = ref(null)
    const bidForm = useForm({amount: 0, dni: ""})

    watch(auctionDetailDialogVisible, () => {
        if (auctionDetailDialogVisible.value) {
            countdown.value = dayjs(activeAuction.value.scheduled_at)
            bidForm.amount = Number(activeAuction.value.price)
            bidForm.dni = localStorage.getItem("dni") ?? ""
        }
    })
</script>
