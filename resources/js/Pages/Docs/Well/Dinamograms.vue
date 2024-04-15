<script setup>
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '../Navigation.vue';

</script>

<template>
    <Head title="Динамограммы" />

    <AuthorizedLayout>

        <div class="w-full flex gap-10 items-center justify-center py-24">

            <Navigation />

            <div class="relative flex flex-col w-2/5 gap-16">
                <h2 class="text-[48px] font-black text-gray-800 dark:text-gray-200">Динамограммы</h2>

                <!-- Просмотр -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Просмотр</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            При нажатии на вкладку <b class="text-green-500">«Динамограммы»</b>, вы можете увидеть список из карточек где самая первая будет выделена зелёным светом.
                            Каждая карточка – запись динамограммы. Над списком динамограмм находится окно с отображением точек динамограммы, соединённых линией.
                            Наведите курсор на любую из точек чтобы узнать нагрузку и положение штока.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-8.png" alt="Таблица скважин">
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-7.png" alt="Таблица скважин">
                </div>

                <!-- Наложение -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Наложение</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Также есть возможность наложения динамограмм одна на другую для просмотра изменений за промежутки времени.
                            Каждая выбранная динамограмма – соответствующего цвета. <b class="text-red-500">Максимальное количество наложений – 5</b>
                        </p>
                    </div>
                    <video class="rounded-xl shadow-lg" controls src="/videos/docs-4.mp4"></video>
                </div>

                <!-- AI анализ -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">AI анализ (Тест)</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            На данный момент в приложении тестируется опознаватель динамограмм на базе искусственного интеллекта.
                            На данный момент доступна тестовая версия и она поддерживает отчёт как одной, так и нескольких динамограмм одновременно
                            (ответы ИИ могут быть недостоверны)
                        </p>
                    </div>
                    <video class="rounded-xl shadow-lg" controls src="/videos/docs-6.mp4"></video>
                </div>

                <!-- Фильтры -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Фильтры</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Динамограммы можно фильтровать по времени. Для этого нужно нажать на ввод с надписью «Дата» и выбрать нужное число. <br> <br>
                            Для выбора промежутка времени нажмите сначала на одну дату, затем на другую (от-до соотв.),
                            для поиска записей за один день нажмите на дату один раз, затем второй.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-9.png" alt="Таблица скважин">
                </div>

            </div>

        </div>

    </AuthorizedLayout>
</template>
