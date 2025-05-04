<script setup>
import {Head, Link, router, useForm, usePage} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    errors: Object
});

const formatPhone = (event) => {
    let value = event.target.value.replace(/\D/g, '');

    if (value.length > 10) {
        value = value.slice(0, 10);
    }

    if (value.length > 0) {
        value = '7' + value;

        if (value.length > 7) {
            value = value.substring(0, 7) + '-' + value.substring(7);
        }

        if (value.length > 10) {
            value = value.substring(0, 10) + '-' + value.substring(10);
        }
    }

    form.phone = value;
};


const form = useForm({
    full_name: '',
    phone: '',
    email: '',
    question: '',
});

const processing = ref(false);

const submitForm = () => {
    processing.value = true;

    router.post(route('contact.store'), form, {
        onSuccess: () => {
            form.reset();
        },
        onFinish: () => {
            processing.value = false;
        }
    });
};

const hasErrors = computed(() => {
    return Object.keys(usePage().props.errors || {}).length > 0;
});

const formattedErrors = computed(() => {
    if (!usePage().props.errors) return [];

    return Object.values(usePage().props.errors);
});

</script>

<template>
    <Head title="Контакты"/>

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
        <h1 class="text-2xl text-semibold">Свяжитесь с нами</h1>
    </div>

    <section>
        <div class="mb-10 max-w-2xl mx-auto bg-gray-50 p-6 rounded-lg shadow-sm">
            <h2 class="text-xl font-medium mb-4">Форма обратной связи</h2>

            <div v-if="$page.props.flash && $page.props.flash.success"
                 class="mb-4 p-3 bg-green-100 text-green-800 rounded-md">
                {{ $page.props.flash.success }}
            </div>

            <div v-if="hasErrors" class="mb-4 p-3 bg-red-100 text-red-800 rounded-md">
                <h3 class="font-semibold mb-2">Пожалуйста, исправьте следующие ошибки:</h3>
                <ul class="list-disc list-inside">
                    <li v-for="(error, index) in formattedErrors" :key="index">
                        {{ error }}
                    </li>
                </ul>
            </div>

            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <InputLabel for="full_name" value="Полное имя" />
                    <TextInput
                        id="full_name"
                        v-model="form.full_name"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                    />
                    <InputError :message="form.errors.full_name" class="mt-1" />
                </div>

                <div class="mb-4">
                    <InputLabel for="phone" value="Телефон" />
                    <TextInput
                        id="phone"
                        v-model="form.phone"
                        @input="formatPhone"
                        type="tel"
                        class="mt-1 block w-full"
                        required
                        placeholder="+7 (999) 999-99-99"
                    />
                    <InputError :message="form.errors.phone" class="mt-1" />
                </div>

                <div class="mb-4">
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full"
                        required
                    />
                    <InputError :message="form.errors.email" class="mt-1" />
                </div>

                <div class="mb-4">
                    <InputLabel for="question" value="Ваш вопрос" />
                    <textarea
                        id="question"
                        v-model="form.question"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
                        rows="4"
                        required
                    ></textarea>
                    <InputError :message="form.errors.question" class="mt-1" />
                </div>

                <div class="flex items-center justify-end">
                    <button
                        :disabled="processing"
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                    >
                        <span v-if="processing">Отправка...</span>
                        <span v-else>Отправить сообщение</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
</template>

<style scoped>
</style>
