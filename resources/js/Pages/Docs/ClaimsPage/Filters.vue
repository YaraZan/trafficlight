<script setup>
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '../Navigation.vue';

</script>

<template>
    <Head title="Заявки" />

    <AuthorizedLayout>

        <div class="w-full flex gap-10 items-center justify-center py-24">

            <Navigation />

            <div class="relative flex flex-col w-2/5 gap-16">
                <h2 class="text-[48px] font-black text-gray-800 dark:text-gray-200">Фильтрация заявок</h2>

                <!-- Фильтр по НГДУ -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Фильтр по НГДУ</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Для просмотра заявок только по конкретным НГДУ в верхеней панели фильтров нажмите на кнопку
                            <b class="text-green-500">НГДУ</b> и в выпадающем списке выберите необходимые.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-21.png" alt="Таблица скважин">
                </div>

                <!-- Фильтр по статусу -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Фильтр по статусу</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Все заявки имеют свой статус. Для просмотра заявок конкретного нажмите на кнопку
                            <b class="text-green-500">Статус</b> и в выпадающем списке выберите необходимые.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-22.png" alt="Таблица скважин">
                </div>

                <!-- Основные фильтры -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Основные фильтры</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Помимо статуса и НГДУ, существует также стандартный набор фильтров для заявок, он включает в себя:

                            <b class="text-green-500">Тип заявок</b> - Переключатель определяет, показывать все заявки или только ваши.
                            <b class="text-green-500">Сортировка</b> - Сортирует отфильтрованные данные. На данный момент сортировка соуществляется по дате: раньше и позже.
                            <b class="text-green-500">Дата</b> - Окно в виде календаря, позволяющее выбрать дату или промежуток времени в котором находятся заявки.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-23.png" alt="Таблица скважин">
                </div>
            </div>

        </div>

    </AuthorizedLayout>
</template>
