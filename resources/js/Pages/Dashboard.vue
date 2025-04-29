<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Pagination from "@/Components/Custom/Pagination.vue";

const props = defineProps({
    visits: Object,
})
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <template v-if="$page.props.authUser.hasRole.admin">
                        <div class="p-6">
                            <p class="font-semibold text-xl">
                                Users Log:
                            </p>
                            <div class="space-y-4">
                                <div v-for="(visit, index) in visits.data" :key="index">
                                    <div>
                                        <p>Visited At: {{ visit.visited_at }}</p>
                                        <p>Webpage: {{ visit.webpage }}</p>
                                        <p>IP adress: {{ visit.ip_address }}</p>
                                        <p>Host: {{ visit.host_name }}</p>
                                        <p>Browser: {{ visit.browser }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center w-full">
                            <pagination :links="visits.links" />
                        </div>
                    </template>
                    <template v-else>
                        <Welcome />
                    </template>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
