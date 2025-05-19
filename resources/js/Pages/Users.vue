<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    errors: {
        type: Object,
        required: true
    },
    users: {
        type: Array,
        required: true
    }
});


</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Пользователи
            </h2>
        </template>

        <div class="py-2 px-4 ml-5">



            <div class="relative overflow-x-auto">
                <table class="w-[400px] text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Имя
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Код
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="user in users"
                        :key="user.id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="flex items-center">
                                <svg
                                    :class="user.is_verified ? 'text-green-500' : 'text-red-500'"
                                    class="w-3.5 h-3.5 me-2  shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                </svg>
                                {{ user.name }}
                            </div>

                        </th>
                        <td class="px-6 py-4">
                            {{ user.code }}
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>


        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
