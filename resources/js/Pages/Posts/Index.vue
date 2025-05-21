<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import CreateModal from "@/Components/Custom/CreateModal.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PostList from "@/Pages/Posts/PostList.vue";

const props = defineProps({
    posts: Object,
})

const displayingModal = ref(false)
const displayingImportModal = ref(false)

const form = useForm({
    title: '',
    body: '',
    photo_path: null,
});

const importForm = useForm({
    csv_file: null,
});

const photoInput = ref(null);
const photoPreview = ref(null);
const uploadingImage = ref(false);

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    uploadingImage.value = true;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.onerror = (error) => {
        console.error('Error reading file: ', error)
    }

    reader.readAsDataURL(photo);

    uploadingImage.value = false;
};

const deletePhotoInput = () => {
    photoPreview.value = null;
    clearPhotoFileInput();
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};

const createPost = () => {
    if (photoInput.value) {
        form.photo_path = photoInput.value.files[0];
    }

    form.post(route('posts.store'), {
        preserveScroll: true,
        onSuccess: () => {
            displayingModal.value = false;
        },
    });
}

const importPosts = () => {
    importForm.post(route('posts.import-csv'), {
        preserveScroll: true,
        onSuccess: () => {
            displayingImportModal.value = false;
            importForm.reset();
        },
    });
};

const onCsvFileSelected = (event) => {
    importForm.csv_file = event.target.files[0];
};
</script>

<template>
    <AppLayout title="Posts">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                    Posts
                </h2>

                <div class="gap-3 flex flex-wrap items-center justify-start">
                    <button @click="displayingModal = true" class="relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg gap-1.5 px-3 py-1.5 text-sm inline-grid shadow-sm bg-amber-600 text-white hover:bg-amber-500 focus-visible:ring-amber-500/50 dark:bg-amber-500 dark:hover:bg-amber-400 dark:focus-visible:ring-amber-400/50">
                        <span>
                            New post
                        </span>
                    </button>

                    <button @click="displayingImportModal = true" class="relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg gap-1.5 px-3 py-1.5 text-sm inline-grid shadow-sm bg-blue-600 text-white hover:bg-blue-500 focus-visible:ring-blue-500/50 dark:bg-blue-500 dark:hover:bg-blue-400 dark:focus-visible:ring-blue-400/50">
                        <span>
                            Import CSV
                        </span>
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <post-list :posts="posts" />
                </div>
            </div>
        </div>

        <create-modal v-model="displayingModal" :on-create="createPost">
            <template #title>
                <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                    Create new Post
                </h3>
            </template>
            <template #content>
                <div class="space-y-2">
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="title" value="Title" />
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
                        <InputLabel for="body" value="Body" />
                        <textarea
                            id="body"
                            v-model="form.body"
                            type="text"
                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
                            required
                            autocomplete="body"
                        />
                        <InputError class="mt-2" :message="form.errors.body" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <input ref="photoInput" accept="image/jpeg, image/png, image/jpg" type="file" class="hidden" @change="updatePhotoPreview">
                        <InputLabel for="photo" value="Select image" />

                        <div class="block">
                            <SecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                                Select image
                            </SecondaryButton>

                            <SecondaryButton type="button" class="mt-2 mr-2" @click.prevent="deletePhotoInput">
                                Remove image
                            </SecondaryButton>
                        </div>

                        <div v-if="uploadingImage" class="dark:text-white">
                            Loading...
                        </div>
                    </div>

                    <div v-show="photoPreview" class="col-span-6 sm:col-span-4 py-3 px-1">
                        <div id="preview">
                            <img :src="photoPreview" alt="404" />
                        </div>
                    </div>

                    <InputError class="mt-2" :message="form.errors.photo_path" />
                </div>
            </template>
        </create-modal>

        <create-modal v-model="displayingImportModal" :on-create="importPosts">
            <template #title>
                <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                    Importing posts from CSV
                </h3>
            </template>
            <template #content>
                <div class="space-y-4">
                    <div>
                        <InputLabel for="csv_file" value="Выберите CSV файл" />
                        <p class="text-sm text-gray-500 mt-1">
                            File format: title, content, image URL (optional)
                        </p>
                        <input
                            type="file"
                            accept=".csv"
                            class="mt-2 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100"
                            @change="onCsvFileSelected"
                        />
                        <InputError class="mt-2" :message="importForm.errors.csv_file" />
                    </div>
                </div>
            </template>
        </create-modal>

    </AppLayout>
</template>
