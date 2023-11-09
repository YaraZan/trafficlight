<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head } from '@inertiajs/vue3';
import AlarmsTable from '@/Pages/Alarms/Partials/AlarmsTable.vue';
import NoDataIcon from '@/Components/Icons/NoDataIcon.vue';
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';

import DatePicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';
import 'vue-datepicker-next/locale/ru';
import CalendarIcon from '@/Components/Icons/CalendarIcon.vue';
import ClearIcon from '@/Components/Icons/ClearIcon.vue';

const props = defineProps({
    data: {
        type: Array
    },
    item: {
        type: Object,
        required: true,
    }
});

const currentPage = ref(1);
const perPage = ref(20);
const dateFilters = ref();

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

const clearDate = () => {
  dateFilters.value = [];
};

const filteredData = computed(() => {
    let data = props.data;

    if (dateFilters.value && dateFilters.value.length === 2) {
    const [startDate, endDate] = dateFilters.value;

    data = data.filter(item => {
      const itemDate = new Date(item.Date); // Replace 'date' with the actual property name in your data

      return itemDate >= startDate && itemDate <= endDate;
    });
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

watch(() => [dateFilters.value], () => {
  currentPage.value = 1;
}, { deep: true });

</script>

<template>
    <Head title="Аварии" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('matrix')">
                <BreadCrumb
                :name="'Матрица'"
                ></BreadCrumb>
            </Link>
            <Link :href="route('matrix.detail', item.public_id)">
                <BreadCrumb
                :name="item.Name"
                ></BreadCrumb>
            </Link>
            <Link :href="route('matrix.alarms', item.public_id)">
                <BreadCrumb
                :name="'Аварии'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">

            <div class="flex items-center gap-3 p-4 w-full">
                <select v-model="perPage" @change="updateData" class="block p-2 text-sm font-semibold dark:hover:bg-opacity-80 text-gray-900 border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 border-gray-300 rounded-lg bg-gray-50 focus:ring-green-600 focus:border-green-600 cursor-pointer">
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
                <date-picker class="flex relative h-9 w-56"
                :editable="false"
                placeholder="Дата"
                input-class="w-full h-full dark:text-green-400 dark:bg-gray-700 bg-gray-50 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 w-56 ring-green-600"
                popup-class="rounded-lg p-4 relative dark:bg-gray-900 dark:border-gray-600"
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
            </div>

            <div class="w-full h-full overflow-x-auto">
                <table v-if="paginatedData.length > 0" class="w-full" striped>
                    <thead>
                        <tr class="border-y border-gray-200 bg-gray-50 dark:bg-gray-900 dark:bg-opacity-40 dark:border-gray-700">
                            <th scope="col" class="px-6 py-4 text-left">
                                <span class="text font-semibold text-gray-800 dark:text-gray-300">Дата</span>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700">
                                <span class="text font-semibold text-gray-800 dark:text-gray-300">Регистр</span>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700">
                                <span class="text font-semibold text-gray-800 dark:text-gray-300">Значение</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in paginatedData" :key="index" class="border-b border-gray-200 dark:border-gray-700">
                            <th scope="row" class="font-normal text-gray-800 dark:text-gray-400 px-6 py-4 text-left">{{ row.Date }}</th>
                            <td class="font-normal text-gray-800 dark:text-gray-400 px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700">{{ row.RegDescript }}</td>
                            <td class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700">
                                <span v-if="row.Value" class="py-1 px-2 bg-green-100 text-green-600 dark:bg-green-500 dark:text-white rounded-3xl">Да</span>
                                <span v-else class="py-1 px-2 bg-red-100 text-red-600 dark:bg-red-500 dark:text-white rounded-3xl">Нет</span>
                            </td>
                        </tr>
                    </tbody>
                </table>   
                <div v-else class="flex flex-col gap-4 items-center justify-center w-full h-screen p-20 border border-gray-200 dark:border-gray-700 rounded-xl">
                    <NoDataIcon />
                    <span class="text-gray-500 text-lg font-semibold">Данных нет..</span>
                </div>
            </div>

        </div>
        
    </AuthorizedLayout>
</template>
