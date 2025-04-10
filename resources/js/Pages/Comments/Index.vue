<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    comments: Object,
})

const form = useForm({
    'text': '',
})

const createComment = () => {
    form.post(route('comments.store'), {
        preserveScroll: true,
    });
}
</script>

<template>
    <AppLayout title="Comments">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Comments
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-4">

                    <form @submit.prevent="createComment">
                        <div>
                            <InputLabel for="text" value="Comment text" />
                            <textarea
                                id="text"
                                v-model="form.text"
                                type="text"
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
                                required
                                autocomplete="current-password"
                                autofocus
                            />
                            <InputError class="mt-2" :message="form.errors.text" />
                        </div>

                        <div class="flex justify-end mt-4">
                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Confirm
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <p>All Comments:</p>

                    <div class="mx-auto mt-10 grid grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 w-full">
                        <article v-for="post in comments" :key="post.id" class="flex flex-col items-start justify-between w-full border-b border-gray-400">
                            <div class="flex items-center gap-x-4 text-xs">
                                <time :datetime="post.datetime" class="text-gray-500">{{ post.created_at }}</time>
                            </div>
                            <div class="group relative">
                                <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600">{{ post.text }}</p>
                            </div>
                            <div class="relative mt-8 flex items-center gap-x-4">
                                <div class="text-sm/6">
                                    <p class="font-semibold text-gray-900">
                                        {{ post.user.name }}
                                    </p>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
