<template>
    <GuestLayout>
        <div class="min-h-screen bg-gray-50 p-6">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-3xl font-bold mb-6 text-center">Subastas en vivo</h1>

                <!-- Toggle de visualización -->
                <div class="flex justify-end mb-4">
                    <button
                        class="px-4 py-2 bg-blue-600 text-white rounded-md mr-2 hover:bg-blue-700"
                        @click="viewMode = 'table'"
                        :class="{ 'opacity-50': viewMode === 'table' }"
                    >
                        Tabla
                    </button>
                    <button
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                        @click="viewMode = 'cards'"
                        :class="{ 'opacity-50': viewMode === 'cards' }"
                    >
                        Tarjetas
                    </button>
                </div>

                <!-- Vista tipo tabla -->
                <div v-if="viewMode === 'table'" class="bg-white shadow rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Título</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Precio actual</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="auction in auctions"
                            :key="auction.id"
                            class="hover:bg-gray-50 transition-colors"
                        >
                            <td class="px-6 py-4 text-gray-800">{{ auction.title }}</td>
                            <td class="px-6 py-4 text-gray-600">${{ auction.current_price }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Vista tipo tarjetas -->
                <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div
                        v-for="auction in auctions"
                        :key="auction.id"
                        class="bg-white shadow-lg rounded-lg p-4 border border-gray-100 hover:shadow-xl transition-all"
                    >
                        <h3 class="text-lg font-semibold text-gray-800">{{ auction.title }}</h3>
                        <p class="text-gray-600">Precio actual: <span class="font-bold">${{ auction.current_price }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import AuthenticatedLayout
    from "../../../vendor/laravel/breeze/stubs/inertia-vue-ts/resources/js/Layouts/AuthenticatedLayout.vue";
import GuestLayout from "../../../vendor/laravel/breeze/stubs/inertia-vue-ts/resources/js/Layouts/GuestLayout.vue";

interface Auction {
    id: number
    title: string
    current_price: number
}

const viewMode = ref<'table' | 'cards'>('table')
const auctions = ref<Auction[]>([])

onMounted(() => {
    // Simulación inicial
    auctions.value = [
        { id: 1, title: 'Subasta 1', current_price: 1000 },
        { id: 2, title: 'Subasta 2', current_price: 2000 },
    ]

    // Conexión a canal público
    window.Echo.channel('auctions')
        .listen('.auction.created', (event: any) => {
            auctions.value.push({
                id: event.auction.id,
                title: event.auction.title,
                current_price: event.auction.initial_price,
            })
        })
        .listen('.bid.placed', (event: any) => {
            const auction = auctions.value.find(a => a.id === event.bid.auction_id)
            if (auction) {
                auction.current_price = event.bid.amount
            }
        })
})
</script>
