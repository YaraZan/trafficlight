<script setup>
import {computed, onMounted, ref, watch} from "vue";
import OilWellAnimatedIcon from "@/Components/Icons/OilWellAnimatedIcon.vue";
import axios from "axios";
import NoDataIcon from "@/Components/Icons/NoDataIcon.vue";
import DatePicker from "vue-datepicker-next";
import 'vue-datepicker-next/index.css';
import 'vue-datepicker-next/locale/ru.es';
import ClearIcon from "@/Components/Icons/ClearIcon.vue";
import CalendarIcon from "@/Components/Icons/CalendarIcon.vue";
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { Input, Spinner } from 'flowbite-vue';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    }
});

const claims = ref([]);
const claimsLoading = ref(false);
const dateFilters = ref([]);
const wells = ref([]);
const showMoveWellWindow = ref(false);
const moveWellClaimTypes = ['Мои', 'История'];
const currentMoveWellClaimType = ref('История')

onMounted(()=> {
    wells.value = fetchAllClaims(props.item.public_id)
})

const fetchAllClaims = async (publicId) => {
    claimsLoading.value = true;

    return await axios.get(`/api/well-claim/all-by-well/${publicId}`)
        .then((response) => {
            claims.value = response.data;
        })
        .catch((error) => {
            console.error('Ошибка', error);
        })
        .finally(() => {
            claimsLoading.value = false;
        });
};

const currentPage = ref(1);
const perPage = ref(8);

const totalPages = computed(() => {
    if (paginatedData.value.length > 0) {
        return Math.ceil(filteredData.value.length / perPage.value);
    }

});

const filteredData = computed(() => {
    let data = claims.value;

    if (dateFilters.value && dateFilters.value.length === 2) {
        const [startDate, endDate] = dateFilters.value;

        data = data.filter(dataItem => {
            const itemDate = new Date(dataItem.dat);

            const itemDateString = itemDate.toLocaleDateString();
            const startDateString = startDate.toLocaleDateString();
            const endDateString = endDate.toLocaleDateString();

            return (
                (itemDate >= startDate && itemDate <= endDate) ||
                (itemDateString === startDateString) ||
                (itemDateString === endDateString)
            );
        });
    }

    return data;
})

const paginatedData = computed(() => {
    const data = filteredData.value;

    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;

    return data.slice(start, end);
});

const visiblePages = computed(() => {
    const totalVisiblePages = 5;
    const pages = [];
    let startPage;

    if (totalPages.value <= totalVisiblePages) {
        startPage = 1;
    } else if (currentPage.value <= 2) {
        startPage = 1;
    } else if (currentPage.value >= totalPages.value - 2) {
        startPage = totalPages.value - totalVisiblePages + 1;
    } else {
        startPage = currentPage.value - Math.floor(totalVisiblePages / 2);
    }

    for (let i = 0; i < totalVisiblePages && startPage <= totalPages.value; i++) {
        pages.push(startPage);
        startPage++;
    }

    return pages;
});

const setCurrentPage = (page) => {
    currentPage.value = page;
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const getStatusColor = (color) => {
    let statusColor = 'text-gray-400'
    switch (color) {
        case 'Выполнено':
            statusColor = 'text-green-500'
            break
        case 'Уточнение':
            statusColor = 'text-orange-400'
            break
        case 'Отклонено':
            statusColor = 'text-red-500'
            break
    }

    return statusColor
}

const clearCommentString = (comment) => {
    return comment.split(': ')[1];
}

const clearDate = () => {
    dateFilters.value = [];
};

</script>

<template>
    <div class="flex w-full flex-col gap-5">

        <div class="flex w-full items-center gap-4">

            <slot />

            <div class="flex items-center gap-4 ml-auto">

                <slot name="claims-switcher" />

                <date-picker class="flex relative h-9 w-56"
                            :editable="false"
                            placeholder="Дата"
                            input-class="w-full h-full dark:text-green-400 dark:bg-gray-700 bg-gray-50 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 w-56 ring-green-600"
                            popup-class="rounded-lg p-2 relative dark:bg-gray-900 dark:border-gray-600"
                            v-model:value="dateFilters"
                            range
                            separator="-"
                            :onClear="clearDate"
                >
                    <template #icon-calendar>
                        <CalendarIcon />
                    </template>

                    <template #icon-clear>
                        <ClearIcon />
                    </template>
                </date-picker>

                <ul
                    class="flex items-center -space-x-px h-9 text-sm ml-auto">
                    <li>
                        <button @click="prevPage" :disabled="currentPage === 1" href="#"
                                class="flex items-center justify-center px-3 h-9 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Пред.</span>
                            <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 1 1 5l4 4"/>
                            </svg>
                        </button>
                    </li>
                    <li v-for="page in visiblePages" :key="page">
                        <button
                            @click="setCurrentPage(page)"
                            :class="{ 'font-bold text-green-600': currentPage === page }"
                            class="flex items-center justify-center px-3 h-9 leading-tight text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        >
                            {{ page }}
                        </button>
                    </li>
                    <li>
                        <button @click="nextPage"
                                :disabled="currentPage === totalPages" href="#"
                                class="flex items-center justify-center px-3 h-9 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">След.</span>
                            <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                        </button>
                    </li>
                </ul>
            </div>

        </div>

        <div v-if="!claimsLoading && paginatedData.length > 0" class="grid grid-cols-4 grid-rows-2 gap-[5px]">
            <div v-for="(claim, index) in paginatedData"
                :key="index"
                class="min-h-[150px] group bg-white border border-gray-100 dark:border-gray-700
                dark:bg-gray-900 rounded-lg flex flex-col justify-between p-5 relative shadow-md"
            >


                <div class="flex justify-between w-full">
                    <div class="flex flex-col gap-2">
                        <span class="text-gray-800 dark:text-white font-semibold text-[13px]">{{ claim.UserName }}</span>
                        <span class="text-gray-400 font-normal text-[13px]">{{ claim.dat }}</span>
                    </div>

                    <span :class="getStatusColor(claim.StatusName)" class="text-[13px] font-semibold">{{ claim.StatusName }}</span>
                </div>

                <div class="flex justify-between items-end w-full">
                    <span :class="getStatusColor(claim.StatusName)" class="font-semibold text-[13px]">{{ clearCommentString(claim.Comment) }}</span>
                </div>
            </div>
            <div v-if="paginatedData.length < perPage"
                 v-for="(_, index) in Array.from({ length: perPage - paginatedData.length })"
                 :key="index"
                 class="group bg-gray-50 dark:bg-gray-700 dark:bg-opacity-40 border border-dashed border-gray-300
                 dark:border-gray-600 rounded-lg flex flex-col
                 justify-between p-5 relative">
            </div>
        </div>

        <div v-else-if="!claimsLoading">
            <div class="w-full flex flex-col gap-4 items-center justify-center mt-20">
                <NoDataIcon/>
                <span class="text-[18px] text-gray-400 font-semibold">Данных нет</span>
            </div>
        </div>

        <div v-else>
            <div class="w-full flex flex-col gap-4 items-center justify-center mt-20">
                <OilWellAnimatedIcon class="w-[100px] h-[100px]"/>
            </div>
        </div>

    </div>
</template>
