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
                <h2 class="text-[48px] font-black text-gray-800 dark:text-gray-200">Заявки</h2>

                <!-- Просмотр -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Изменение параметров</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            На вкладке «Заявки» будут храниться все операции с изменениями значений параметров на скважине.
                            Также вы можете отфильтровать данные заявки с помощью переключателей на панели справа: <br> <br>
                            <i class="text-green-500">Мои</i> – ваши отправленные заявки
                            <i class="text-green-500">История</i> – заявки других пользователей (в том числе и ваши)
                            <i class="text-green-500">*Утверждение</i> – у некоторых пользователей есть возможность утверждать ваши заявки, т.е. отметить их как корректные и дать заявке «вступить в силу».
                        </p>
                    </div>
                    <video class="rounded-xl shadow-lg" controls src="/videos/docs-7.mp4"></video>
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

            </div>

        </div>

    </AuthorizedLayout>
</template>
