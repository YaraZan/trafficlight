<template>
    <div class="
    w-[calc(100vw-20px)]
    md:w-[500px]
    flex flex-col border border-gray-200 dark:border-gray-700 rounded-xl font-montserrat overflow-visible">

        <div class="p-5 flex flex-col items-center justify-center gap-5 border-b border-gray-200 dark:border-gray-700">
            <span class=" text-xl text-gray-800 dark:text-white font-semibold">Новая заявка</span>
            <p class="p-4 bg-gray-100 dark:bg-gray-900 rounded-md text-sm text-normal text-gray-400">
                Примечание: Отправленные вами данные будут сформированы в заявку, и, по возможности
                приняты или отклонены оператором.
            </p>
        </div>

        <!-- Select well -->
        <div class="p-5 w-full flex flex-col gap-3 border-b border-gray-200 dark:border-gray-700">
            <span class="text-sm text-gray-800 dark:text-white font-semibold">Выберите скважину</span>
            <WellsDropdown  @select="handleSelectWell" />
        </div>

        <!-- Select category -->
        <div class="p-5 w-full flex flex-col gap-3 border-b border-gray-200 dark:border-gray-700">
            <span class="text-sm text-gray-800 dark:text-white font-semibold">Выберите категорию</span>
            <CategoryDropdown @select="handleSelectCategory" />
        </div>

        <!-- Input value -->
        <div class="p-5 w-full flex flex-col gap-3 border-b border-gray-200 dark:border-gray-700">
            <span class="text-sm text-gray-800 dark:text-white font-semibold">Введите новое значение</span>
            <NewValueInput />
        </div>

        <div class="p-5 w-full flex flex-col gap-3">
            <button class="w-full text-center rounded-lg p-2 text-white font-semibold text-sm bg-green-600 border border-green-400 hover:bg-opacity-80 dark:hover:bg-opacity-80">
                Создать
            </button>
        </div>
    </div>
</template>

<script setup>
import WellsDropdown from './WellsDropdown.vue';
import CategoryDropdown from './CategoryDropdown.vue';
import NewValueInput from './NewValueInput.vue';
import { ref } from 'vue';

const selectedWell = ref(null);
const selectedCategory = ref(null);

function handleSelectWell(well) {
    selectedWell.value = well;
};

function handleSelectCategory(well) {
    selectedCategory.value = well;
};
</script>
