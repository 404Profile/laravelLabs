<script setup>
import {Link} from "@inertiajs/vue3";
import Pagination from "@/Components/Custom/Pagination.vue";

const props = defineProps({
    posts: {
        type: Object,
        required: true,
    }
})
</script>

<template>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-6 mx-auto">
            <div class="flex flex-wrap -m-4">
                <template v-for="(post, index) in posts.data" :key="index">
                    <div class="p-4 md:w-1/3">
                        <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                            <img class="lg:h-48 md:h-36 w-full object-cover object-center"
                                 :src="'storage/' + post.photo_path" alt="404">

                            <div class="p-6">
                                <h1 class="title-font text-lg font-medium text-gray-900 mb-3">
                                    {{ post.title }}
                                </h1>
                                <div>
                                    Author: {{ post.user.name }}
                                </div>
                                <div class="flex items-center flex-wrap ">
                                    <Link :href="route('posts.show', post.id)" class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">
                                        Learn More
                                        <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor"
                                             stroke-width="2" fill="none" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5l7 7-7 7"></path>
                                        </svg>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="flex justify-center w-full">
                    <pagination :links="posts.links" />
                </div>

            </div>
        </div>
    </section>
</template>
