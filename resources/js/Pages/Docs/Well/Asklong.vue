<script setup>
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '../Navigation.vue';

</script>

<template>
    <Head title="Опросы" />

    <AuthorizedLayout>

        <div class="w-full flex gap-10 items-center justify-center py-24">

            <Navigation />

            <div class="relative flex flex-col w-2/5 gap-16">
                <h2 class="text-[48px] font-black text-gray-800 dark:text-gray-200">Опросы</h2>

                <!-- Просмотр часовых архивов -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Просмотр опросов скважины</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Для просмотра записей об опросах, нажмите на кнопку «Опросы», после чего будет выполнен перенос на страницу с опросами.
                            Опрос – это момент снятия данных с контроллеров для последующей записи в базу данных
                            Каждый опрос представляет собой небольшой отчёт со следующей информацией: <br> <br>
                            <i class="text-green-500">Дата</i> - дата и время выполнения опроса <br>
                            <i class="text-green-500">Связь</i> - обозначает была ли установлена связь на момент опроса <br>
                            <i class="text-green-500">Интервал</i> - сколько времени занял опрос <br>
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-15.png" alt="Таблица скважин">
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-16.png" alt="Таблица скважин">
                </div>
            </div>

        </div>

    </AuthorizedLayout>
</template>
