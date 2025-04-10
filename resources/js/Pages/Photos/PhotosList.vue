<script setup>
import Pagination from "@/Components/Custom/Pagination.vue";

const props = defineProps({
    elements: {
        type: Object,
        required: true,
    },
    onDelete: Function,
})
</script>

<template>
    <div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:max-w-none">
                <div class="mt-6 space-y-12 lg:grid lg:grid-cols-3 lg:gap-x-6 lg:space-y-0">
                    <div v-for="(element, index) in elements.data" :key="index" class="group relative">
                        <div class="bg-gray-100 rounded-md">
                            <img :src="'storage/' + element.photo_path" alt="404"
                                 class="w-full rounded-lg object-cover group-hover:opacity-50 max-sm:h-80 sm:aspect-[2/1] lg:aspect-square"
                            />
                        </div>
                        <div class="flex justify-between py-1">
                            <p class="text-base font-semibold text-gray-900 dark:text-gray-300 mb-0 lg:mb-7">
                                {{ element.title }}
                            </p>

                            <button @click="onDelete(element.id)" class="h-min">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-500 hover:scale-110">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <pagination :links="elements.links"/>
    </div>
</template>
