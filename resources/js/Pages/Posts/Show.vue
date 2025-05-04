<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {router, useForm} from "@inertiajs/vue3";
import { ref } from 'vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
    post: Object,
})

const deletePost = () => {
    router.delete(route('posts.destroy', props.post.id));
}

const isOpenEditModal = ref(false);
const removeCurrentPhoto = ref(false);
const processing = ref(false);

const openEditModal = () => {
    isOpenEditModal.value = true;
    removeCurrentPhoto.value = false;
    form.reset();
    form.title = props.post.title;
    form.body = props.post.body;
    form.remove_photo = false;
    form.clearErrors();
}

const closeEditModal = () => {
    isOpenEditModal.value = false;
}

const form = useForm({
    title: props.post.title,
    body: props.post.body,
    photo_path: null,
    remove_photo: false,
    _method: 'PUT',
})

const toggleRemovePhoto = () => {
    removeCurrentPhoto.value = !removeCurrentPhoto.value;
    form.remove_photo = removeCurrentPhoto.value;
}

const updatePost = () => {
    processing.value = true;

    form.post(route('posts.update', props.post.id), {
        forceFormData: true,
        onSuccess: () => {
            closeEditModal();
        },
        onError: (errors) => {
            console.error('Ошибки валидации:', errors);
        },
        onFinish: () => {
            processing.value = false;
        }
    });
}
</script>

<template>
    <AppLayout title="Show Post">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                    Post {{ post.id }}
                </h2>

                <div class="gap-3 flex flex-wrap items-center justify-start">
                    <button @click="openEditModal" class="relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg gap-1.5 px-3 py-1.5 text-sm inline-grid shadow-sm bg-amber-600 text-white hover:bg-amber-500 focus-visible:ring-amber-500/50 dark:bg-amber-500 dark:hover:bg-amber-400 dark:focus-visible:ring-amber-400/50">
                        <span>
                            Edit post
                        </span>
                    </button>

                    <button @click="deletePost" class="relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg gap-1.5 px-3 py-1.5 text-sm inline-grid shadow-sm bg-red-600 text-white hover:bg-red-500 focus-visible:ring-red-500/50 dark:bg-red-500 dark:hover:bg-red-400 dark:focus-visible:ring-red-400/50">
                        <span>
                            Delete post
                        </span>
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ post.title }}
                        </h2>

                        <img class="lg:h-72 md:h-52 w-full object-cover object-center"
                             :src="'/storage/' + post.photo_path" alt="404">

                        <div>
                            {{ post.body }}
                        </div>
                    </div>

                    <div class="p-6">
                        <div v-for="(comment, index) in post.comments" :key="index">
                            <div class="border-b border-gray-300">
                                <div>
                                    Author: {{ comment.user.name }}
                                </div>
                                <div>
                                    Text: "{{ comment.body }}"
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <template>
            <div class="fixed inset-0 flex items-center justify-center">
                <button
                    type="button"
                    @click="openEditModal"
                    class="rounded-md bg-black/20 px-4 py-2 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
                >
                    Open dialog
                </button>
            </div>
            <TransitionRoot appear :show="isOpenEditModal" as="template">
                <Dialog as="div" @close="closeEditModal" class="relative z-10">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                        <div class="fixed inset-0 bg-black/25" />
                    </TransitionChild>

                    <div class="fixed inset-0 overflow-y-auto">
                        <div
                            class="flex min-h-full items-center justify-center p-4 text-center"
                        >
                            <TransitionChild
                                as="template"
                                enter="duration-300 ease-out"
                                enter-from="opacity-0 scale-95"
                                enter-to="opacity-100 scale-100"
                                leave="duration-200 ease-in"
                                leave-from="opacity-100 scale-100"
                                leave-to="opacity-0 scale-95"
                            >
                                <DialogPanel
                                    class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                                >
                                    <DialogTitle
                                        as="h3"
                                        class="text-lg font-medium leading-6 text-gray-900"
                                    >
                                        Edit Post
                                    </DialogTitle>
                                    <form @submit.prevent="updatePost" enctype="multipart/form-data">
                                        <div class="mt-2">
                                            <div class="col-span-6 sm:col-span-4">
                                                <InputLabel for="email" value="Title" />
                                                <TextInput
                                                    id="title"
                                                    v-model="form.title"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                    required
                                                    autofocus
                                                    autocomplete="title"
                                                />
                                                <InputError class="mt-2" :message="form.errors.title" />
                                            </div>

                                            <div class="col-span-6 sm:col-span-4">
                                                <InputLabel for="email" value="Body" />
                                                <textarea
                                                    id="body"
                                                    v-model="form.body"
                                                    type="text"
                                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
                                                    required
                                                    autofocus
                                                    autocomplete="body"
                                                />
                                                <InputError class="mt-2" :message="form.errors.body" />
                                            </div>
                                        </div>

                                        <div class="col-span-6 sm:col-span-4 mt-4">
                                            <InputLabel for="photo" value="Photo" />
                                            <input
                                                type="file"
                                                @input="form.photo_path = $event.target.files[0]"
                                                class="mt-1 block w-full"
                                                accept="image/*"
                                                :disabled="removeCurrentPhoto"
                                            />

                                            <div v-if="post.photo_path" class="mt-2">
                                                <div class="flex items-center">
                                                    <input
                                                        type="checkbox"
                                                        id="remove_photo"
                                                        @change="toggleRemovePhoto"
                                                        :checked="removeCurrentPhoto"
                                                        class="mr-2"
                                                    />
                                                    <label for="remove_photo">Delete current image</label>
                                                </div>

                                                <div v-if="!removeCurrentPhoto" class="mt-2">
                                                    <div class="text-sm text-gray-600">Current image:</div>
                                                    <img
                                                        :src="'/storage/' + post.photo_path"
                                                        alt="Current post image"
                                                        class="h-40 mt-1 rounded object-cover"
                                                    />
                                                </div>
                                            </div>

                                            <InputError class="mt-2" :message="form.errors.photo_path" />
                                        </div>

                                        <div class="mt-4 flex justify-around">
                                            <button
                                                type="button"
                                                class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                                @click="closeEditModal"
                                            >
                                                Close
                                            </button>

                                            <button
                                                type="button"
                                                class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                                @click="updatePost"
                                            >
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
        </template>

    </AppLayout>
</template>
