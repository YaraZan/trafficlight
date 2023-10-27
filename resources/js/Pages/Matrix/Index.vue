<script setup>
import { Link } from '@inertiajs/vue3';
import { Button } from 'flowbite-vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';

import { Input } from 'flowbite-vue';
import MatrixTable from './Partials/MatrixTable.vue';
import ActionsButton from '@/Components/ActionsButton.vue';
import GridIcon from '@/Components/Icons/GridIcon.vue';
import TableIcon from '@/Components/Icons/TableIcon.vue';
import OperationsGrid from './Partials/OperationsGrid.vue';
import axios from 'axios';


const props = defineProps({
    data: {
        type: Object
    }
});



const params = ['Связь','НГДУ', 'Цех', 'Скважина', 'Состояние', 'Дата', 'Штраф', 'Опрос',
 'Число качаний, об/мин', 'Нагрузка максимальная, кг',
 'Нагрузка минимальная, кг', 'Температура масла в ГБ, °С', 'Давление в ГН , МПа',
 'Давление в ГЦ , МПа', 'Давление в ПГА, МПа', 'Ток, А', 'Напряжение, В'];

const searchFilter = ref('');
const radioFilter = ref('available');
const ngduFilters = ref([]);

const currentPage = ref(1);
const perPage = ref(20);

const showViewTypeDropdown = ref(false);
const showNgduDropdown = ref(false);
const viewType = ref('grid');

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

const filteredData = computed(() => {
    let data = props.data.matrix_data;

    switch (radioFilter.value) {
        case 'available':
            data = data.filter(item => {
                return item.Connect;
            });
            break;

        case 'lost':
            data = data.filter(item => {
                return !item.Connect;
            });
            break;
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

const handleNgduCheckboxFilter = (e) => {
    const val = e.target.value;

    if (ngduFilters.value.includes(val)) {
        return ngduFilters.value.splice(ngduFilters.value.indexOf(val), 1);
    }
    ngduFilters.value.push(val);
};

const changeView = (value) => {
    viewType.value = value;
}

watch(() => [searchFilter.value, perPage.value, ngduFilters.value, radioFilter.value], () => {
  currentPage.value = 1;
}, { deep: true });

</script>

<template>
    <Head title="Матрица" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('matrix')">
                <BreadCrumb
                :name="'Матрица'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">
            <div class="flex items-center p-4 w-full justify-between">

                <div class="flex items-center gap-3">
                    <Input v-model="searchFilter" size="sm" class="focus:ring-green-500 focus:border-green-500 w-56 ring-green-600 " type="text"  placeholder="Поиск" required="">
                    </Input>
                    <div class="flex items-center gap-3 ml-auto px-[20px]">
                        <input v-model="radioFilter" id="today-radio" type="radio" name="filter" value="available" checked class="text-green-500 focus:ring-green-500 bg-gray-100 border-gray-300"/>
                        <label for="today-radio" class="font-semibold text-sm">Доступные</label>

                        <input v-model="radioFilter" id="earlier-radio" type="radio" name="filter" value="lost" class="text-green-500 focus:ring-green-500 bg-gray-100 border-gray-300"/>
                        <label for="earlier-radio" class="font-semibold text-sm">Недоступные</label>

                        <input v-model="radioFilter" id="all-radio" type="radio" name="filter" value="all" class="text-green-500 focus:ring-green-500 bg-gray-100 border-gray-300"/>
                        <label for="all-radio" class="font-semibold text-sm">Все</label>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 ">
                    <div class="relative flex items-center flex-col">
                        <Button :class="showViewTypeDropdown ? 'border-green-600 text-green-600' : ''" size="md" color="light" @click="showViewTypeDropdown = !showViewTypeDropdown;">
                            <div v-if="viewType === 'grid'" class="flex items-center gap-3">
                                <GridIcon />
                                <span class="text-gray-800 font-semibold">Карта</span>
                            </div>
                            <div v-else class="flex items-center gap-3">
                                <TableIcon />
                                <span class="text-gray-800 font-semibold">Таблица</span>
                            </div>
                        </Button>

                        <div :class="showViewTypeDropdown ? 'visible' : 'invisible'" class="absolute top-12 p-5 right-0 z-10 bg-white rounded-lg shadow min-w-[300px]">
                            <h6 class="font-medium text-sm text-gray-400">Отображение данных</h6>
                            <ul class="mt-[10px] gap-2 w-full flex flex-col">
                                <li :class="viewType === 'grid' ? 'bg-gray-100' : ''" class="flex items-center gap-3 p-3 hover:bg-gray-100 cursor-pointer rounded-lg" v-on:click="changeView('grid')">
                                    <GridIcon />
                                    <span class="text-gray-800 font-semibold">Карта объектов</span>
                                </li>
                                <li :class="viewType === 'table' ? 'bg-gray-100' : ''" class="flex items-center gap-3 p-3 hover:bg-gray-100 cursor-pointer rounded-lg" v-on:click="changeView('table')">
                                    <TableIcon />
                                    <span class="text-gray-800 font-semibold">Таблица объектов</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="relative flex items-center flex-col">
                        <Button v-if="data.ngdu_data" :class="showNgduDropdown ? 'border-green-600 text-green-600' : ''" size="md" color="light" @click="showNgduDropdown = !showNgduDropdown;">
                            <span class="font-semibold">НГДУ</span>
                        </Button>

                        <div v-show="showNgduDropdown" class="absolute top-12 p-5 right-0 z-10 bg-white rounded-lg shadow min-w-[300px]">
                            <h6 class="font-medium text-sm text-gray-400">Выберите НГДУ</h6>
                            <ul class="mt-[10px] w-full flex flex-col">
                                <li v-for="(ngdu, index) in data.ngdu_data" :key="index" class="flex items-center gap-2 p-2 hover:bg-gray-100 rounded-lg">
                                    <input @change="handleNgduCheckboxFilter" class="text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 cursor-pointer" :id="`filter_option_${index}`" type="checkbox" :value="ngdu.Id">
                                    <label class="cursor-pointer" :for="`filter_option_${index}`">{{ ngdu.NgduName }}</label>
                                </li>
                            </ul>
                        </div>
                    </div>
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
                                <span class="sr-only">Пред.</span>
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
                                <span class="sr-only">След.</span>
                                <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                            </button>
                        </li>
                </ul>
            </div>
            <div v-if="viewType === 'grid'" class="w-full h-full overflow-x-auto p-4">
                <OperationsGrid :data="paginatedData" :params="params"/>
            </div>
            <div v-else class="w-full h-full overflow-x-auto">
                <MatrixTable :data="paginatedData" :params="params"/>
            </div>
        </div>
    </AuthorizedLayout>
</template>
