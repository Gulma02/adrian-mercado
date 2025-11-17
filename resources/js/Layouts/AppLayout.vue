<template>
    <div class="min-h-screen bg-gray-100">
        <div class="w-full bg-white">
            <ApplicationLogo class="h-20 p-2" />
        </div>

        <div class="w-full">
            <slot />
        </div>
    </div>
</template>

<script setup lang="ts">

import ApplicationLogo from "@/Components/ApplicationLogo.vue";
</script>
