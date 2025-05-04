<script setup>
import ListByType from "@/Pages/Interests/ListByType.vue";

const props = defineProps({
    elements: {
        type: Object,
        required: true,
    },
    onDelete: Function,
    onEdit: Function,
})

function getTypeLabel(type) {
    switch (parseInt(type)) {
        case 0: return 'Films';
        case 1: return 'Music';
        case 2: return 'Walking';
        default: return 'Unknown';
    }
}

</script>

<template>
    <div class="py-5">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:max-w-none">
                <div class="border-b-2 border-gray-600 dark:border-gray-100">
                    <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Films:
                    </h3>
                    <list-by-type
                        title="Film"
                        :elements="elements.films"
                        :on-delete="onDelete"
                        :on-edit="onEdit"
                    />
                </div>

                <div class="border-b-2 border-gray-600 dark:border-gray-100">
                    <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Music:
                    </h3>
                    <list-by-type
                        title="Music"
                        :elements="elements.music"
                        :on-delete="onDelete"
                        :on-edit="onEdit"
                    />
                </div>

                <div>
                    <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Walking:
                    </h3>
                    <list-by-type
                        title="Walking"
                        :elements="elements.walking"
                        :on-delete="onDelete"
                        :on-edit="onEdit"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
