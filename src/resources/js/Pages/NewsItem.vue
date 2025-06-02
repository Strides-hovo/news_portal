<script setup lang="ts">
    import {router,Link} from "@inertiajs/vue3";

    const props = defineProps<{
        news: {
            source: string
            id: number,
            image: string,
            preview: string
            content: string
            created_at: Date
        },
        similar: {
            source: string
            id: number,
            image: string,
            preview: string
            content: string
            created_at: Date
            title: string
        }[]
        like: any
    }>()

    console.log( props.similar )
</script>

<template>
    <main class="pt-8 pb-16 lg:pt-16 lg:pb-24 bg-white dark:bg-gray-900 antialiased">
        <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
            <article class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                <header class="mb-4 lg:mb-6 not-format">
                    <address class="flex items-center mb-6 not-italic">
                        <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                            <img class="mr-4 w-16 h-16 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-2.jpg" alt="Jese Leos">
                            <div>
                                <span  rel="author" class="text-xl font-bold text-gray-900 dark:text-white">Источник</span>
                                <p class="text-base text-gray-500 dark:text-gray-400 pl-2">{{ news.source }}</p>
                            </div>
                        </div>
                    </address>
                    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
                        {{ news.preview }}</h1>
                </header>
                <p class="lead">
                    {{ news.content }}
                </p>

            </article>
        </div>
    </main>

    <aside aria-label="Related articles" class="py-8 lg:py-24 bg-gray-50 dark:bg-gray-800">
        <div class="px-4 mx-auto max-w-screen-xl">
            <h2 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white">Related articles</h2>
            <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-4">

                <article class="max-w-xs" v-for="s in similar" :key="s.id">

                    <Link :href="route('newsId', s.id)">
                        <img :src="s.image" class="mb-5 rounded-lg" alt="Image 1">
                    </Link>
                    <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                        <Link :href="route('newsId', s.id)">{{ s.title }}</Link>
                    </h2>
                    <p class="mb-4 text-gray-500 dark:text-gray-400">{{ s.preview }}</p>
                    <p  class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                      источник:  {{ s.source }}
                    </p>
                </article>


            </div>
        </div>
    </aside>

</template>

