<script setup>
import {Link, usePage, useRemember} from '@inertiajs/vue3';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import ShopDropdown from '@/Components/ShopDropdown.vue';
import ActionsIcon from '@/Components/Icons/ActionsIcon.vue';

import { Input } from 'flowbite-vue';
import MatrixTable from './Partials/MatrixTable.vue';
import ActionsButton from '@/Components/ActionsButton.vue';
import GridIcon from '@/Components/Icons/GridIcon.vue';
import TableIcon from '@/Components/Icons/TableIcon.vue';
import NoDataIcon from '@/Components/Icons/NoDataIcon.vue';
import OperationsGrid from './Partials/OperationsGrid.vue';
import axios from 'axios';
import DropDownIcon from '@/Components/Icons/DropDownIcon.vue';

import * as XLSX from 'xlsx';

const props = defineProps({
    data: {
        type: Object
    }
});

onMounted(() => {
    if (props.data.ngdu_data) {
        selectAllNgduCheckboxes();
    }

    searchFilter.value = rememberFilters.value.searchFilter;
});

function exportTableToExcel(type) {
    const data = document.getElementById('exportMatrix');
    const excelFile = XLSX.utils.table_to_book(data, { sheet: "sheet1" });

    // Установим ширину колонок автоматически
    const wscols = [];
    for (let i = 0; i < excelFile.Sheets.sheet1["!ref"].split(":")[1].charCodeAt(0) - 'A'.charCodeAt(0) + 1; i++) {
        wscols.push({ wch: 25 }); // Установим ширину колонки в символах, например, 15
    }
    excelFile.Sheets.sheet1["!cols"] = wscols;

    const now = new Date();
    const nd = `${now.getFullYear()}-${now.getMonth()}-${now.getDate()}_${now.getHours()}.${now.getMinutes()}`;

    XLSX.write(excelFile, { bookType: type, bookSST: true, type: 'base64' });
    XLSX.writeFile(excelFile, `Матрица_${nd}` + '.' + type);
}


const searchFilter = ref('');
const radioFilter = ref('all');
const ngduFilters = ref([]);
const shopFilters = ref([]);
const selectAllNgdus = ref(true);
const currentPage = ref(1);
const perPage = ref(20);
const viewType = ref('table');
const perPageOptions = [10, 20, 30, 'all'];

const rememberFilters = useRemember({
    searchFilter
})

const totalPages = computed(() => {
    if (perPage.value == 'all') {
        return 1;
    }
    return Math.ceil(filteredData.value.length / perPage.value);
});

