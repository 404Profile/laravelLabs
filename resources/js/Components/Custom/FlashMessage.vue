<script setup>
import { ref, watch } from 'vue';
import {usePage} from "@inertiajs/vue3";

const page = usePage();
const show = ref(true);

watch(() => page.props.flash, () => {
    show.value = true;
}, { deep: true });

const pluralizeErrors = (count) => {
    const word = ref("")
    if (count === 1) {
        word.value = 'error';
    } else {
        word.value = 'errors';
    }

    return `${count} ${word.value} was found in the form`;
};
</script>

<template>
    <div>
        <transition name="slide-fade">
            <div v-if="page.props.flash.success && show" class="absolute flex max-w-xs w-full mt-4 mr-4 top-0 right-0 bg-white dark:bg-slate-700 rounded shadow p-4 z-50 border-[1px] border-green-600">
                <div class="mr-2 flex items-center">
                    <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
                <div class="flex-1 text-gray-800 dark:text-white">
                    {{ page.props.flash.success }}
                </div>
                <div class="ml-2">
                    <button @click="show = false" class="align-top text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </transition>

        <transition name="slide-fade">
            <div v-if="(page.props.flash.error || Object.keys(page.props.errors).length > 0) && show" class="absolute flex max-w-xs w-full mt-4 mr-4 top-0 right-0 bg-white dark:bg-slate-700 rounded shadow p-4 z-50 border-[1px] border-red-600">
                <div class="mr-2 flex items-center">
                    <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="flex-1 dark:text-white text-sm font-medium">
                    <div v-if="page.props.flash.error">
                        {{ page.props.flash.error }}
                    </div>

                    <div v-else class="flex items-center">
                        {{ pluralizeErrors(Object.keys(page.props.errors).length) }}
                    </div>
                </div>
                <div class="ml-2">
                    <button @click="show = false" class="align-top text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </transition>
    </div>
</template>

<style>
.slide-fade-enter-active {
    transition: all .3s ease;
}
.slide-fade-leave-active {
    transition: all .6s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
}
</style>
