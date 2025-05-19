<script setup>
    import {ref} from "vue";

    const props = defineProps({
        userName: {
            type: String,
            required: true
        }
    });

    const isOpen = ref(true);
    const closeMessage = () => {
        isOpen.value = !isOpen.value;
    }
</script>

<template>

    <div
        v-if="isOpen"
        class="flex items-center w-full max-w-xs p-4 space-x-4 rtl:space-x-reverse text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow-sm justify-between fixed top-4 right-4 border border-emerald-900" role="alert">
        <span class="flex">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-500 rotate-45" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 17 8 2L9 1 1 19l8-2Zm0 0V9"/>
        </svg>
        <span class="ps-4 text-sm font-normal"> Регистрировалось в портале новый ползовател -- <b>{{  userName }} </b> -- </span>
        </span>

        <button
            @click="closeMessage"
            type="button"
                class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 " >
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>

</template>

<style scoped>

</style>
