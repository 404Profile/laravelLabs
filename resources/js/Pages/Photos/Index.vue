<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PhotosList from "@/Pages/Photos/PhotosList.vue";
import CreateModal from "@/Components/Custom/CreateModal.vue";
import {ref} from "vue";
import {router, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import EditModal from "@/Components/Custom/EditModal.vue";

const props = defineProps({
    photos: Object,
})

const displayingModal = ref(false);

const form = useForm({
    title: '',
    photo_path: null,
});

const editForm = useForm({
    title: '',
    photo_path: null,
    remove_photo: false,
    _method: 'put',
});

const photoInput = ref(null);
const photoPreview = ref(null);
const uploadingImage = ref(false);

const editPhotoInput = ref(null);
const editPhotoPreview = ref(null);
const editUploadingImage = ref(false);


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

const createPhoto = () => {
    if (photoInput.value) {
        form.photo_path = photoInput.value.files[0];
    }

    form.post(route('photos.store'), {
        preserveScroll: true,
        onSuccess: () => {
            displayingModal.value = false;
        },
    });
}

const deletePhoto = (id) => {
    router.delete(route('photos.destroy', id));
}

const selectEditPhoto = () => {
    editPhotoInput.value.click();
};

const updateEditPhotoPreview = () => {
    const photo = editPhotoInput.value.files[0];

    if (!photo) return;

    editUploadingImage.value = true;

    const reader = new FileReader();

    reader.onload = (e) => {
        editPhotoPreview.value = e.target.result;
    };

    reader.onerror = (error) => {
        console.error('Error reading file: ', error)
    }

    reader.readAsDataURL(photo);

    editUploadingImage.value = false;
};

const deleteEditPhotoInput = () => {
    editPhotoPreview.value = null;
    clearEditPhotoFileInput();
    editForm.remove_photo = true;
};

const clearEditPhotoFileInput = () => {
    if (editPhotoInput.value?.value) {
        editPhotoInput.value.value = null;
    }
};

const displayingEditModal = ref(false);
const editingPhoto = ref(null);


const openEditModal = (photo) => {
    editingPhoto.value = photo;
    editForm.title = photo.title;
    editForm.remove_photo = false;
    editPhotoPreview.value = null;
    clearEditPhotoFileInput();

    displayingEditModal.value = true;
};

const updatePhoto = () => {
    if (editPhotoInput.value && editPhotoInput.value.files[0]) {
        editForm.photo_path = editPhotoInput.value.files[0];
    }

    editForm.post(route('photos.update', editingPhoto.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            displayingEditModal.value = false;
            editForm.reset();
            editPhotoPreview.value = null;
            clearEditPhotoFileInput();
        },
    });
}
</script>

<template>
    <AppLayout title="Photos">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                    Photos
                </h2>

                <div v-if="$page.props.authUser.hasRole.admin" class="gap-3 flex flex-wrap items-center justify-start">
                    <button @click="displayingModal = true" class="relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg gap-1.5 px-3 py-1.5 text-sm inline-grid shadow-sm bg-amber-600 text-white hover:bg-amber-500 focus-visible:ring-amber-500/50 dark:bg-amber-500 dark:hover:bg-amber-400 dark:focus-visible:ring-amber-400/50">
                        <span>
                            New photo
                        </span>
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <photos-list
                        :elements="photos"
                        :on-delete="deletePhoto"
                        :on-edit="openEditModal"
                    />
                </div>
            </div>
        </div>

        <create-modal v-model="displayingModal" :on-create="createPhoto">
            <template #title>
                <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                    Create new Photo
                </h3>
            </template>
            <template #content>
                <div class="space-y-2">
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

        <edit-modal
            v-model:show="displayingEditModal"
            :on-update="updatePhoto"
            max-width="2xl"
        >
            <template #title>
                <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                    Edit Photo
                </h3>
            </template>
            <template #content>
                <div class="space-y-2">
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="edit-title" value="Title" />
                        <TextInput
                            id="edit-title"
                            v-model="editForm.title"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="title"
                        />
                        <InputError class="mt-2" :message="editForm.errors.title" />
                    </div>

                    <div v-if="editingPhoto && editingPhoto.photo_path && !editPhotoPreview && !editForm.remove_photo" class="col-span-6 sm:col-span-4 py-3 px-1">
                        <InputLabel value="Current image" />
                        <div class="mt-2">
                            <img :src="`/storage/${editingPhoto.photo_path}`" alt="Current photo" class="max-w-full h-auto max-h-64" />
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <input ref="editPhotoInput" accept="image/jpeg, image/png, image/jpg" type="file" class="hidden" @change="updateEditPhotoPreview">
                        <InputLabel for="edit-photo" value="Update image" />

                        <div class="block">
                            <SecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectEditPhoto">
                                Select new image
                            </SecondaryButton>

                            <SecondaryButton type="button" class="mt-2 mr-2" @click.prevent="deleteEditPhotoInput">
                                Remove image
                            </SecondaryButton>
                        </div>

                        <div v-if="editUploadingImage" class="dark:text-white">
                            Loading...
                        </div>
                    </div>

                    <div v-show="editPhotoPreview" class="col-span-6 sm:col-span-4 py-3 px-1">
                        <InputLabel value="New image preview" />
                        <div id="edit-preview" class="mt-2">
                            <img :src="editPhotoPreview" alt="Preview" class="max-w-full h-auto max-h-64" />
                        </div>
                    </div>

                    <InputError class="mt-2" :message="editForm.errors.photo_path" />
                </div>
            </template>
        </edit-modal>

    </AppLayout>
</template>
