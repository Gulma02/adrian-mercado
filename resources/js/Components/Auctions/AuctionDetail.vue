<template>
    <ElDialog v-model="auctionDetailDialogVisible">
        <div class="flex p-4">
            <div class="w-1/2 flex flex-col justify-between">
                <div>
                    <h1 class="text-[24px] text-gray-700 font-bold">Detalle subasta:</h1>
                    <h2 class="text-[18px] text-gray-700 font-bold">Descripción: {{activeAuction.description}}</h2>
                    <h2 class="text-[16px] text-gray-600">Vendedor: {{activeAuction.seller_name}}</h2>
                </div>

                <div class="bottom-0">
                    <p>Finaliza en: </p>
                    <ElCountdown :value="countdown"></ElCountdown>
                </div>
            </div>
            <div class="w-1/2 h-72 max-h-72 overflow-y-scroll" ref="bidsRef">
                <div v-for="bid of activeAuction.bids" class="w-full border rounded-lg p-6 mb-2">
                    <h3 class="text-[14px] font-bold">{{bid.document}}</h3>
                    <h2 class="text-[16px]">ha postado ${{bid.amount}}</h2>
                </div>
            </div>
        </div>
        <div class="flex mt-4">
            <ElInput v-model="bidForm.dni" placeholder="Documento" class="mr-2"/>
            <ElInput
                placeholder="Subasta"
                type="number"
                :min="Number(activeAuction.price) + 1"
                v-model="bidForm.amount"
                class="mr-2"
            />
            <ElButton type="primary" @click="submitBid">Envíar subasta</ElButton>
        </div>
    </ElDialog>
</template>

<script setup lang="ts">
import {inject, onMounted, ref, watch} from "vue";
    import {dayjs, ElNotification} from "element-plus";
    import {useForm} from "@inertiajs/vue3";

    const { auctionDetailDialogVisible, activeAuction} = inject("auctionDetail")

    const countdown = ref(null)
    const bidForm = useForm({amount: 0, dni: ""})

    watch(auctionDetailDialogVisible, () => {
        if (auctionDetailDialogVisible.value) {
            countdown.value = dayjs(activeAuction.value.scheduled_at)
            bidForm.amount = (activeAuction.value.price) ? Number(activeAuction.value.price) + 1 : activeAuction.value.inital_price
            bidForm.dni = localStorage.getItem("dni") ?? ""
        }
    })

    const submitBid = () => {
        bidForm.post(route("auction.bid", {auctionId: activeAuction.value.id}), {
            onSuccess: () => {
                localStorage.setItem("dni", bidForm.dni)
            },
            onError: () => {
                ElNotification({
                    title: "Error",
                    message: "No se pudo enviar la puja. Verifique los datos e intente nuevamente.",
                    type: "error",
                    position: "bottom-right",
                })
            }
        })
    }

    const bidsRef = ref();
    watch(() => activeAuction.value.bids, () => {
        setTimeout(() => {
            bidsRef?.value?.scrollTo({
                top: bidsRef.value.scrollHeight,
                behavior: "smooth",
            })
        }, 1)
    })

    onMounted(() => {
        bidsRef?.value?.scrollTo({
            top: bidsRef.value.scrollHeight,
        })
    })
</script>