const paginatedData = computed(() => {
    if (perPage.value == 'all') {
        return filteredData.value;
    }

    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;

    if (!filteredData.value) {
        return null;
    }

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

    if (props.data.ngdu_data) {
        data = data.filter(item => ngduFilters.value.includes(item.Ngdu_Id));
        data = data.filter(item => shopFilters.value.includes(item.Shop_Id));
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

const selectAllNgduCheckboxes = () => {

    if (ngduFilters.value.length == props.data.ngdu_data.length) {
        ngduFilters.value = [];
        shopFilters.value = [];
        return;
    }

    ngduFilters.value = [];
    shopFilters.value = [];

    props.data.ngdu_data.forEach(ngdu => {
        if (!ngduFilters.value.includes(ngdu.Id)) {
            ngdu.shops.forEach(shop => {
                if (!shopFilters.value.includes(shop.Id)) {
                    shopFilters.value.push(shop.Id)
                }
            });
            ngduFilters.value.push(ngdu.Id);
        }
    });


    selectAllNgdus.value = true;
};

const handleNgduCheckboxFilter = (ngdu) => {
    const val = parseInt(ngdu.Id);

    if (ngduFilters.value.includes(val)) {

        ngdu.shops.forEach(shop => {
            shopFilters.value.splice(shopFilters.value.indexOf(shop.Id), 1);
        })

        return ngduFilters.value.splice(ngduFilters.value.indexOf(val), 1);
    }

    ngdu.shops.forEach(shop => {
        shopFilters.value.push(shop.Id);
    })

    ngduFilters.value.push(val);
};

const handleShopCheckboxFilter = (shop) => {
    const val = parseInt(shop.Id);
    const nId = parseInt(shop.Ngdu_Id);

    if (shopFilters.value.includes(val)) {
        return shopFilters.value.splice(shopFilters.value.indexOf(val), 1);
    }

    if (!ngduFilters.value.includes(shop.Ngdu_Id)) {
        ngduFilters.value.push(shop.Ngdu_Id);
    }
    shopFilters.value.push(val);
};

const changeView = (value) => {
    viewType.value = value;
}

watch(() => [searchFilter.value, perPage.value, ngduFilters.value, radioFilter.value], () => {

    if (props.data.ngdu_data && ngduFilters.value.length !== props.data.ngdu_data.length) {
        selectAllNgdus.value = false;
    } else {
        selectAllNgdus.value = true;
    }

    currentPage.value = 1;
}, { deep: true });

const page = usePage();
const viewAll = computed(() => page.props.auth.viewWells);

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

        <div v-if="data.matrix_data.length" class="bg-white dark:bg-gray-800 relative w-full">
            <div class="fixed top-[51px] z-10 bg-white dark:bg-gray-800 flex flex-col items-start justify-between gap-3 p-4 w-[calc(100%-50px)] md:flex-row md:items-center md:gap-3">


                <Dropdown align="bottom" width="48">
                    <template #trigger>
                        <button v-if="viewAll"
                                :class="ngduFilters.length > 0 ? 'border-green-500 ring-1 ring-green-500 text-green-500' : ' border-gray-300 text-gray-800 dark:border-gray-600 dark:text-gray-400'"
                                size="md" color="light"
                                class="hover:bg-gray-100 dark:hover:bg-gray-700 border rounded-lg px-3 py-1 h-9"
                        >
                            <span class="font-semibold">НГДУ</span>
                        </button>
                    </template>

                    <template #content>
                        <div class="absolute p-2 left-0 z-10 bg-white dark:bg-gray-900 dark:border-gray-700 border border-gray-200 rounded-lg shadow min-w-[300px]">
                            <h6 class="font-medium text-sm text-gray-400">Выберите НГДУ</h6>
                            <ul class="mt-[10px] w-full flex flex-col">
                                <li class="flex items-center gap-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                                    <input @change="selectAllNgduCheckboxes" id="ngdu_option_all" v-model="selectAllNgdus" class="text-green-600 dark:bg-gray-800 dark:border-gray-700 bg-gray-100 border-gray-300 rounded focus:ring-green-500 cursor-pointer" type="checkbox">
                                    <label class="cursor-pointer text-gray-800 dark:text-gray-400" :for="`ngdu_option_all`">Все</label>
                                </li>
                                <li v-for="(ngdu, index) in data.ngdu_data" :key="index" class="flex items-center gap-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                                    <ShopDropdown>
                                        <template #ignore>
                                            <input @change="handleNgduCheckboxFilter(ngdu)" :checked="ngduFilters.includes(ngdu.Id)" class="text-green-600 dark:bg-gray-800 dark:border-gray-700 bg-gray-100 border-gray-300 rounded focus:ring-green-500 cursor-pointer" :id="`ngdu_option_${index}`" type="checkbox">
                                            <label class="cursor-pointer text-gray-800 dark:text-gray-400" :for="`ngdu_option_${index}`">{{ ngdu.NgduName }}</label>
                                        </template>
                                        <template #trigger>
                                            <DropDownIcon />
                                        </template>
                                        <template #content>
                                            <ul v-if="ngdu.shops.length">
                                                <li v-for="(shop, index) in ngdu.shops" :id="`shop_option_${index}`" class="flex items-center gap-2 py-1">
                                                    <input @change="handleShopCheckboxFilter(shop)" :checked="shopFilters.includes(shop.Id)" :id="`shop_option_${index}`" type="checkbox" class="text-green-600 dark:bg-gray-800 dark:border-gray-700 bg-gray-100 border-gray-300 rounded focus:ring-green-500 cursor-pointer" >
                                                    <label class="cursor-pointer text-gray-500" :for="`shop_option_${index}`">{{ shop.ShopName }}</label>
                                                </li>
                                            </ul>
                                            <span class="text-gray-400" v-else>Нет данных</span>
                                        </template>

                                    </ShopDropdown>
                                </li>
                            </ul>
                        </div>
                    </template>
                </Dropdown>

                <button v-if="viewType !== 'grid'" @click="exportTableToExcel('xlsx')" size="md" class="hover:bg-opacity-80 border rounded-lg px-3 py-1 h-9 bg-green-600 border-green-500">
                    <span class="font-semibold text-white">Excel</span>
                </button>

                <Input v-model="searchFilter" size="sm" class="focus:ring-green-600 focus:border-green-500 w-56 ring-green-600 h-9" type="text"  placeholder="Поиск" required="">
                </Input>

                <div class="flex items-center gap-3">
                    <input checked v-model="radioFilter" id="all-radio" type="radio" name="filter" value="all" class="ring-0 focus:ring-0 text-green-500 dark:bg-gray-800 dark:border-gray-700 bg-gray-100 border-gray-300"/>
                    <label for="all-radio" class="font-semibold text-sm text-gray-800 dark:text-gray-400">Все</label>

                    <input v-model="radioFilter" id="today-radio" type="radio" name="filter" value="available" class="ring-0 focus:ring-0 text-green-500 dark:bg-gray-800 dark:border-gray-700 bg-gray-100 border-gray-300"/>
                    <label for="today-radio" class="font-semibold text-sm text-gray-800 dark:text-gray-400">Доступные</label>

                    <input v-model="radioFilter" id="earlier-radio" type="radio" name="filter" value="lost" class="ring-0 focus:ring-0 text-green-500 dark:bg-gray-800 dark:border-gray-700 bg-gray-100 border-gray-300"/>
                    <label for="earlier-radio" class="font-semibold text-sm text-gray-800 dark:text-gray-400">Недоступные</label>
                </div>

                <div class="flex w-full md:w-auto items-center justify-between gap-3 lg:ml-auto">
                    <select v-model="perPage" @change="updateData" class="block p-2 text-sm font-semibold dark:hover:bg-opacity-80 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-600 focus:border-green-600 cursor-pointer">
                        <option v-for="option in perPageOptions" :key="option" :value="option">
                            {{ option == 'all' ? 'Все записи' : `${option} записей` }}
                        </option>
                    </select>
                    <ul class="flex items-center ml-auto -space-x-px h-9 text-sm md:ml-0">
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

                <ul class="grid grid-cols-2 items-center gap-2">

                        <li>
                            <button
                                for="grid-wiew"
                                class="w-10 h-10 rounded-lg items-center justify-center flex hover:bg-gray-100 dark:hover:bg-gray-700"
                                :class="viewType === 'table' ? 'bg-gray-100 dark:bg-gray-700' : ''"
                                v-on:click="changeView('table')"
                            >
                                <TableIcon />
                            </button>
                        </li>

                        <li>
                            <button
                                for="grid-wiew"
                                class="w-10 h-10 rounded-lg items-center justify-center flex hover:bg-gray-100 dark:hover:bg-gray-700"
                                :class="viewType === 'grid' ? 'bg-gray-100 dark:bg-gray-700' : ''"
                                v-on:click="changeView('grid')"
                            >
                                <GridIcon />
                            </button>
                        </li>

                    </ul>

            </div>

            <div v-if="viewType === 'grid'" class="z-10 mt-[125px] w-full h-full overflow-x-auto p-4">
                <OperationsGrid v-if="paginatedData.length" :data="paginatedData"/>
                <div v-else class="flex flex-col gap-4 items-center justify-center w-full h-screen p-20 border border-gray-200 dark:border-gray-700 rounded-xl">
                    <NoDataIcon />
                    <span class="text-gray-500 text-lg font-semibold">Данных нет..</span>
                </div>
            </div>
            <div v-else class="mt-[120px] block max-h-[800px] overflow-y-auto">
                <MatrixTable v-if="paginatedData.length" :data="paginatedData"/>
                <div v-else class="flex flex-col gap-4 items-center justify-center w-full h-screen p-20 border border-gray-200 dark:border-gray-700 rounded-xl">
                    <NoDataIcon />
                    <span class="text-gray-500 text-lg font-semibold">Данных нет..</span>
                </div>
            </div>
        </div>

        <div v-else class="bg-gray-50 dark:bg-gray-800 relative w-full h-screen flex justify-center">
            <div class="flex flex-col items-center mt-52">
                <div class="w-56 h-56 rounded-lg">
                    <img class="rounded-lg" src="/images/well.png" alt="">
                </div>
                <h3 class="font-semibold text-gray-800 text-lg mt-5">Ой, здесь пусто!</h3>
                <span class="text-gray-400 text-sm mt-2">Но скоро что-то будет</span>
            </div>
        </div>
    </AuthorizedLayout>
</template>
