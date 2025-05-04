<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from "@inertiajs/vue3";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import {ref} from "vue";

const props = defineProps({
    testAnswers: Object,
})

const form = useForm({
    name: '',
    elementEcosystem: null,
    eating: '',
    wolf: false,
    rabbit: false,
    bear: false,
})

const reset = () => {
    form.reset();
}

const submitForm = () => {
    form.post(route('test.validate'), {
        preserveScroll: true,
    });

    form.reset();
}

const parseElementEcosystem = (el) => {
    return JSON.parse(el);
}

const isOpen = ref(false)

function closeModal() {
    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}

const getTotalScore = (answer) => {
    const data = parseElementEcosystem(answer.data);
    let score = 0;

    // Вопрос 1
    if (data.elementEcosystem[1]) score++;

    // Вопрос 2
    if (data.eating[1]) score++;

    // Вопрос 3
    if (data.wolf[1] && data.rabbit[1] && data.bear[1]) score++;

    return score;
}

const getScoreColor = (isCorrect) => {
    return isCorrect ? 'text-green-600' : 'text-red-600';
}

const formattedDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

</script>

<template>
    <AppLayout title="Test">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Test
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                    <form @submit.prevent="submitForm">
                        <div class="space-y-12">
                            <div class="border-b border-gray-900/10 pb-12 p-6">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">
                                    Тест
                                </h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">
                                    Тест по теме "Основы экологии"
                                </p>

                                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">
                                            Ваше ФИО:
                                        </label>
                                        <div class="mt-2">
                                            <div class="flex shadow-sm rounded-md ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-amber-600 sm:max-w-md">
                                                <span class="flex select-none items-center pl-3 text-gray-700 sm:text-sm">
                                                    ФИО:
                                                </span>
                                                <input v-model="form.name" type="text" name="name" id="name" class="focus:outline-none block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 sm:text-sm sm:leading-6" placeholder="введите ФИО">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="elementEcosystem" class="block text-sm font-medium leading-6 text-gray-900">
                                            Какой из перечисленных факторов НЕ является биотическим элементом экосистемы? (Вода)
                                        </label>
                                        <div class="mt-2">
                                            <select v-model="form.elementEcosystem" id="elementEcosystem" name="elementEcosystem" class="px-3 appearance-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-amber-600 focus:outline-none sm:max-w-xs sm:text-sm sm:leading-6">
                                                <option value="0">Выберите</option>
                                                <option value="1">Растения</option>
                                                <option value="2">Животные</option>
                                                <option value="3">Почва</option>
                                                <option value="4">Вода</option>
                                                <option value="5">Микроорганизмы</option>
                                                <option value="6">Грибы</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label for="eating" class="block text-sm font-medium leading-6 text-gray-900">
                                            Укажите организм, занимающий вершину пищевой пирамиды: (Человек)
                                        </label>
                                        <div class="mt-2">
                                            <div
                                                class="flex shadow-sm rounded-md ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-amber-600 sm:max-w-md">
                                                <span class="flex select-none items-center pl-3 text-gray-700 sm:text-sm">
                                                    Ответ:
                                                </span>
                                                <input type="text" name="eating" id="eating" v-model="form.eating" class="focus:outline-none block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 sm:text-sm sm:leading-6" placeholder="введите ответ">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <fieldset>
                                            <legend class="text-sm font-semibold leading-6 text-gray-900">
                                                Какие из перечисленных видов относятся к хищникам? (Волк, медведь)
                                            </legend>
                                            <div class="mt-6 space-y-6">
                                                <div class="relative flex gap-x-3">
                                                    <div class="flex h-6 items-center">
                                                        <input v-model="form.wolf" id="wolf" name="wolf" type="checkbox" class="accent-amber-600 h-4 w-4">
                                                    </div>
                                                    <div class="text-sm">
                                                        <label for="wolf" class="font-medium text-gray-900">
                                                            Волк
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="relative flex gap-x-3">
                                                    <div class="flex h-6 items-center">
                                                        <input v-model="form.rabbit" id="rabbit" name="rabbit" type="checkbox" class="accent-amber-600 h-4 w-4">
                                                    </div>
                                                    <div class="text-sm">
                                                        <label for="rabbit" class="font-medium text-gray-900">
                                                            Кролик
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="relative flex gap-x-3">
                                                    <div class="flex h-6 items-center">
                                                        <input v-model="form.bear" id="bear" name="bear" type="checkbox" class="accent-amber-600 h-4 w-4">
                                                    </div>
                                                    <div class="text-sm">
                                                        <label for="bear" class="font-medium text-gray-900">
                                                            Медведь
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-x-6 px-6 pb-4">
                            <button
                                type="button"
                                @click="openModal"
                                class="rounded-md bg-black/20 px-4 py-2 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
                            >
                                {{ $page.props.authUser.hasRole.admin ? 'All Answers' : 'My Answers' }}
                            </button>

                            <button type="reset" @click="reset"
                                    class="ml-4 relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-white text-gray-950 hover:bg-gray-50 ring-1 ring-gray-950/10">
                                Очистить
                            </button>
                            <button type="submit"
                                    class="relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-amber-600 text-white hover:bg-amber-500 focus-visible:ring-amber-500/50">
                                Отправить
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <TransitionRoot appear :show="isOpen" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-10">
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
                                class="w-full max-w-7xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                            >
                                <DialogTitle
                                    as="h3"
                                    class="text-lg font-medium leading-6 text-gray-900"
                                >
                                    <span>{{ $page.props.authUser.hasRole.admin ? 'All Answers' : 'Your answers on this test' }}</span>
                                </DialogTitle>
                                <div class="mt-2 overflow-x-auto">
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                № Попытки
                                            </th>
                                            <th v-if="$page.props.authUser.hasRole.admin" class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                ID пользователя
                                            </th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Дата
                                            </th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Вопрос 1
                                            </th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Вопрос 2
                                            </th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Вопрос 3
                                            </th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Общий балл
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(answer, index) in testAnswers" :key="index" class="hover:bg-gray-50">
                                            <td class="py-3 px-4 border-b border-gray-200">
                                                {{ index + 1 }}
                                            </td>
                                            <td v-if="$page.props.authUser.hasRole.admin" class="py-3 px-4 border-b border-gray-200">
                                                {{ answer.user_id }}
                                            </td>
                                            <td class="py-3 px-4 border-b border-gray-200">
                                                {{ answer.created_at }}
                                            </td>

                                            <!-- Вопрос 1 -->
                                            <td class="py-3 px-4 border-b border-gray-200">
                                                <div :class="getScoreColor(parseElementEcosystem(answer.data).elementEcosystem[1])">
                                                    <div>Ответ: {{ parseElementEcosystem(answer.data).elementEcosystem[0] }}</div>
                                                    <div class="text-xs font-medium mt-1">
                                                        {{ parseElementEcosystem(answer.data).elementEcosystem[1] ? '✓ Верно' : '✗ Неверно' }}
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Вопрос 2 -->
                                            <td class="py-3 px-4 border-b border-gray-200">
                                                <div :class="getScoreColor(parseElementEcosystem(answer.data).eating[1])">
                                                    <div>Ответ: {{ parseElementEcosystem(answer.data).eating[0] }}</div>
                                                    <div class="text-xs font-medium mt-1">
                                                        {{ parseElementEcosystem(answer.data).eating[1] ? '✓ Верно' : '✗ Неверно' }}
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Вопрос 3 -->
                                            <td class="py-3 px-4 border-b border-gray-200">
                                                <div :class="getScoreColor(parseElementEcosystem(answer.data).wolf[1] && parseElementEcosystem(answer.data).rabbit[1] && parseElementEcosystem(answer.data).bear[1])">
                                                    <div>
                                                        <span v-if="parseElementEcosystem(answer.data).wolf[0]">Волк </span>
                                                        <span v-if="parseElementEcosystem(answer.data).rabbit[0]">Кролик </span>
                                                        <span v-if="parseElementEcosystem(answer.data).bear[0]">Медведь</span>
                                                    </div>
                                                    <div class="text-xs font-medium mt-1">
                                                        {{ parseElementEcosystem(answer.data).wolf[1] && parseElementEcosystem(answer.data).rabbit[1] && parseElementEcosystem(answer.data).bear[1] ? '✓ Верно' : '✗ Неверно' }}
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Общий балл -->
                                            <td class="py-3 px-4 border-b border-gray-200 font-bold">
                                                {{ getTotalScore(answer) }}/3
                                            </td>
                                        </tr>

                                        <!-- Если нет результатов -->
                                        <tr v-if="!testAnswers || testAnswers.length === 0">
                                            <td :colspan="$page.props.authUser.hasRole.admin ? 7 : 6" class="py-4 px-4 text-center text-gray-500">
                                                Нет доступных результатов
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Легенда -->
                                <div class="mt-4 text-sm text-gray-600 bg-gray-50 p-3 rounded-md">
                                    <div class="font-semibold mb-2">Информация о вопросах:</div>
                                    <div class="mb-1">Вопрос 1: Какой из перечисленных факторов НЕ является биотическим элементом экосистемы? (Правильный ответ: Вода)</div>
                                    <div class="mb-1">Вопрос 2: Укажите организм, занимающий вершину пищевой пирамиды (Правильный ответ: Человек)</div>
                                    <div>Вопрос 3: Какие из перечисленных видов относятся к хищникам? (Правильные ответы: Волк и медведь)</div>
                                </div>


                                <div class="mt-4">
                                    <button
                                        type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="closeModal"
                                    >
                                        Got it, thanks!
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>

    </AppLayout>
</template>
