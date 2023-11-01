<script setup>
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import HourArchIcon from '@/Components/Icons/HourArchIcon.vue';
import AskStatsIcon from '@/Components/Icons/AskStatsIcon.vue';
import AlarmIcon from '@/Components/Icons/AlarmIcon.vue';
import DiagramsIcon from '@/Components/Icons/DiagramsIcon.vue';
import { Link, Head } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import DnmhTable from './Partials/DnmhTable.vue';
import SkeletonDnmhTable from './Partials/SkeletonDnmhTable.vue';
import DnmChart from './Partials/DnmChart.vue';
import NoDataIcon from '@/Components/Icons/NoDataIcon.vue';
import { watch } from 'vue';
import Dinamogram from '@/Components/Icons/Dinamogram.vue';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    }
});

const dnmhData = ref([]);
const dnmData = ref([]);
const paginatedData = ref([]); 

const fetchDnmhData = () => {
  axios.get(`/api/dnmh/${props.item.public_id}`)
    .then((response) => {
      dnmhData.value = response.data;
      paginateData();
    })
    .catch((error) => {
      console.error('Error fetching Dnmh data', error);
    });
};

const fetchDnmData = (publicId) => {
  axios.get(`/api/dnm/${publicId}`)
    .then((response) => {
      dnmData.value = response.data;
    })
    .catch((error) => {
      console.error('Error fetching Dnm data', error);
    });
};

onMounted(() => {
  fetchDnmhData();
  paginateData();
});


const handleSelect = (e) => {
    fetchDnmData(e.target.value);
    selectedDnm.value = e.target.value;
};

// Pagination

const selectedDnm = ref(null);

const currentPage = ref(1);
const perPage = ref(4);

const totalPages = computed(() => { 

  if (paginatedData.value.length > 0) {
    return Math.ceil(dnmhData.value.length / perPage.value);
  }

  return;
});

const paginateData = () => {
  const start = (currentPage.value - 1) * perPage.value;
  const end = start + perPage.value;
  paginatedData.value = dnmhData.value.slice(start, end);
};

