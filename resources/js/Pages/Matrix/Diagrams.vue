<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Link, Head } from '@inertiajs/vue3';
import HourArchTable from './Partials/HourArchTable.vue';
import NoDataIcon from '@/Components/Icons/NoDataIcon.vue';

import DatePicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';
import 'vue-datepicker-next/locale/ru.es';
import CalendarIcon from '@/Components/Icons/CalendarIcon.vue';
import ClearIcon from '@/Components/Icons/ClearIcon.vue';
import Chart from './Partials/Chart.vue';
import Dinamogram from '@/Components/Icons/Dinamogram.vue';


const props = defineProps({
    categories: {
        type: Object,
        required: true,
    },
    item: {
        type: Object,
        required: true,
    }
});

const hourArchData = ref([]);
const paginatedData = ref([]);
const dateFilters = ref();

const fetchHourArchData = (publicId) => {
  return axios.get(`/api/well/${props.item.public_id}/diagrams/${publicId}`)
    .then((response) => {
      return response.data;
    })
    .catch((error) => {
      console.error('Error fetching Dnm data', error);
    });
};


onMounted(() => {
    selectParam(props.categories[1].public_id, "Число качаний");
    paginateData();
});

const selectParam = (publicId, paramName) => {
    const existingParamIndex = hourArchData.value.findIndex((item) => item.public_id === publicId);

    if (existingParamIndex !== -1) {
        // If the dinamogram already exists, remove it
        hourArchData.value.splice(existingParamIndex, 1);

        // Reassign colors based on their order for the first three dinamograms
        reassignColors();
    } else {
        if (hourArchData.value.length >= 3) {
            // If there are already 3 dinamograms, remove the oldest one
            hourArchData.value.shift();
        }

        fetchHourArchData(publicId)
            .then((data) => {
                const selectedColor = 'green'; // Always set new dinamograms to green

                const diagram = {
                    public_id: publicId,
                    color: selectedColor,
                    data: data,
                    paramName: paramName,
                    setpoint: true
                };

                hourArchData.value.push(diagram);

                // Reassign colors based on their order for the first three dinamograms
                reassignColors();
            });
    }
};

// Helper function to reassign colors based on order
const reassignColors = () => {
    for (let i = 0; i < hourArchData.value.length; i++) {
        if (i === 0) {
            hourArchData.value[i].color = 'green';
        } else if (i === 1) {
            hourArchData.value[i].color = 'orange';
        } else {
            hourArchData.value[i].color = 'red';
        }
    }
};


const toggleSetpoint = (publicId) => {
    const param = hourArchData.value.find((item) => item.public_id === publicId);

    if (param) {
        param.setpoint = !param.setpoint;
    }
};


// Pagination

const currentPage = ref(1);
const perPage = ref(4);

const totalPages = computed(() => {

  if (paginatedData.value.length > 0) {
    return Math.ceil(props.categories.length / perPage.value);
  }
});

const paginateData = () => {
    const data = props.categories;
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    paginatedData.value = data.slice(start, end);
};

const setCurrentPage = (page) => {
  currentPage.value = page;
  paginateData();
};

const clearDate = () => {
  dateFilters.value = [];
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
    paginateData();
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
    paginateData();
  }
};

const filteredData = computed(() => {
  let data = hourArchData.value;

  if (!dateFilters.value || dateFilters.value.length !== 2) {
    // Set default date filter if not provided
    dateFilters.value = getDefaultDateFilters();
  }

  const [startDate, endDate] = dateFilters.value;

  // Create a new array using map to ensure reactivity
  data = data.map(item => {
    const filteredData = item.data.filter(dataItem => {
      const itemDate = new Date(dataItem.X);

      // Convert dates to local date strings
      const itemDateString = itemDate.toLocaleDateString();
      const startDateString = startDate.toLocaleDateString();
      const endDateString = endDate.toLocaleDateString();

      // Check if the itemDate is on or between startDate and endDate
      return (
        (itemDate >= startDate && itemDate <= endDate) ||
        (itemDateString === startDateString) ||
        (itemDateString === endDateString)
      );
    });

    // Create a new object to ensure reactivity
    return { ...item, data: filteredData };
  });

  return data;
});


