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
                <h2 class="text-[48px] font-black text-gray-800 dark:text-gray-200">Создание</h2>

                <!-- Новая заявка -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Новая заявка</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Для создания новой заявки на изменение значений параметров скважины нажмите на поле <b class="text-green-500">Новая заявка</b>.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-17.png" alt="Таблица скважин">
                </div>

                <!-- Выбор параметров -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Выбор параметров</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            В открывшемся окне, выберите нужную скважину и параметр, который собираетесь записать. После выбора в поле
                            <b class="text-green-500">Текущие значения</b> появятся данные о фактическом и установочном текущем значении
                            конкретного параметра на конкретной скважине. В поле <b class="text-green-500">Введите новое значение</b>
                            вам необходимо будет вписать новое значение для параметра, затем нажать кнопку <b class="text-green-500">Создать</b>.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-18.png" alt="Таблица скважин">
                </div>

                <!-- Дополнительно -->
                <div class="flex flex-col gap-10 border border-green-500 rounded-lg p-4">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-green-500">Дополнительно</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
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
