<script setup>
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '../Navigation.vue';

</script>

<template>
    <Head title="Фильтры" />

    <AuthorizedLayout>

        <div class="w-full flex gap-10 items-center justify-center py-24">

            <Navigation />

            <div class="relative flex flex-col w-2/5 gap-16">
                <h2 class="text-[48px] font-black text-gray-800 dark:text-gray-200">Фильтры</h2>

                <!-- Фильтр по НГДУ -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Фильтр по НГДУ</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Предоставляет возможность фильтровать скважины по НГДУ, а также по цехам, принадлежащим данному НГДУ.
                            Поставьте или уберите галочки на НГДУ и цехах для изменений списка. По умолчанию выбраны все НГДУ и цеха доступные пользователю.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-3.png" alt="Таблица скважин">
                </div>

                <!-- Фильтр по названию -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Фильтр по названию</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Предоставляет возможность фильтровать скважины по названию.
                            Поиск работает как на полное название скважины, так и на номера c НГДУ отдельно.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-4.png" alt="Таблица скважин">
                </div>

                <!-- Фильтр по связи -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Фильтр по связи</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-400 leading-6 text-justify">
                            Предоставляет возможность фильтровать скважины по наличию связи с ними.
                            По умолчанию отображены все скважины вперемешку.
                        </p>
                    </div>
                    <img class="w-full rounded-xl shadow-lg" src="/images/docs/docs-5.png" alt="Таблица скважин">
                </div>

                <!-- Экспорт в Excel (Тест) -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-4">
                        <h4 class="text-[24px] font-semibold text-gray-700 dark:text-gray-200">Экспорт в Excel (Тест)</h4>
                        <p class="text-sm font-normal text-gray-600 dark:text-gray-200 leading-6 text-justify">
                            Иногда необходимо быстро экспортировать данные в табличный .xlsx формат.
                            Для этого в приложении существует возможность быстрого экспорта в Excel документ.
                            Настройте фильтры как вам нужно и нажмите на зелёную кнопку «Excel», после чего откройте скачанный файл. <br> <br>
                            Экспортируемые данные идентичны тем что вы видите на экране «Светофор».
                            Например, если вам нужно выгрузить данные по всем скважинам, то перед этим, рядом с навигацией по страницам матрицы, выберите «Все записи»
                        </p>
                    </div>
                    <video class="rounded-xl shadow-lg" controls src="/videos/docs-2.mp4"></video>
                </div>
            </div>

        </div>

    </AuthorizedLayout>
</template>
