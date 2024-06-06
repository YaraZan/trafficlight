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
            <NewValueInput v-model="form.new_value" />
        </div>

        <!-- Current values -->
        <div class="p-5 w-full flex flex-col gap-3 border-b border-gray-200 dark:border-gray-700">
            <span class="text-sm text-gray-800 dark:text-white font-semibold">Текущие значения</span>
            <CurrentValues
                @load="handleLoadCurrentValue"
                v-model:well="form.well_id"
                v-model:category="form.category_id" />
        </div>

        <div class="p-5 w-full flex flex-col gap-3">
            <button @click.prevent="submit" class="flex w-full items-center justify-center rounded-lg p-2 bg-green-600 border border-green-400 hover:bg-opacity-80 dark:hover:bg-opacity-80">
                <Spinner v-if="form.processing" color="white" />
                <span v-else class="text-white font-semibold text-sm">Создать</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import WellsDropdown from './WellsDropdown.vue';
import CategoryDropdown from './CategoryDropdown.vue';
import NewValueInput from './NewValueInput.vue';
import CurrentValues from './CurrentValues.vue';
import { useForm } from '@inertiajs/vue3';
import { Spinner } from 'flowbite-vue';

const emit = defineEmits(['created', 'error']);

const form = useForm({
    well_id: null,
    category_id: null,
    old_value: null,
    new_value: 1,
})

function submit() {
    form.post(route('claims.create'), {
        onSuccess: () => {
            emit('created');
        },
        onError: () => {
            emit('error');
        }
    });
}

function handleSelectWell(well) {
    form.well_id = well.id;
};

function handleSelectCategory(category) {
    form.category_id = category.id;
};

function handleLoadCurrentValue(currentValues) {
    form.old_value = currentValues.CurrentValue;
};
</script>
