<script setup>
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Документация: Матрица" />

    <AuthorizedLayout>

        <div class="w-full flex gap-10 items-center justify-center pt-24">


            <div class="fixed top-40 left-40 flex flex-col gap-2 items-end p-10 border-r border-gray-200 dark:border-gray-700">
                    <Link :href="route('docs.matrix')" >
                        <span class="text-gray-400 dark:text-gray-600 hover:text-gray-800 dark:hover:text-white text-sm font-medium" :class="{ 'text-green-500 dark:text-green-500' : $page.component.includes('Docs/Matrix') }">
                            Матрица
                        </span>
                    </Link>
                    <Link :href="route('docs.detail')" >
                        <span class="text-gray-400 dark:text-gray-600 hover:text-gray-800 dark:hover:text-white text-sm font-medium" :class="{ 'text-green-500 dark:text-green-500' : $page.component.includes('Docs/Detail') }">
                            Страница скважины
                        </span>
                    </Link>
                </div>

            <div class="relative flex flex-col w-2/5 gap-18">
                <h2 class="text-[72px] font-black text-gray-800 dark:text-white">Матрица</h2>

                <div class="flex flex-col gap-10">

                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Просмотр данных в таблице</h4>
                        <p class="text-sm font-normal text-gray-400">
                            На главной странице вы можете видеть "матрицу", это табличное представление актуальных данных по нефтяным скважинам.
                            В верхней части таблицы распологается шапка с наименованиями столбцов таблицы. По тем полям, что содержат "стрелочки"
                            возле названия можно произвести <b class="text-green-500">сортировку</b> по нажатию на них.
                        </p>
                    </div>

                    <img class="w-full rounded-xl shadow-lg" src="/images/docs-1.png" alt="Таблица скважин">

                    <p class="text-sm font-normal text-gray-400">
                        Ниже распологаются строки с данными. Каждая строка представляет собой скважину, с актуальными для неё параметрами.
                    </p>

                    <video class="rounded-xl" controls src="/videos/dinamogramm.mp4">

                    </video>

                    <img class="w-full rounded-xl shadow-lg" src="/images/docs-2.png" alt="Таблица скважин">

                </div>

            </div>

        </div>

    </AuthorizedLayout>
</template>
