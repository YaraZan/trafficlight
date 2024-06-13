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
                <h2 class="text-[48px] font-black text-gray-800 dark:text-gray-200">Действия</h2>

                <!-- Удаление заявки -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Удаление заявки</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            В случае, если заявка была создана вами случайно или, содержит ошибки, вы можете
                            <b class="text-green-500">удалить заявку</b>. <br>
                            Примечание: Вы можете удалить только заявку со статусом "На рассмотрении",
                            т.е, не проверенную оператором или коорденатором.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-19.png" alt="Таблица скважин">
                </div>

                <!-- Утверждение и отклонение заявки -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Утверждение и отклонение заявки</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Если ваша роль позволяет вам оперировать заявками, то, при просмотре, вы увидите две кнопки: <br> <br>
                            <b class="text-red-500">Отклонить</b> - Заявка содержит некорректную информацию и не может быть выпущена в производство. <br>
                            <b class="text-purple-500">Утвердить</b> - Заявка содержит корректную информацию и может быть выпущена в производство.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-20.png" alt="Таблица скважин">
                </div>

            </div>

        </div>

    </AuthorizedLayout>
</template>
