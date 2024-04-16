<script setup>
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '../Navigation.vue';

</script>

<template>
    <Head title="Таблица" />

    <AuthorizedLayout>

        <div class="w-full flex gap-10 items-center justify-center py-24">

            <Navigation />

            <div class="relative flex flex-col w-2/5 gap-16">
                <h2 class="text-[48px] font-black text-gray-800 dark:text-gray-200">Таблица</h2>

                <!-- Таблица -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Заголовки таблицы</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            На главной странице вы можете видеть "матрицу", это табличное представление актуальных данных по нефтяным скважинам.
                            В верхней части таблицы распологается шапка с наименованиями столбцов таблицы. По тем полям, что содержат "стрелочки"
                            возле названия можно произвести <b class="text-green-500">сортировку</b> по нажатию на них
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-1.png" alt="Таблица скважин">
                </div>

                <!-- Содержание таблицы -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Содержание таблицы</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Каждая строка таблицы – статистическое представление скважины. <br>
                            <b class="text-green-500">Связь</b>  – Показывает установлена ли связь со скважиной для сбора данных.
                            На некоторых скважинах в ячейке «Связь» вы можете увидеть маленькую иконку монитора в углу.
                            Это означает, что данная скважина обладает «Веб визуализацией» на контроллере, и может быть просмотрена удалённо.
                            Для просмотра визуализации нажмите на ячейку связи со скважиной <br>
                            <b class="text-green-500">Опрос</b> – Показывает был ли выполнен опрос контроллеров <br>
                            <b class="text-green-500">Обзор</b> – Ссылка для просмотра детальной страницы скважины <br>
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-2.png" alt="Таблица скважин">
                </div>

                <!-- Режимы просмотра -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Режимы просмотра</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Просмотр скважин может осуществляться в двух видах: <br>
                            <b class="text-green-500">Таблица</b> – более детальный просмотр, с изображением всех параметров,
                            Детальные страницы открываются в новой вкладке <br>
                            <b class="text-green-500">Карточки</b> – отображают общую картину состояния скважин, без детализации.  <br>
                            Каждая карточка имеет только основную информацию по скважине, а также графическое изображение отклонений по 3-м основным параметрам в виде «столбиков»: Число качаний, нагрузка максимальная, нагрузка минимальная

                        </p>
                    </div>
                    <video class="rounded-xl shadow-lg" controls src="/videos/docs-1.mp4"></video>
                </div>
            </div>

        </div>

    </AuthorizedLayout>
</template>
