<script setup>
import { ref, computed, watch } from 'vue';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import TrafficLightLayout from '@/Layouts/TrafficLightLayout.vue';
import { Link, Head } from '@inertiajs/vue3';
import HourArchDetailTable from './Partials/HourArchDetailTable.vue';

const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
    well_item: {
        type: Object,
        required: true,
    },
    head_hour_item: {
        type: Object,
        required: true,
    },
});

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
    let data = props.data;

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

</script>

<template>
    <Head title="Часовые архивы" />

    <TrafficLightLayout>
        <template #nav>
            <Link :href="route('operations')">
                <BreadCrumb
                :name="'Наработки'"
                ></BreadCrumb>
            </Link>
            <Link :href="route('operations.detail', well_item.public_id)">
                <BreadCrumb
                :name="well_item.Name"
                ></BreadCrumb>
            </Link>
            <Link :href="route('operations.hourarch', well_item.public_id)">
                <BreadCrumb
                :name="'Часовые архивы'"
                ></BreadCrumb>
            </Link>
            <Link :href="route('operations.hourarch.detail', { operation_uuid: well_item.public_id, head_hour_uuid: head_hour_item.public_id})">
                <BreadCrumb
                :name="head_hour_item.Date"
                ></BreadCrumb>
            </Link>

        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">

            <div class="flex items-center gap-3 p-4 w-full">
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
                <HourArchDetailTable :data="paginatedData"></HourArchDetailTable>
            </div>
        </div>
    </TrafficLightLayout>
</template>