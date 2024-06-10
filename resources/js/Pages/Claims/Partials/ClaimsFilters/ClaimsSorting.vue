<template>
    <div class="relative w-full flex flex-col">
        <div @click="showSortingDropdown = !showSortingDropdown"
            :class="{'border-green-400 hover:border-green-400 dark:border-green-400 dark:hover:border-green-400' : showSortingDropdown}"
            class="w-full px-3 py-2 flex items-center gap-4 justify-between bg-white border-gray-300 shadow dark:bg-gray-900 dark:border-gray-700
            border rounded-xl hover:border-green-400 cursor-pointer select-none whitespace-nowrap">
                <div class="flex items-center gap-2">
                    <svg width="32" height="32" viewBox="0 0 32 32" class="stroke-gray-400 fill-none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.36585 4.40405L9.33391 23.4186M6.2439 23.8804L8.18242 26.5575C8.78233 27.3859 10.0166 27.3859 10.6166 26.5575L12.5551 23.8804" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M22.6342 27.0674L22.6022 8.05289M19.5122 7.59101L21.4507 4.914C22.0506 4.08555 23.285 4.08555 23.8849 4.914L25.8234 7.59101" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <span v-if="!selectedSortingType" class="text-sm text-gray-800 font-semibold select-none dark:text-white">Выберите</span>
                    <span v-else class="text-sm text-gray-800 dark:text-white font-semibold select-none">{{ returnSortingTypeString() }}</span>
                </div>
                <svg class="fill-none w-6 h-6 stroke-gray-800 dark:stroke-white" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.09961 9.6687L12.0996 15.6687L18.0996 9.6687" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
        </div>
        <div v-show="showSortingDropdown" class="left-[101%] z-[50] absolute shadow-lg flex flex-col gap-4 p-5 bg-white border border-gray-300 dark:bg-gray-900 dark:border-gray-700 rounded-lg select-none">
            <div class="flex flex-col gap-1 max-h-[300px] overflow-y-scroll no-scrollbar whitespace-nowrap">
                <div
                    @click="selectSortingType(sortType)"
                    v-for="(sortType, index) in sortingTypes" :key="index"
                    :class="{ 'border-green-400 hover:border-green-400 dark:border-green-400 dark:hover:border-green-400' : isSelected(sortType)}"
                    class="w-full px-4 py-2 flex items-center gap-4 bg-white rounded-lg shadow border border-gray-200
                    cursor-pointer hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-opacity-60">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-800 dark:text-white font-bold">{{ sortType.name }}</span>
                        <span class="text-sm text-gray-400 font-normal">{{ sortType.detail }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { SORTING_TYPES } from './constraints.js'
import { onMounted, ref } from 'vue';

const showSortingDropdown = ref(false);
const sortingTypes = ref(SORTING_TYPES);
const selectedSortingType = ref(sortingTypes.value[0]);

function returnSortingTypeString() {
    return selectedSortingType.value.name + ' - ' + selectedSortingType.value.detail;
}

function isSelected(sortingType) {
    return selectedSortingType.value === sortingType;
}

function selectSortingType(sortingType) {
    selectedSortingType.value = sortingType;
    emit('change', sortingType);
}

onMounted(() => {
    emit('change', selectedSortingType.value);
})

const emit = defineEmits(['change']);
</script>
