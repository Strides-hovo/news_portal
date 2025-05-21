<script setup>

import {Head, useForm} from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    status: String,
    userId: Number,
})


const verifiedCode = useForm({
    code: '',
})


const submit = () => {
    verifiedCode.post(route('verification', {id: props.userId, userId: props.userId}), {

        onSuccess: (data) => {
            console.log( data )
        },
        onFinish: params => {
            console.log(params)
        }
    });
};

</script>

<template>
    <Head title="Verify Code" />

    <GuestLayout >
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="code" value="Код подтверждения" />

                <TextInput
                    id="code"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="verifiedCode.code"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="verifiedCode.errors.code" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': verifiedCode.processing }"
                    :disabled="verifiedCode.processing"
                >
                    Подтвердить
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

<style scoped>

</style>
