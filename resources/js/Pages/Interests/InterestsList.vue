<script setup>
import ListByType from "@/Pages/Interests/ListByType.vue";

const props = defineProps({
    elements: {
        type: Object,
        required: true,
    },
    onDelete: Function,
})
</script>

<template>
    <div class="py-5">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:max-w-none">
                <div class="border-b-2 border-gray-600 dark:border-gray-100">
                    <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Films:
                    </h3>
                    <list-by-type title="Film" :elements="elements.films" :on-delete="onDelete" />
                </div>

                <div class="border-b-2 border-gray-600 dark:border-gray-100">
                    <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Music:
                    </h3>
                    <list-by-type title="Music" :elements="elements.music" />
                </div>

                <div>
                    <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Walking:
                    </h3>
                    <list-by-type title="Walking" :elements="elements.walking" />
                </div>
            </div>
        </div>
    </div>
</template>
