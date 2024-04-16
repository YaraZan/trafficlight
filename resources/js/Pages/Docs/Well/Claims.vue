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

                <!-- Изменение параметров -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Изменение параметров</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            На вкладке «Заявки» хранятся все операции с изменениями значений параметров на скважине.
                            Вы можете отфильтровать данные заявки с помощью переключателей на панели справа: <br> <br>
                            <i class="text-green-500">Мои</i> – ваши заявки на изменение параметров <br>
                            <i class="text-green-500">История</i> – заявки других пользователей (в том числе и ваши) <br>
                            <i class="text-green-500">* Утверждение</i> – у некоторых пользователей есть возможность утверждать ваши заявки, т.е. отметить их как корректные и дать заявке «вступить в силу»
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-10.png" alt="Таблица скважин">
                </div>

                <!-- Перемещение оборудования -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Перемещение оборудования</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            На вкладке «Перемещение» находится история передвижений оборудования данной скважины.
                            Вы можете отфильтровать данные заявки с помощью переключателей на панели справа: <br> <br>
                            <i class="text-green-500">Мои</i> – ваши заявки на передвижение оборудования <br>
                            <i class="text-green-500">История</i> – заявки других пользователей (в том числе и ваши)
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-11.png" alt="Таблица скважин">
                </div>

                <!-- Новое перемещение -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Новое перемещение</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Для создания заявки на перемещение оборудования перейдите во вкладку «Перемещение», затем в меню справа, выберите «Мои».
                            Возле навигации по страницам заявок появится зелёная кнопка с надписью «Перемещение», нажмите её. <br> <br>
                            В появившемся окне вам необходимо будет указать <b>идентификатор скважины АРМИТС</b>,
                            на которую будет осуществляться перемещение оборудования с текущей скважины, данный параметр <b class="text-red-500">обязательный</b>.
                            Также вы можете указать <b>вес колонны штанг</b> и оставить <b>комментарий</b>, если это необходимо
                        </p>
                    </div>
                    <video class="rounded-xl shadow-lg" controls src="/videos/docs-8.mp4"></video>
                </div>

                <!-- Дополнительно -->
                <div class="flex flex-col gap-10 border border-green-500 rounded-lg p-4">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-green-500">Дополнительно</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            После создания заявки на вкладке «Параметры», вы автоматически перенесётесь на вкладку «Заявки».
                            До тех пор, пока статус вашей заявки «На рассмотрении» вы можете удалить заявку.  <br> <br>
                            У каждой заявки есть статус для отображения её состояния.
                            Например, у заявок на изменение работы скважины есть следующие статусы: <br> <br>
                            <i class="text-green-500">На рассмотрении</i> – заявка ещё не обработана оператором <br>
                            <i class="text-green-500">Утверждено</i> – заявка была рассмотрена оператором, утверждена как корректная и скоро будет выполнена <br>
                            <i class="text-green-500">Выполнено</i> – заявка была выполнена, изменения скоро вступят в силу <br>
                            <i class="text-green-500">Отклонено</i> – заявка была отклонена (признана как некорректная) <br> <br>
                            Статусы для заявок на передвижение оборудования (вкладка «Передвижение») идентичны, но не требуют утверждения,
                            вместо этого, у заявок есть статус «Уточнение», который обозначает, что заявка уточняется для выполнения и, возможно,
                            в скором времени её статус изменится
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </AuthorizedLayout>
</template>
