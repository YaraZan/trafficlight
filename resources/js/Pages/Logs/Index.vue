<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import NoDataIcon from '@/Components/Icons/NoDataIcon.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { Input } from 'flowbite-vue';
import { ref, computed, watch } from 'vue';
import { onMounted } from 'vue';
import DatePicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';
import 'vue-datepicker-next/locale/ru.es';
import CalendarIcon from '@/Components/Icons/CalendarIcon.vue';
import ClearIcon from '@/Components/Icons/ClearIcon.vue';

const props = defineProps({
    logs: {
        type: Array,
        required: false
    }
});

const clearDate = () => {
  dateFilters.value = [];
};

const getActionColor = (action) => {
    let actionColor = "text-gray-500";

    switch (action) {
        case "Вход в систему":
            actionColor = "text-blue-500";
            break;

        case "Выход из системы":
            actionColor = "text-red-500";
            break;
    }

    if (action.includes('ИЗМЕНЕНИЕ: ')) {
        actionColor = 'text-orange-400'
    }

    return actionColor;
}

function formatTimestamp(timestamp) {
    const date = new Date(timestamp);

    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');

    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    const seconds = date.getSeconds().toString().padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

function getDefaultDateFilters() {
  const endDate = new Date(); // Current date
  const startDate = new Date();
  startDate.setDate(endDate.getDate() - 7); // Subtract 7 days

  // Adjust the time to 00:00:00 for both start and end dates
  startDate.setHours(0, 0, 0, 0);
  endDate.setHours(23, 59, 59, 999);

  return [startDate, endDate];
}


const currentPage = ref(1);
const perPage = ref(20);
const searchFilter = ref('');
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

const filteredData = computed(() => {
  let data = props.logs;

    if (!dateFilters.value || dateFilters.value.length !== 2) {
        // Set default date filter if not provided
        dateFilters.value = getDefaultDateFilters();
    }

    if (dateFilters.value && dateFilters.value.length == 2) {
        const [startDate, endDate] = dateFilters.value;

        // Create a new array using map to ensure reactivity
        data = data.filter(dataItem => {
            const itemDate = new Date(dataItem.created_at);

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

watch(() => [searchFilter.value], () => {
  currentPage.value = 1;
}, { deep: true });

</script>

<template>
    <Head title="Логи" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('logs')">
                <BreadCrumb
                :name="'Логи'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">

            <div class="flex w-full items-center p-4 gap-3">

                <select v-model="perPage" @change="updateData" class="block p-2 text-sm font-semibold dark:hover:bg-opacity-80 text-gray-800 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600 cursor-pointer">
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
                <Input v-model="searchFilter" size="sm" class="focus:ring-green-600 focus:border-green-500 w-56 ring-green-600 " type="text"  placeholder="Имя" required="">
                </Input>
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
                <table v-if="props.logs.length" class="w-full" striped>
                    <thead>
                        <tr class="border-y bg-gray-50 dark:bg-gray-900 dark:bg-opacity-40 border-gray-200 dark:border-gray-700">
                            <th scope="col" class="px-6 py-3 text-left">
                                <span class="text font-semibold text-gray-800 dark:text-gray-300">Пользователь</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
                                <span class="text font-semibold text-gray-800 dark:text-gray-300">Дата</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
                                <span class="text font-semibold text-gray-800 dark:text-gray-300">Действие</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
                                <span class="text font-semibold text-gray-800 dark:text-gray-300">IP-адрес</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
                                <span class="text font-semibold text-gray-800 dark:text-gray-300">Домен</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
                                <span class="text font-semibold text-gray-800 dark:text-gray-300">Агент</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="paginatedData.length > 0" v-for="log in paginatedData" :key="log.id" class="border-b border-gray-200 dark:border-gray-700">

                            <th scope="row" class="px-6 py-3 text-left w-[300px]">
                                <span class="font-semibold text-gray-800 dark:text-gray-400">{{ log.user.name }}</span>
                            </th>

                            <td class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700 w-[250px]">
                                <span class="font-normal text-gray-800 dark:text-gray-400">{{ formatTimestamp(log.created_at) }}</span>
                            </td>

                            <td class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700 w-[250px]">
                                <span
                                :class="getActionColor(log.action)"
                                class="font-semibold"
                                >{{ log.action }}</span>
                            </td>

                            <td class="px-6 py-3 text-left text-green-500 border-l border-gray-200 dark:border-gray-700">
                                {{ log.ip }}
                            </td>

                            <td class="px-6 py-3 text-left text-gray-800 dark:text-gray-400 border-l border-gray-200 dark:border-gray-700">
                                {{ log.domain }}
                            </td>

                            <td class="px-6 py-3 text-left text-gray-800 dark:text-gray-400 border-l border-gray-200 dark:border-gray-700">
                                {{ log.agent }}
                            </td>
                        </tr>
                        <div v-else class="flex flex-col gap-4 items-center justify-center w-full h-full p-20">
                            <NoDataIcon />
                            <span class="text-gray-500 text-lg font-semibold">Данных нет..</span>
                        </div>
                    </tbody>
                </table>
            </div>

        </div>

    </AuthorizedLayout>
</template>
