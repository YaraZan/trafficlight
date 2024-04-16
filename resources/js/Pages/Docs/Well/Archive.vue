<script setup>
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '../Navigation.vue';

</script>

<template>
    <Head title="Архивы" />

    <AuthorizedLayout>

        <div class="w-full flex gap-10 items-center justify-center py-24">

            <Navigation />

            <div class="relative flex flex-col w-2/5 gap-16">
                <h2 class="text-[48px] font-black text-gray-800 dark:text-gray-200">Архивы</h2>

                <!-- Просмотр часовых архивов -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Просмотр часовых архивов</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Для просмотра архивов параметров скважины, нажмите на кнопку «Архивы», после чего будет выполнен перенос на страницу с архивами.
                            Каждая запись хранит <b>дату</b>, <b>регистр</b> и <b>расшифровку регистра</b> аварии. <br> <br>
                            Далее на странице часовых архивов вы можете выбрать запись с показателями параметров скважины за нужное вам число.
                            Чтобы перейти к просмотру параметров необходимо нажать на зелёную надпись «Просмотр»
                        </p>
                    </div>
                    <video class="rounded-xl shadow-lg" controls src="/videos/docs-10.mp4"></video>
                </div>
            </div>

        </div>

    </AuthorizedLayout>
</template>
