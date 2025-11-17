<template>
    <ElDialog v-model="auctionDialogVisible" @close="closeModal">
        <div class="p-6">
            <h3 class="text-lg leading-6 text-gray-600 font-bold">
                Nueva Subasta
            </h3>

            <div class="py-2">
                <ElForm label-position="top">
                    <ElFormItem :error="form.errors.seller_name" label="Nombre del vendedor">
                        <ElInput v-model="form.seller_name"></ElInput>
                    </ElFormItem>

                    <ElFormItem :error="form.errors.description" label="Descripción">
                        <ElInput v-model="form.description"></ElInput>
                    </ElFormItem>

                    <ElFormItem :error="form.errors.initial_price" label="Precio inicial">
                        <ElInput v-model="form.initial_price"></ElInput>
                    </ElFormItem>

                    <!--InputLabel class="my-2">Fecha inicio</InputLabel>
                    <TextInput v-model="form.description" class="w-full"></TextInput>
                    <InputError v-model="form.errors.description"></InputError-->

                    <ElFormItem :error="form.errors.scheduled_at" label="Fecha de fin">
                        <ElDatePicker v-model="form.scheduled_at" class="w-full" type="datetime" format="YYYY-MM-DD HH:mm:ss" value-format="YYYY-MM-DD HH:mm:ss"></ElDatePicker>
                    </ElFormItem>
                </ElForm>
            </div>

            <div class="flex justify-end pt-2">
                <PrimaryButton @click="submitForm">Crear Subasta</PrimaryButton>
            </div>
        </div>
    </ElDialog>
</template>

<script setup lang="ts">
    import {useForm} from "@inertiajs/vue3";
    import PrimaryButton from "@/Components/PrimaryButton.vue";
    import {inject} from "vue";

    const { auctionDialogVisible } = inject("auctions")

    const emit = defineEmits(["close"])

    const form = useForm({
        seller_name: "",
        description: "",
        initial_price: "",
        scheduled_at: ""
    })

    const submitForm = () => {
        form.post(route("auction.store"), {
            onSuccess: () => closeModal(),
            onError: () => console.log("error")
        })
    }

    const closeModal = () => {
        form.reset()
        emit("close")
    }
</script>