function getDefaultDateFilters() {
  const endDate = new Date(); // Current date
  const startDate = new Date();
  startDate.setDate(endDate.getDate() - 7); // Subtract 7 days

  // Adjust the time to 00:00:00 for both start and end dates
  startDate.setHours(0, 0, 0, 0);
  endDate.setHours(23, 59, 59, 999);

  return [startDate, endDate];
}


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

watch(() => hourArchData.value, () => {
  paginateData();
}, {deep: true});

</script>

<template>
    <Head title="Диаграммы" />

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
            <Link :href="route('matrix.diagrams', item.public_id)">
                <BreadCrumb
                :name="'Диаграммы'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">

            <div class="w-full flex flex-col p-4 gap-4">


                <Chart v-if="filteredData.length > 0" :data="filteredData" />
                <div v-else class="flex flex-col gap-10 w-full h-[500px] items-center justify-center border border-gray-200 dark:border-gray-700  rounded-xl">
                    <Dinamogram />
                    <span class="text-gray-300 font-regular max-w-[400px] text-center">Выберите параметры для отображения в таблице ниже</span>
                </div>

                <div class="flex flex-col w-full gap-3">
                    <div class="w-full flex items-center gap-3">
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
                    <div class="w-full flex items-center gap-3">

                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl w-full">
                            <table v-if="paginatedData.length > 0" class="w-full">
                                <thead>
                                    <tr class="border-b bg-gray-50 border-gray-200 dark:bg-gray-900 dark:bg-opacity-40 dark:border-gray-700 ">
                                        <th scope="col" class="px-6 py-4 text-left w-[50px]">
                                            <span class="text font-semibold text-gray-800"></span>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700 ">
                                            <span class="text font-semibold text-gray-800 dark:text-gray-300">Категория</span>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700 ">
                                            <span class="text font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row, index) in paginatedData" :key="index" class="border-b border-gray-200 dark:border-gray-700 ">
                                        <th scope="row" class="font-normal text-gray-500 px-6 py-4 text-left border-b border-gray-200 dark:border-gray-700 ">
                                            <input
                                            @change="() => selectParam(row.public_id, row.CatName)"
                                            :value="row.public_id"
                                            :checked="hourArchData.some(src => src.public_id === row.public_id)"
                                            :style="{ color: hourArchData.find(src => src.public_id === row.public_id)?.color }"
                                            class="bg-gray-100 text-gray-100 dark:text-gray-800 dark:bg-gray-800 dark:border-gray-700 focus:ring-gray-100 dark:focus:ring-gray-800  border-gray-300 rounded cursor-pointer"
                                            type="checkbox"
                                        />
                                        </th>
                                        <td class="font-normal border-l border-gray-200 dark:border-gray-700  text-gray-500 px-6 py-4 text-left">{{ row.CatName }}</td>
                                        <td v-if="hourArchData.some(src => src.public_id === row.public_id)" class="font-normal border-l border-gray-200 dark:border-gray-700  text-gray-500 px-6 py-4 text-left">
                                            <!-- Toggle -->
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input
                                                    :checked="hourArchData.find(src => src.public_id === row.public_id)?.setpoint"
                                                    @change="() => toggleSetpoint(row.public_id)"
                                                    type="checkbox"
                                                    value=""
                                                    class="sr-only peer"
                                                />
                                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                                            </label>
                                        </td>
                                        <td v-else class="font-normal border-l border-gray-200 dark:border-gray-700  text-gray-500 px-6 py-4 text-left">
                                            <span class="text-gray-400 dark:text-gray-600">Не выбрано</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div v-else>Ничего нет </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </AuthorizedLayout>
</template>
