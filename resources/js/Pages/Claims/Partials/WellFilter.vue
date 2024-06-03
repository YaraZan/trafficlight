<template>
    <div class="w-full px-4 py-8 flex flex-col gap-4 border-b border-gray-200">
        <span class="text-sm text-gray-800 font-semibold">Скважины</span>

        <div class="relative flex flex-col gap-4 h-full">
            <!-- Dropdown -->
            <div @click="showWellsDropdown = !showWellsDropdown"
                class="px-3 py-2 flex items-center justify-between bg-white border-gray-300 shadow dark:bg-gray-900 dark:border-gray-700
                border rounded-xl hover:border-green-400">
                    <span class="text-sm text-gray-800 font-semibold select-none">Выберите</span>
                    <svg class="fill-none w-6 h-6 stroke-gray-800" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.09961 9.6687L12.0996 15.6687L18.0996 9.6687" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
            </div>
            <!-- Content -->
            <div v-show="showWellsDropdown" class="top-[105%] absolute w-full flex flex-col gap-4 p-8 bg-white border border-gray-300 rounded-lg select-none">
                <input
                v-model="wellNameInput"
                :disabled="wellsLoading"
                type="text"
                placeholder="Название / НГДУ"
                class="px-3 py-2 text-sm text-gray-800 font-semibold bg-gray-100 shadow border border-gray-300
                rounded-lg placeholder:text-sm placeholder:text-gray-400 placeholder:font-semibold focus:border-gray-500 focus:ring-0 ring-0">

                <div class="flex flex-col gap-1 max-h-[400px] overflow-y-scroll no-scrollbar">
                    <div @click="selectWell(well)" v-for="(well, index) in wells" :key="index"
                        class="w-full px-4 py-2 flex items-center gap-4 bg-white rounded-lg shadow border border-gray-200 cursor-pointer hover:bg-gray-50">
                        <div class="w-5 h-5 rounded-md border border-gray-300 bg-gray-100">
                            <div v-if="isWellSelected(well)" class="w-full h-full flex items-center justify-center bg-green-400">
                                <svg class="w-4 h-4 stroke-white fill-none" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.5684 6.63379L9.56836 17.6338L4.56836 12.6338" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <span class="text-sm text-gray-800 font-bold">{{ well.WellName }}</span>
                            <span class="text-sm text-green-400 font-normal">{{ well.NgduName }}</span>
                        </div>
                    </div>
                    <!-- Fetch more -->
                    <div @click="fetchWells(paginationAmount)" class="w-full flex items-center justify-center gap-2 p-2 bg-white shadow border border-gray-200 hover:bg-gray-50 cursor-pointer">
                        <svg v-if="!wellsLoading" class="w-6 h-6 stroke-green-500 fill-none" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.2324 5.83691V19.8369" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M19.2324 12.8369L12.2324 19.8369L5.23242 12.8369" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <Spinner color="green" v-else />
                        <span class="text-sm text-gray-800 font-semibold">Смотреть ещё</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { computed, onMounted, ref, watch } from 'vue';
import { Spinner } from 'flowbite-vue';
import { debounce } from 'lodash';

const paginationAmount = ref(25);
const PAGINATION_OFFSET = 25;

const wells = ref([]);
const wellsLoading = ref(true);
const showWellsDropdown = ref(false);

const wellNameInput = ref('');

const selectedWells = ref([]);

function fetchWells(amount) {
    axios.get(`/api/well/get/${amount}`)
    .then(res => {
        wells.value = res.data.data;
        paginationAmount.value += PAGINATION_OFFSET;
    })
    .catch(err => {
        console.log(err);
    })
    .finally(() => {
        wellsLoading.value = false;
    })
}

function fetchWellsByName() {
    axios.get(`/api/well/get-by-name/${wellNameInput.value}`)
    .then(res => {
        wells.value = res.data;
    })
    .catch(err => {
        console.log(err);
    })
    .finally(() => {
        wellsLoading.value = false;
    })
}

function selectWell(well) {
    selectedWells.value.push(well);
}

const isWellSelected = (well) => computed(() => {
    return selectedWells.value.some(srcWell => srcWell.WellId === well.WellId);
});

onMounted(() => {
    fetchWells(paginationAmount.value);
});

watch(wellNameInput, () => {
    if (wellNameInput.value.trim() === '') {
        paginationAmount.value = PAGINATION_OFFSET;
        fetchWells(paginationAmount.value);
    } else {
        debounce(fetchWellsByName(), 1500);
    }
});
</script>
