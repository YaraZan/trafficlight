<script setup>
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '../Navigation.vue';

</script>

<template>
    <Head title="Диаграммы" />

    <AuthorizedLayout>

        <div class="w-full flex gap-10 items-center justify-center py-24">

            <Navigation />

            <div class="relative flex flex-col w-2/5 gap-16">
                <h2 class="text-[48px] font-black text-gray-800 dark:text-gray-200">Диаграммы</h2>

                <!-- Просмотр диаграмм -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Просмотр диаграмм</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Для просмотра диаграмм по параметрам скважины, нажмите на кнопку «Диаграммы», после чего будет выполнен перенос на страницу с диаграммами.
                            Каждая диаграмма – графическое отображения изменения значений параметров скважины за промежутки времени.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-14.png" alt="Таблица скважин">
                </div>


                <!-- Наложение диаграмм -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Наложение диаграмм</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Вы также можете выполнить наложение нескольких диаграмм друг на друга. <b class="text-red-500">Максимальное число наложений – 5</b>.
                            По необходимости также есть возможность показа графика установочных значений для параметров (По умолчанию уставка включена).
                            Для этого нужно нажать на переключатель в разделе «Уставка», затем появится ещё один график, более прозрачного цвета.
                        </p>
                    </div>
                    <video class="rounded-xl shadow-lg" controls src="/videos/docs-11.mp4"></video>
                </div>


            </div>

        </div>

    </AuthorizedLayout>
</template>
