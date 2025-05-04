<script setup>
import {Head, Link, router, useForm} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import Pagination from "@/Components/Custom/Pagination.vue";
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
        <h1 class="text-2xl text-semibold">Progress table</h1>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                <table class="table-auto border-collapse border border-gray-400 m-2 caption-top max-w-7xl mx-auto">
                    <thead>
                    <tr>
                        <th class="border border-gray-300 py-2 px-3 text-center font-bold bg-gray-100 dark:bg-gray-700" colspan="9">
                            План учебного прогресса
                        </th>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 py-2 px-3" rowspan="2">№</th>
                        <th class="border border-gray-300 py-2 px-3" rowspan="2">Дисциплина</th>
                        <th class="border border-gray-300 py-2 px-3" rowspan="2">Кафедра</th>
                        <th class="border border-gray-300 py-2 px-3 text-center" colspan="6">Всего часов</th>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 py-2 px-3">Всего</th>
                        <th class="border border-gray-300 py-2 px-3">Ауд</th>
                        <th class="border border-gray-300 py-2 px-3">Лк</th>
                        <th class="border border-gray-300 py-2 px-3">Лб</th>
                        <th class="border border-gray-300 py-2 px-3">Пр</th>
                        <th class="border border-gray-300 py-2 px-3">СРС</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="border border-gray-300 py-2 px-3 text-center">1</td>
                        <td class="border border-gray-300 py-2 px-3">Экология</td>
                        <td class="border border-gray-300 py-2 px-3">БЖ</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">54</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">27</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">18</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">0</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">9</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">27</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-2 px-3 text-center">2</td>
                        <td class="border border-gray-300 py-2 px-3">Высшая математика</td>
                        <td class="border border-gray-300 py-2 px-3">ВМ</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">540</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">282</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">141</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">0</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">141</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">258</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-2 px-3 text-center">3</td>
                        <td class="border border-gray-300 py-2 px-3">Русский язык и культура речи</td>
                        <td class="border border-gray-300 py-2 px-3">НГиГ</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">108</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">54</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">18</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">0</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">36</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">54</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-2 px-3 text-center">4</td>
                        <td class="border border-gray-300 py-2 px-3">Основы дискретной математики</td>
                        <td class="border border-gray-300 py-2 px-3">ИС</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">144</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">72</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">36</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">18</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">18</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">72</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-2 px-3 text-center">5</td>
                        <td class="border border-gray-300 py-2 px-3">Основы программирования и алгоритмизации</td>
                        <td class="border border-gray-300 py-2 px-3">ИС</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">216</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">108</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">36</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">36</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">36</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">108</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-2 px-3 text-center">6</td>
                        <td class="border border-gray-300 py-2 px-3">Основы экологии</td>
                        <td class="border border-gray-300 py-2 px-3">ИС</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">72</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">36</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">18</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">0</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">18</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">36</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-2 px-3 text-center">7</td>
                        <td class="border border-gray-300 py-2 px-3">Теория вероятностей и математическая статистика</td>
                        <td class="border border-gray-300 py-2 px-3">ПЭОП</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">180</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">90</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">36</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">18</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">36</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">90</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-2 px-3 text-center">8</td>
                        <td class="border border-gray-300 py-2 px-3">Физика</td>
                        <td class="border border-gray-300 py-2 px-3">Физики</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">324</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">162</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">72</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">54</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">36</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">162</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-2 px-3 text-center">9</td>
                        <td class="border border-gray-300 py-2 px-3">Основы электротехники и электроники</td>
                        <td class="border border-gray-300 py-2 px-3">ИС</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">144</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">72</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">36</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">18</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">18</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">72</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-2 px-3 text-center">10</td>
                        <td class="border border-gray-300 py-2 px-3">Числовые методы в информатике</td>
                        <td class="border border-gray-300 py-2 px-3">ИС</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">126</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">64</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">32</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">16</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">16</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">62</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-2 px-3 text-center">11</td>
                        <td class="border border-gray-300 py-2 px-3">Методы исследования операций</td>
                        <td class="border border-gray-300 py-2 px-3">ИС</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">162</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">81</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">36</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">18</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">27</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">81</td>
                    </tr>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</template>

<style scoped>

</style>

