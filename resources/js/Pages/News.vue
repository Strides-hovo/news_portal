<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Notification from "@/Components/Notification.vue";

type News = {
    links: {
        active: boolean
        label: string
        url: string | null
    }[]
    data: {
        id: number
        preview: string
        content: string
        image: string
        source: string
        created_at: Date
    }[]

};

const props = defineProps<{
    auth: {
        user: {
            id: number
            name: string
            email: string
        }
    }
    errors: {
        [key: string]: string[]
    }
    news: News
}>();


const form = useForm({
    search: ''
});


const getDate = (date: Date) => {
    const d = new Date(date);
    return d.toLocaleDateString('ru-RU', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
};


const submit = () => {
    form.get(route('news.search'), {
    });
};

</script>
<style>
input[type="search"]::-webkit-search-cancel-button {
    margin-right: 90px;
    cursor: pointer;
}
</style>
<template>
    <Head title="News" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Новости
                </h2>
                <form @submit.prevent="submit" class="max-w-md w-full">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <TextInput
                            id="search"
                            type="search"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            v-model="form.search"
                            required
                            autofocus
                            autocomplete="search"
                            placeholder="Введите поиск"

                        />

                        <PrimaryButton
                            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Поиск
                        </PrimaryButton>

                    </div>
                </form>
            </div>

        </template>
        <Notification user-name="test" />
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="bg-white">
                        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                                <div class="group relative shadow-xl p-4"
                                     v-for="newsItem in news.data"
                                     :key="newsItem.id"
                                >
                                    <small class="my-2 font-bold tracking-tight text-gray-900">Источник: {{ newsItem.source }}</small>
                                    <img
                                        loading="lazy"
                                        :src="newsItem.image"
                                         alt="Front of men&#039;s Basic Tee in black."
                                         class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80"
                                    >
                                    <div class="mt-4 flex justify-between">
                                        <div>
                                            <h3 class="text-sm text-gray-700">
<!--                                                <a href="#">-->
<!--                                                    <span aria-hidden="true" class="absolute inset-0"></span>-->
<!--                                                    Basic Tee-->
<!--                                                </a>-->
                                            </h3>
                                            <p class="mt-1 text-sm text-gray-500">{{ newsItem.preview.substring(0, 80) }} ...</p>
                                        </div>

                                    </div>
                                    <p class="text-sm font-medium text-gray-900">
                                        <span> Опубликованно: </span>
                                        {{ getDate(newsItem.created_at) }}
                                    </p>
                                </div>

                                <!-- More products... -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="px-10 pt-10">
                <Link
                    v-for="(link, index) in news.links"
                    :key="index"
                    :href="link.url ?? ''"
                    class="p-3 border-2"
                    v-html="link.label"
                />
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
