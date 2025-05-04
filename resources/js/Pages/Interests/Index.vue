<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InterestsList from "@/Pages/Interests/InterestsList.vue";
import {router, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import CreateModal from "@/Components/Custom/CreateModal.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import EditModal from "@/Components/Custom/EditModal.vue";

const props = defineProps({
    interests: Object,
});

const displayingModal = ref(false);
const displayingEditModal = ref(false);
const editingInterest = ref(null);

const form = useForm({
    title: '',
    type: 0,
    description: '',
});

const editForm = useForm({
    title: '',
    type: 0,
    description: '',
    _method: 'put',
});

const createInterest = () => {
    form.post(route('interests.store'), {
        preserveScroll: true,
        onSuccess: () => {
            displayingModal.value = false;
        },
    });
}

const deleteInterest = (id) => {
    router.delete(route('interests.destroy', id));
}

const openEditModal = (interest) => {
    editingInterest.value = interest;
    editForm.title = interest.title;
    editForm.type = interest.type;
    editForm.description = interest.description;

    displayingEditModal.value = true;
};

const updateInterest = () => {
    editForm.post(route('interests.update', editingInterest.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            displayingEditModal.value = false;
            editForm.reset();
        },
    });
}

</script>

<template>
    <AppLayout title="Interests">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                    Interests
                </h2>

                <div class="gap-3 flex flex-wrap items-center justify-start">
                    <button @click="displayingModal = true" class="relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg gap-1.5 px-3 py-1.5 text-sm inline-grid shadow-sm bg-amber-600 text-white hover:bg-amber-500 focus-visible:ring-amber-500/50 dark:bg-amber-500 dark:hover:bg-amber-400 dark:focus-visible:ring-amber-400/50">
                        <span>
                            New interest
                        </span>
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <interests-list
                        :elements="interests"
                        :on-delete="deleteInterest"
                        :on-edit="openEditModal"
                    />
                </div>
            </div>
        </div>

        <create-modal v-model="displayingModal" :on-create="createInterest">
            <template #title>
                <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                    Create new Interest
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
                        <InputLabel for="email" value="Type" />
                        <select v-model="form.type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="0">Films</option>
                            <option value="1">Music</option>
                            <option value="2">Walking</option>
                        </select>

                        <InputError class="mt-2" :message="form.errors.type" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="email" value="Description" />
                        <TextInput
                            id="description"
                            v-model="form.description"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="description"
                        />
                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>


                </div>

            </template>
        </create-modal>

        <edit-modal
            v-model:show="displayingEditModal"
            :on-update="updateInterest"
            max-width="2xl"
        >
            <template #title>
                <h2 class="text-lg font-medium text-gray-900">
                    Edit Interest
                </h2>
            </template>

            <template #content>
                <div class="mt-6 space-y-4">
                    <div>
                        <InputLabel for="edit-title" value="Title" />
                        <TextInput
                            id="edit-title"
                            v-model="editForm.title"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                        />
                        <InputError class="mt-2" :message="editForm.errors.title" />
                    </div>

                    <div>
                        <InputLabel for="edit-type" value="Type" />
                        <select
                            id="edit-type"
                            v-model="editForm.type"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                            <option value="0">Films</option>
                            <option value="1">Music</option>
                            <option value="2">Walking</option>
                        </select>
                        <InputError class="mt-2" :message="editForm.errors.type" />
                    </div>

                    <div>
                        <InputLabel for="edit-description" value="Description" />
                        <TextInput
                            id="edit-description"
                            v-model="editForm.description"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError class="mt-2" :message="editForm.errors.description" />
                    </div>
                </div>
            </template>
        </edit-modal>

    </AppLayout>
</template>
