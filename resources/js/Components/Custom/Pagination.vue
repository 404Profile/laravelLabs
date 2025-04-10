<script setup>
import {Link, router} from "@inertiajs/vue3";

const props = defineProps({
    links: {
        type: Array,
        required: true,
    }
})

const navigateTo = (url) => {
    if (url) {
        router.visit(url, {
            preserveScroll: false
        })
    }
}
</script>

<template>
    <div v-if="links.length" class="my-5">
        <div class="flex justify-center space-x-1 dark:text-gray-800">
            <button
                :disabled="!links[0].url"
                @click="navigateTo(links[0].url)"
                title="Previous page"
                type="button"
                class="inline-flex items-center justify-center w-8 h-8 py-0 border rounded-md shadow-md dark:bg-gray-50 dark:border-gray-100 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="w-4">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>

            <template v-for="(link, key) in links.slice(1, -1)" :key="key">
                <button
                    v-if="link.url === null"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm font-semibold border rounded shadow-md dark:bg-gray-50 dark:text-amber-600 dark:border-amber-600"
                    :title="'Page ' + (key + 1)"
                    v-html="link.label"
                />
                <Link
                    v-else
                    :href="link.url"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm border rounded shadow-md dark:bg-gray-50 dark:border-gray-100"
                    :class="{ 'bg-amber-100 text-amber-600 border-amber-600 dark:bg-amber-100 dark:text-amber-600 dark:border-amber-600': link.active }"
                    :title="'Page ' + (key + 1)"
                    v-html="link.label"
                />
            </template>

            <button
                :disabled="!links[links.length - 1].url"
                @click="navigateTo(links[links.length - 1].url)"
                title="Next page"
                type="button"
                class="inline-flex items-center justify-center w-8 h-8 py-0 border rounded-md shadow-md dark:bg-gray-50 dark:border-gray-100 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="w-4">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>
    </div>
</template>
