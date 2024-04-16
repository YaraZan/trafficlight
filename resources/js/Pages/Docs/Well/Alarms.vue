<script setup>
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '../Navigation.vue';

</script>

<template>
    <Head title="Аварии" />

    <AuthorizedLayout>

        <div class="w-full flex gap-10 items-center justify-center py-24">

            <Navigation />

            <div class="relative flex flex-col w-2/5 gap-16">
                <h2 class="text-[48px] font-black text-gray-800 dark:text-gray-200">Аварии</h2>

                <!-- Просмотр аварий -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Просмотр аварий</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Для просмотра аварий скважины, нажмите на кнопку «Аварии», после чего будет выполнен перенос на страницу с авариями.
                            Каждая запись хранит <b>дату</b>, <b>регистр</b> и <b>расшифровку регистра</b> аварии.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-12.png" alt="Таблица скважин">
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-13.png" alt="Таблица скважин">
                </div>


                <!-- Просмотр всех аварий -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Просмотр всех аварий</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Для просмотра всех аварий по доступным скважинам нажмите на значок аварий в главном навигационном меню слева
                        </p>
                    </div>
                    <video class="rounded-xl shadow-lg" controls src="/videos/docs-9.mp4"></video>
                </div>


            </div>

        </div>

    </AuthorizedLayout>
</template>
