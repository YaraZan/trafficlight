<template>
    <div class="relative flex flex-col">
        <Button
            text="Фильтры"
            @click="showClaimFiltersDropdown = !showClaimFiltersDropdown"
            :is-active="showClaimFiltersDropdown">
            <template v-slot:prefix>
                <svg width="32" height="32" viewBox="0 0 32 32" class="stroke-gray-400 fill-none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.0244 28.6829V17.859C15.0244 17.6671 14.9537 17.4819 14.8258 17.3388L4.67492 5.98358C4.2254 5.48073 4.58231 4.68292 5.2568 4.68292H26.8255C27.4865 4.68292 27.8482 5.45333 27.426 5.96195L19.9025 15.0244" stroke-width="2.34146" stroke-linecap="round"/>
                </svg>
            </template>
        </Button>
        <div v-show="showClaimFiltersDropdown" class="top-[110%] z-[50] absolute shadow-lg w-auto flex flex-col bg-white border border-gray-300 dark:bg-gray-900 dark:border-gray-700 rounded-lg select-none">

            <!-- Radio -->
            <div class="p-5 flex flex-col gap-4 w-full border-b border-gray-200 dark:border-gray-700">
                <span class="text-sm text-gray-800 dark:text-white font-semibold">Тип заявок</span>
                <ClaimsRadio @change="handleChangeRadio" />
            </div>

            <!-- Sorting -->
            <div class="p-5 flex flex-col gap-4 w-full border-b border-gray-200 dark:border-gray-700">
                <span class="text-sm text-gray-800 dark:text-white font-semibold">Сортировка</span>
                <ClaimsSorting @change="handleChangeSorting" />
            </div>

            <!-- Data -->
            <div class="p-5 flex flex-col gap-4 w-full">
                <span class="text-sm text-gray-800 dark:text-white font-semibold">Дата</span>
                <DatePicker @change="handleChangeDate" />
            </div>
        </div>
    </div>
</template>

<script setup>
import Button from '@/Components/Button.vue';
import ClaimsSorting from './ClaimsSorting.vue';
import { onMounted, ref } from 'vue';
import { SORTING_TYPES, RADIO_TYPES } from './constraints.js'
import ClaimsRadio from './ClaimsRadio.vue';
import DatePicker from './DatePicker.vue';

const showClaimFiltersDropdown = ref(false);

function handleChangeSorting(sorting) {
    emit('change-sorting', sorting);
}

function handleChangeRadio(radio) {
    emit('change-radio', radio);
}

function handleChangeDate(dates) {
    emit('change-date', dates);
}

onMounted(() => {
    emit('change-sorting', SORTING_TYPES[0]);
    emit('change-radio', RADIO_TYPES[0]);
})

const emit = defineEmits(['change-sorting', 'change-date', 'change-radio']);
</script>
