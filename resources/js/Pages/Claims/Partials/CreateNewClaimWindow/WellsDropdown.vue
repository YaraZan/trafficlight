<template>
    <div class="relative w-full flex flex-col" :class="{ 'opactity-50' : isDisabled}">
    <!-- Dropdown -->
    <div @click="toggleShowWellsDropdown()"
        :class="{'border-green-400 hover:border-green-400 dark:border-green-400 dark:hover:border-green-400' : showWellsDropdown}"
        class="w-full px-3 py-2 flex items-center justify-between bg-white border-gray-300 shadow dark:bg-gray-900 dark:border-gray-700
        border rounded-xl hover:border-green-400 cursor-pointer select-none">
            <span v-if="!selectedWell" class="text-sm text-gray-800 font-semibold select-none dark:text-white">Выберите</span>
            <span v-else class="text-sm text-gray-800 dark:text-white font-semibold select-none">{{ selectedWell.name }}</span>
            <svg class="fill-none w-6 h-6 stroke-gray-800 dark:stroke-white" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.09961 9.6687L12.0996 15.6687L18.0996 9.6687" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
    </div>
    <!-- Content -->
    <div v-show="showWellsDropdown" class="top-[110%] z-[50] absolute shadow-lg w-full flex flex-col gap-4 p-8 bg-white border border-gray-300 dark:bg-gray-900 dark:border-gray-700 rounded-lg select-none">
        <input
        v-model="nameInput"
        :disabled="wellsLoading"
        type="text"
        placeholder="Название / НГДУ"
        class="px-3 py-2 text-sm text-gray-800 font-semibold bg-gray-100 shadow border border-gray-300
        rounded-lg placeholder:text-sm placeholder:text-gray-400 placeholder:font-semibold focus:border-gray-500 focus:ring-0 ring-0
        dark:bg-gray-800 dark:border-gray-600 dark:focus:border-gray-500 dark:text-white">

        <div class="flex flex-col gap-1 max-h-[300px] overflow-y-scroll no-scrollbar">
            <div
                @click="selectWell(well)"
                v-for="(well, index) in wells" :key="index"
                :class="{ 'border-green-400 hover:border-green-400 dark:border-green-400 dark:hover:border-green-400' : isSelected(well)}"
                class="w-full px-4 py-2 flex items-center gap-4 bg-white rounded-lg shadow border border-gray-200
                cursor-pointer hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-opacity-60">
                <div class="flex flex-col gap-2">
                    <span class="text-sm text-gray-800 dark:text-white font-bold">{{ well.name }}</span>
                    <span class="text-sm text-gray-400 font-normal">{{ well.ngduName }}</span>
                </div>
            </div>
            <!-- Fetch more -->
            <div @click="fetchMoreWells" class="w-full flex items-center justify-center gap-2 p-2 bg-white rounded-lg shadow border border-gray-200 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-opacity-60 cursor-pointer">
                <svg v-if="!wellsLoading" class="w-6 h-6 stroke-green-500 fill-none" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.2324 5.83691V19.8369" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M19.2324 12.8369L12.2324 19.8369L5.23242 12.8369" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <Spinner color="green" v-else />
                <span class="text-sm text-gray-800 dark:text-white font-semibold">Смотреть ещё</span>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';
import { Spinner } from 'flowbite-vue';

const props = defineProps({
    isDisabled: {
        type: Boolean,
        default: false,
    },
    defaultWell: {
        type: Object,
        default: null,
    },
})

const SKIP_INIT = 0;
const AMOUNT_INIT = 25;

const wells = ref([]);
const skip = ref(SKIP_INIT);
const amount = ref(AMOUNT_INIT);
const wellsLoading = ref(false);
const showWellsDropdown = ref(false);

// Select
const selectedWell = ref(null);

// Filter input
const nameInput = ref('');

// Fetch data
function fetchWells() {
    wellsLoading.value = true;

    axios.get(`/api/well/get`, {
        params: {
            skip: skip.value,
            amount: amount.value,
            name: nameInput.value.trim()
        }
    })
    .then(res => {
        const data = res.data;
        data.forEach(item => {
            wells.value.push(item);
        })
        wellsLoading.value = false;
    })
    .catch(err => {
        // handle
        wellsLoading.value = false;
    })
}

function fetchMoreWells() {
    skip.value += amount.value;
    fetchWells();
}

// Helper functions
function toggleShowWellsDropdown() {
    if (!props.isDisabled) {
        showWellsDropdown.value = !showWellsDropdown.value;
    }
}

function selectWell(well) {
    showWellsDropdown.value = false;
    selectedWell.value = well;
    emit('select', well);
}

function isSelected(well) {
    return selectedWell.value?.id === well.id;
}

onMounted(() => {
    fetchWells();
});

watch(nameInput, () => {
    setTimeout(() => {
        wells.value = [];
        skip.value = SKIP_INIT;
        fetchWells();
    }, 2500)
}, {deep: true});

const emit = defineEmits(['select']);
</script>