const setCurrentPage = (page) => {
  currentPage.value = page;
  paginateData();
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

watch(() => dnmhData.value, () => {
  paginateData();
}, {deep: true});
</script>

<template>
    <Head :title="item.Name" />

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
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">

            <!-- Flex [-] -->
            <div class="flex flex-col p-8 gap-5">

                <!-- Flex [ | ] -->
                <div class="flex w-full items-stretch gap-10">


                    <div class="flex flex-col gap-5 w-[40%]">

                        <div class="flex gap-5 items-center mt-2">
                            <div :class="item.Connect ? 'bg-green-100' : 'bg-gray-200'" class="w-5 h-5 rounded-full z-1 flex items-center justify-center cursor-pointer" data-tooltip-target="operation-connect-tooltip" data-tooltip-placement="bottom">
                                <div :class="item.Connect ? 'bg-green-300' : 'bg-gray-400'" class="w-1/2 h-1/2 rounded-full z-2"></div>
                            </div >
                            <span class="font-bold text-gray-800 text-lg">{{ item.Name }}</span>
                        </div>

                        <div class="flex flex-col border border-gray-200 rounded-xl mt-2">
                            <div class="flex gap-2 p-3 items-center border-b border-gray-200">
                                <span class="text-sm text-gray-500 w-1/3">Название</span>
                                <span class="text-lg font-semibold text-gray-800">{{ item.Name }}</span>
                            </div>
                            <div class="flex gap-2 p-3 items-center border-b border-gray-200">
                                <span class="text-sm text-gray-500 w-1/3">ПЛК</span>
                                <span class="text-lg font-semibold text-gray-800">{{ item.PlcName }}</span>
                            </div>
                            <div class="flex gap-2 p-3 items-center border-b border-gray-200">
                                <span class="text-sm text-gray-500 w-1/3">НГДУ</span>
                                <span class="text-lg font-semibold text-gray-800">{{ item.NgduName }}</span>
                            </div>
                            <div class="flex gap-2 p-3 items-center">
                                <span class="text-sm text-gray-500 w-1/3">Цех</span>
                                <span class="text-lg font-semibold text-gray-800">{{ item.ShopName }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-5">
                            <Link :href="route('matrix.hourarch', item.public_id)">
                                <div class="p-6 flex gap-5 bg-white rounded-lg shadow border border-gray-200 items-center hover:bg-gray-100 cursor-pointer h-10">
                                    <HourArchIcon />
                                    <span class="text-sm font-semibold text-gray-800">Часовые архивы</span>
                                </div>
                            </Link>
                            <Link :href="route('matrix.askstats', item.public_id)">
                                <div class="p-6 flex gap-5 bg-white rounded-lg shadow border border-gray-200 items-center hover:bg-gray-100 cursor-pointer h-10">
                                    <AskStatsIcon />
                                    <span class="text-sm font-semibold text-gray-800">Статистика опроса</span>
                                </div>
                            </Link>
                            <div class="p-6 flex gap-5 bg-white rounded-lg shadow border border-gray-200 items-center hover:bg-gray-100 cursor-pointer h-10">
                                <AlarmIcon />
                                <span class="text-sm font-semibold text-gray-800">Аварии</span>
                            </div>
                            <div class="p-6 flex gap-5 bg-white rounded-lg shadow border border-gray-200 items-center hover:bg-gray-100 cursor-pointer h-10">
                                <DiagramsIcon />
                                <span class="text-sm font-semibold text-gray-800">Диаграммы</span>
                            </div>
                        </div>

                    </div>

                    <DnmChart v-if="dnmData.length > 0" :data="dnmData"/>
                    <div v-else class="flex flex-col gap-10 w-[60%] min-h-full items-center justify-center border border-gray-200 rounded-xl">
                        <Dinamogram />
                        <span class="text-gray-300 font-regular max-w-[400px] text-center">Выберите динамограмму для отображения в таблице ниже</span>
                    </div>

                </div>

                <div class="w-full overflow-x-auto overflow-y-auto border border-gray-200 rounded-xl">
                      <table v-if="paginatedData.length" class="w-full border-b border-gray-200" striped>
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th scope="col" class="bg-gray-50 px-6 py-4 text-left">
                                    <span class="text font-semibold text-gray-800">Дата</span>
                                </th>
                                <th scope="col" class="bg-gray-50 px-6 py-4 text-left border-l border-gray-200">
                                    <span class="text font-semibold text-gray-800">Опрос</span>
                                </th>
                                <th scope="col" class="bg-gray-50 px-6 py-4 text-left border-l border-gray-200">
                                    <span class="text font-semibold text-gray-800">Наименование</span>
                                </th>
                                <th scope="col" class="bg-gray-50 px-6 py-4 text-center border-l border-gray-200 w-[100px]">
                                    <span class="text font-semibold text-gray-800">Действие</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in paginatedData" :class="selectedDnm == row.public_id ? 'border-y-2 border-green-300 bg-green-50' : 'border-b border-gray-200'" :key="index">
                                <th scope="row" class="font-bold text-gray-400 px-6 py-4 text-left">{{ row.Dat }}</th>
                                <td class="px-6 py-4 text-left border-l border-gray-200">{{ row.AskLong }}</td>
                                <td class="px-6 py-4 text-left border-l border-gray-200">{{ row.DnmAdress }}</td>
                                <td class="px-6 py-4 border-l border-gray-200">
                                    <span class="text-green-600 font-semibold" v-if="selectedDnm == row.public_id">Просматривается</span>
                                    <button v-else
                                        :value="row.public_id"
                                        @click="handleSelect"
                                        class="w-full flex bg-gray-50 border items-center justify-center border-gray-200 px-4 py-2 rounded-lg text-gray-800 text-sm font-semibold hover:bg-gray-100"
                                    >
                                        Загрузить
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table> 

                    <SkeletonDnmhTable v-else />
                </div>
                <div class="w-full" v-if="paginatedData.length > 0">
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

            </div>
        </div>
    </AuthorizedLayout>
</template>