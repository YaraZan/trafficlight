<template>
    <div class="fixed w-[300px] top-[51px] left-[50px] h-screen flex flex-col border-r border-gray-200 dark:border-gray-700">

                <h2 class="w-full p-10 border-b border-gray-200 dark:border-gray-700 text-[16px] text-gray-800 dark:text-white font-semibold select-none">Документация</h2>

                <div class="w-full p-10 border-b border-gray-200 dark:border-gray-700 flex flex-col gap-2">
                    <span class="text-sm text-gray-400 dark:text-gray-300 font-medium select-none">Матрица</span>
                    <Link :href="route('docs.matrix.table')">
                        <span class="text-gray-500 hover:text-green-500 dark:hover:text-green-500 text-sm font-medium" :class="{ 'text-green-500 dark:text-green-500' : $page.component.includes('Docs/MatrixPage/Table') }">
                            Таблица
                        </span>
                    </Link>
                    <Link :href="route('docs.matrix.filters')">
                        <span class="text-gray-500 hover:text-green-500 dark:hover:text-green-500 text-sm font-medium" :class="{ 'text-green-500 dark:text-green-500' : $page.component.includes('Docs/MatrixPage/Filters') }">
                            Фильтры
                        </span>
                    </Link>
                </div>

                <div class="w-full p-10 flex flex-col gap-2">
                    <span class="text-sm text-gray-400 dark:text-gray-300 font-medium select-none">Скважина</span>
                    <Link :href="route('docs.well.parameters')">
                        <span class="text-gray-500 hover:text-green-500 dark:hover:text-green-500 text-sm font-medium" :class="{ 'text-green-500 dark:text-green-500' : $page.component.includes('Docs/Well/Parameters') }">
                            Параметры
                        </span>
                    </Link>
                    <Link :href="route('docs.well.dinamograms')">
                        <span class="text-gray-500 hover:text-green-500 dark:hover:text-green-500 text-sm font-medium" :class="{ 'text-green-500 dark:text-green-500' : $page.component.includes('Docs/Well/Dinamograms') }">
                            Динамограммы
                        </span>
                    </Link>
                    <Link :href="route('docs.well.claims')">
                        <span class="text-gray-500 hover:text-green-500 dark:hover:text-green-500 text-sm font-medium" :class="{ 'text-green-500 dark:text-green-500' : $page.component.includes('Docs/Well/Claims') }">
                            Заявки
                        </span>
                    </Link>
                    <Link :href="route('docs.well.diagrams')">
                        <span class="text-gray-500 hover:text-green-500 dark:hover:text-green-500 text-sm font-medium" :class="{ 'text-green-500 dark:text-green-500' : $page.component.includes('Docs/Well/Diagrams') }">
                            Диаграммы
                        </span>
                    </Link>
                    <Link :href="route('docs.well.alarms')">
                        <span class="text-gray-500 hover:text-green-500 dark:hover:text-green-500 text-sm font-medium" :class="{ 'text-green-500 dark:text-green-500' : $page.component.includes('Docs/Well/Alarms') }">
                            Аварии
                        </span>
                    </Link>
                    <Link :href="route('docs.well.archive')">
                        <span class="text-gray-500 hover:text-green-500 dark:hover:text-green-500 text-sm font-medium" :class="{ 'text-green-500 dark:text-green-500' : $page.component.includes('Docs/Well/Archive') }">
                            Архивы
                        </span>
                    </Link>
                    <Link :href="route('docs.well.asklong')">
                        <span class="text-gray-500 hover:text-green-500 dark:hover:text-green-500 text-sm font-medium" :class="{ 'text-green-500 dark:text-green-500' : $page.component.includes('Docs/Well/AskLong') }">
                            Опросы
                        </span>
                    </Link>
                </div>
            </div>
</template>

<script setup>
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';

</script>
