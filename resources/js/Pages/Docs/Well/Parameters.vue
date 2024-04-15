<script setup>
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '../Navigation.vue';

</script>

<template>
    <Head title="Параметры" />

    <AuthorizedLayout>

        <div class="w-full flex gap-10 items-center justify-center py-24">

            <Navigation />

            <div class="relative flex flex-col w-2/5 gap-16">
                <h2 class="text-[48px] font-black text-gray-800 dark:text-gray-200">Параметры</h2>

                <!-- Значения параметров -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Значения параметров</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            При посещении страницы скважины вы первым делом увидите карточки с её <b>параметрами</b> и их значениями.
                            Каждая карточка хранит следующую информацию: <br> <br>
                            Наименование – сокращённая и полная версии названия параметра <br>
                            <i class="text-green-500">Факт</i> – фактическое значение параметра, полученное с контроллера <br>
                            <i class="text-green-500">Уставка</i> – установочное значение параметра, полученное с контроллера <br>
                            <i class="text-green-500">АРМИТС</i> – фактическое значение, полученное с КИС АРМИТС <br>
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-6.png" alt="Таблица скважин">
                </div>

                <!-- Установка значений параметров -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Установка значений параметров</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            В случае, когда ваша роль позволяет менять значения параметров скважины, вы увидите характерную зелёную обводку вокруг карточек при наведении.
                            По нажатию на карточку вы увидите окно, где сможете ввести новую <b>уставку</b>, по которой должна работать скважина
                        </p>
                    </div>
                    <video class="rounded-xl shadow-lg" controls src="/videos/docs-3.mp4"></video>
                </div>

            </div>

        </div>

    </AuthorizedLayout>
</template>
