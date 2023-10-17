<script setup>
import { Link } from '@inertiajs/vue3';
import { Button } from 'flowbite-vue';
import TrafficLightLayout from '@/Layouts/TrafficLightLayout.vue';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

import InputSearch from '@/Components/InputSearch.vue';
import MatrixTable from '@/Components/MatrixTable.vue';
import DateRadio from '@/Components/DateRadio.vue';
import NgduDropdown from '@/Components/NgduDropdown.vue';
import ActionsButton from '@/Components/ActionsButton.vue';

const props = defineProps({
    data: {
        type: Array
    },
});

const params = ['Скважина', 'Состояние', 'Дата', 'Штраф', 'Опрос', 'Связь',
 'Число качаний, об/мин', 'Нагрузка максимальная, кг',
 'Нагрузка минимальная, кг', 'Температура масла в ГБ, °С', 'Давление в ГН , МПа',
 'Давление в ГЦ , МПа', 'Давление в ПГА, МПа', 'Ток, А', 'Напряжение, В'];

const searchFilter = ref('');
const radioFilter = ref('');
const ngduFilters = ref([]);

const currentPage = ref(1);
const perPage = ref(10);

const perPageOptions = [10, 20, 30];

const totalPages = computed(() => Math.ceil(filteredData.value.length / perPage.value));

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return filteredData.value.slice(start, end);
});

const updateData = () => {
  currentPage.value = 1;
};

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

watch(() => props.data, () => {
  currentPage.value = 1;
});

const filteredData = computed(() => {
    let data = props.data.matrix_data;

    switch (radioFilter.value) {
        case 'today':
            data = data.filter(item => {
                const itemDate = new Date(item.Date);
                return (
                    itemDate.getDate() === new Date().getDate() &&
                    itemDate.getMonth() === new Date().getMonth() &&
                    itemDate.getFullYear() === new Date().getFullYear()
                );
            });

        case 'earlier':
            data = data.filter(item => {
                const itemDate = new Date(item.Date);
                return itemDate < new Date();
            });
    }



    if (ngduFilters.value.length) {
        data = data.filter(item => ngduFilters.value.includes(item.Ngdu_Id.toString()));   
    }

    if (searchFilter.value !== '') {
        data = data.filter(item => item.WellName.toLowerCase().includes(searchFilter.value.toLowerCase()));
    }

    return data;
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

const handleSearch = (search) => {
    searchFilter.value = search;
};

const handleFilter = (filter) => {
    radioFilter.value = filter;
};

const handleCheckboxFilter = (filter) => {
    if (ngduFilters.value.includes(filter)) {
        return ngduFilters.value.splice(ngduFilters.value.indexOf(filter), 1);
    }
    ngduFilters.value.push(filter);
};
</script>

<template>
    <Head title="Матрица" />

    <TrafficLightLayout>
        <template #nav>
            <Link :href="route('matrix')">
                <BreadCrumb
                :name="'Матрица'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">
            <div class="flex items-center p-4 w-full justify-between">
                <InputSearch @search="handleSearch"/>
                <div class="flex items-center gap-3 ml-auto">
                    <div class="flex items-center gap-3 ml-auto px-[20px]">
                        <DateRadio @filter="handleFilter"/>
                    </div>
                    <NgduDropdown @filter="handleCheckboxFilter" :data="data.ngdu_data"/>
                    <ActionsButton :data="data.matrix_data"/>
                </div>
            </div>
            <div class="flex items-center gap-3 p-4 pt-0 w-full">
                <select v-model="perPage" @change="updateData" class="block p-2 text-sm font-semibold text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-600 focus:border-green-600 cursor-pointer">
                    <option v-for="option in perPageOptions" :key="option" :value="option">
                        {{ `${option} записей` }}
                    </option>
                </select>
                <ul class="flex items-center -space-x-px h-9 text-sm">
                        <li>
                            <button @click="prevPage" :disabled="currentPage === 1" href="#" class="flex items-center justify-center px-3 h-9 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
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
                            <button @click="nextPage" :disabled="currentPage === totalPages" href="#" class="flex items-center justify-center px-3 h-9 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                            </button>
                        </li>
                </ul>
            </div>
            <div class="w-full h-full overflow-x-auto">
                <MatrixTable :data="paginatedData" :params="params"/>
            </div>
        </div>
    </TrafficLightLayout>
</template>
