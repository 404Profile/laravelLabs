<script setup>
import {Head, Link, router, useForm} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
    guestBooks: Object,
});

const form = useForm({
    title: '',
    content: '',
    author_name: '',
});

const processing = ref(false);
const importProcessing = ref(false);
const exportProcessing = ref(false);
const importFileInput = ref(null);

const submitForm = () => {
    processing.value = true;

    router.post(route('guest-book.store'), form, {
        onSuccess: () => {
            form.reset();
        },
        onFinish: () => {
            processing.value = false;
        }
    });
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('ru-RU', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }).format(date);
};

const hasBooks = computed(() => props.guestBooks.data && props.guestBooks.data.length > 0);

const exportToExcel = () => {
    exportProcessing.value = true;

    const downloadUrl = route('guest-book.export');

    const link = document.createElement('a');
    link.href = downloadUrl;
    link.setAttribute('download', 'guest_book_' + new Date().toISOString().split('T')[0] + '.xlsx');

    document.body.appendChild(link);
    link.click();

    setTimeout(() => {
        document.body.removeChild(link);
        exportProcessing.value = false;
    }, 100);
};

const triggerFileInput = () => {
    importFileInput.value.click();
};

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('file', file);

    importProcessing.value = true;

    router.post(route('guest-book.import'), formData, {
        onSuccess: () => {
            if (importFileInput.value) {
                importFileInput.value.value = '';
            }
        },
        onFinish: () => {
            importProcessing.value = false;
        }
    });
};

</script>

<template>
    <Head title="Welcome"/>

    <div class="w-full flex justify-center">
        <Link
            v-if="$page.props.auth.user"
            :href="route('dashboard')"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Dashboard
        </Link>

        <template v-else>
            <Link
                :href="route('login')"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Log in
            </Link>

            <Link
                :href="route('register')"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Register
            </Link>
        </template>

        <Link
            :href="route('guest-book.index')"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Guest Book
        </Link>

        <Link
            :href="route('table')"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Progress table
        </Link>
        <Link
            :href="route('contact.index')"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Contact
        </Link>
    </div>

    <div class="w-full flex justify-center">
        <h1 class="text-2xl text-semibold">Guest Book</h1>
    </div>

    <section>
        <div class="w-full flex justify-center mb-4">
            <div class="flex space-x-4">
                <button
                    @click="exportToExcel"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
                >
                    Export Excel
                </button>

                <button
                    @click="triggerFileInput"
                    :disabled="importProcessing"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition disabled:opacity-50"
                >
                    {{ importProcessing ? 'Importing...' : 'Import Excel' }}
                </button>

                <input
                    ref="importFileInput"
                    type="file"
                    accept=".xlsx, .xls"
                    @change="handleFileUpload"
                    class="hidden"
                />
            </div>
        </div>

        <div
            v-if="$page.props.flash && $page.props.flash.success"
            class="max-w-6xl mx-auto mb-4 p-4 bg-green-100 text-green-800 rounded"
        >
            {{ $page.props.flash.success }}
        </div>

        <div class="mb-10 max-w-6xl mx-auto bg-gray-50 p-6 rounded-lg">
            <h2 class="text-xl font-medium mb-4">Add Guest Book</h2>
            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <InputLabel for="title" value="Title" />
                    <TextInput
                        type="text"
                        id="title"
                        v-model="form.title"
                        class="mt-1 block w-full"
                        required
                    />
                </div>

                <div class="mb-4">
                    <InputLabel for="content" value="Content" />
                    <textarea
                        id="content"
                        v-model="form.content"
                        rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        required
                    />
                </div>

                <div class="mb-4">
                    <InputLabel for="author_name" value="Author name" />
                    <TextInput
                        type="text"
                        id="author_name"
                        v-model="form.author_name"
                        class="mt-1 block w-full"
                        required
                    />
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                        :disabled="processing"
                    >
                        {{ processing ? 'Adding...' : 'Add new book' }}
                    </button>
                </div>
            </form>
        </div>

        <div v-if="hasBooks" class="space-y-6 mb-8 max-w-7xl mx-auto">
            <div v-for="book in guestBooks.data" :key="book.id" class="border rounded-lg p-4 shadow hover:shadow-md transition-shadow">
                <h3 class="text-lg font-semibold">{{ book.title }}</h3>
                <p class="mt-2 text-gray-700 whitespace-pre-line">{{ book.content }}</p>
                <div class="mt-4 flex justify-between text-sm text-gray-500">
                    <span>{{ book.author_name || 'Guest' }}</span>
                    <span>{{ formatDate(book.created_at) }}</span>
                </div>
            </div>
        </div>

        <div v-else class="py-8 text-center text-gray-500">
            No books
        </div>

    </section>
</template>

<style scoped>

</style>
