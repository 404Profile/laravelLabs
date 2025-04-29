<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Progress table">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Progress table
            </h2>
        </template>

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
    </AppLayout>
</template>
