<script setup>
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import HourArchIcon from '@/Components/Icons/HourArchIcon.vue';
import AskStatsIcon from '@/Components/Icons/AskStatsIcon.vue';
import AlarmIcon from '@/Components/Icons/AlarmIcon.vue';
import DiagramsIcon from '@/Components/Icons/DiagramsIcon.vue';
import { Link, Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import SkeletonDnmhTable from './Partials/SkeletonDnmhTable.vue';
import DnmChart from './Partials/DnmChart.vue';
import NoDataIcon from '@/Components/Icons/NoDataIcon.vue';
import EngineIcon from '@/Components/Icons/EngineIcon.vue';
import { watch } from 'vue';
import Dinamogram from '@/Components/Icons/Dinamogram.vue';
import DinamographLogo from "@/Components/Icons/DinamographLogo.vue";
import {Spinner} from "flowbite-vue";
import ClearIcon from "@/Components/Icons/ClearIcon.vue";
import {encryptStorage} from "@/utils/storage.js";
import DatePicker from "vue-datepicker-next";
import 'vue-datepicker-next/index.css';
import 'vue-datepicker-next/locale/ru.es';
import CalendarIcon from "@/Components/Icons/CalendarIcon.vue";

const props = defineProps({
    item: {
        type: Object,
        required: true,
    }
});

const dnmhData = ref([]);
const dnmData = ref([]);
const categoriesLoading = ref(false);
const categories = ref([]);
const paginatedData = ref([]);
const aiError = ref('');
const paginationSource = ref('Параметры')
const paginationSourceTypes = ['Параметры', 'Динамограммы']
const dateFilters = ref([]);

const predictionsData = ref([]);

const API_KEY = import.meta.env.VITE_API_KEY
const DINAMOGRAPH_API_URL = import.meta.env.VITE_DINAMOGRAPH_API_URL

const processingAiAnalysis = ref(false);
const showAiReportWindow = ref(false);

const getAiModelVersion = () => {

    return axios.get(`${DINAMOGRAPH_API_URL}/v1/ai/models/`, {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Basic ${API_KEY}`
        },
    }).then(res => {
        const aiModels = res.data.models

        if (!aiModels.find(item => item.public_id === encryptStorage.getItem('aiv'))) {
            encryptStorage.setItem('aiv', aiModels[0].public_id)
        }

        return axios.get(`${DINAMOGRAPH_API_URL}/v1/ai/models/${encryptStorage.getItem('aiv')}`, {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Basic ${API_KEY}`
            },
        }).then(res => {
            return res.data.name
        })
    })

}

const fetchDnmhData = () => {
    return axios.get(`/api/dnmh/${props.item.public_id}`)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            console.error('Error fetching Dnmh data', error);
        });
};

const fetchDnmData = (publicId) => {
    return axios.get(`/api/dnm/${publicId}`)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            console.error('Error fetching Dnm data', error);
        });
};

const fetchRawPrediction = async (data) => {
    processingAiAnalysis.value = true;

    return axios.post(`${DINAMOGRAPH_API_URL}/v1/ai/predict/raw`, {
        raw_data: data,
        model_name: await getAiModelVersion()
    }, {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Basic ${API_KEY}`
        },
    })
        .then(response => {
            const res = response.data

            return `${res.split('_').join(' ')}`
        })
        .catch(error => {
            aiError.value = 'Ошибка при составлении отчёта. Повторите попытку позже.'

            setTimeout(() => {
                aiError.value = ''

                showAiReportWindow.value = false
            }, 5000)
        })
        .finally(() => {
            processingAiAnalysis.value = false;
        })
}

const make_ai_analysis = async () => {
    showAiReportWindow.value = true
    const predictionsArr = []

    for (const dnm of dnmData.value) {
        await fetchRawPrediction(dnm.data)
            .then(res => {
                predictionsArr.push({
                    public_id: dnm.public_id,
                    color: dnm.color,
                    prediction: res
                })
            })
    }
    predictionsData.value = predictionsArr
}

const fetchWellCategories = () => {

    categoriesLoading.value = true;

    return axios.get(`/api/control/${props.item.public_id}/categories/fact`)
        .then((response) => {
            categories.value = response.data;
        })
        .catch((error) => {
            console.error('Ошибка', error);
        })
        .finally(() => {
            categoriesLoading.value = false;
        });
};


onMounted(() => {
    fetchDnmhData()
        .then((data) => {
            if (data.length > 0) {
                dnmhData.value = data;
                paginateData();
                selectDinamogram(dnmhData.value[0].public_id);
            }
        });
    fetchWellCategories();
});

const extractWellNumber = (string) => {
    const elements = string.split('-');
    return elements[elements.length - 1];
};

const selectDinamogram = (publicId) => {
    const existingDinamogramIndex = dnmData.value.findIndex((item) => item.public_id === publicId);

    if (existingDinamogramIndex !== -1) {
        // If the dinamogram already exists, remove it
        dnmData.value.splice(existingDinamogramIndex, 1);

        // Reassign colors based on their order for the first five dinamograms
        for (let i = 0; i < dnmData.value.length; i++) {
            if (i === 0) {
                dnmData.value[i].color = 'green';
            } else if (i === 1) {
                dnmData.value[i].color = 'orange';
            } else if (i === 2) {
                dnmData.value[i].color = 'red';
            } else if (i === 3) {
                dnmData.value[i].color = 'blue';
            } else {
                dnmData.value[i].color = 'purple';
            }
        }
    } else {
        if (dnmData.value.length >= 5) {
            // If there are already 5 dinamograms, remove the oldest one
            dnmData.value.shift();
        }

        fetchDnmData(publicId)
            .then((data) => {
                const colorOptions = ['green', 'orange', 'red', 'blue', 'purple'];
                const selectedColor = colorOptions[dnmData.value.length]; // Use the next available color

                const dinamogram = {
                    public_id: publicId,
                    color: selectedColor,
                    data: data,
                };

                dnmData.value.push(dinamogram);

                // Reassign colors based on their order for the first five dinamograms
                for (let i = 0; i < dnmData.value.length; i++) {
                    if (i === 0) {
                        dnmData.value[i].color = 'green';
                    } else if (i === 1) {
                        dnmData.value[i].color = 'orange';
                    } else if (i === 2) {
                        dnmData.value[i].color = 'red';
                    } else if (i === 3) {
                        dnmData.value[i].color = 'blue';
                    } else {
                        dnmData.value[i].color = 'purple';
                    }
                }
            });
    }
};

// Pagination

const currentPage = ref(1);
const perPage = ref(4);

const totalPages = computed(() => {

    if (paginatedData.value.length > 0) {
        return Math.ceil(filteredDnmData.value.length / perPage.value);
    }

});

const filteredDnmData = computed(() => {
    let data = dnmhData.value;

    if (dateFilters.value && dateFilters.value.length === 2) {
        const [startDate, endDate] = dateFilters.value;

        data = data.filter(dataItem => {
            const itemDate = new Date(dataItem.Dat);

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

const paginateData = () => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    paginatedData.value = filteredDnmData.value.slice(start, end);
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


// Pagination categories

const currentPageCategories = ref(1);
const perPageCategories = ref(10);

const totalPagesCategories = computed(() => {
    return Math.ceil(categories.value.length / perPageCategories.value);
});

const paginatedDataCategories = computed(() => {
    const data = categories.value || []

    const start = (currentPageCategories.value - 1) * perPageCategories.value;
    const end = start + perPageCategories.value;


    return data.slice(start, end);
});

const visiblePagesCategories = computed(() => {
    const totalVisiblePages = 5;
    const pages = [];
    let startPage;

    if (totalPagesCategories.value <= totalVisiblePages) {
        startPage = 1;
    } else if (currentPageCategories.value <= 2) {
        startPage = 1;
    } else if (currentPageCategories.value >= totalPagesCategories.value - 2) {
        startPage = totalPagesCategories.value - totalVisiblePages + 1;
    } else {
        startPage = currentPageCategories.value - Math.floor(totalVisiblePages / 2);
    }

    for (let i = 0; i < totalVisiblePages && startPage <= totalPagesCategories.value; i++) {
        pages.push(startPage);
        startPage++;
    }

    return pages;
});

const setCurrentPageCategories = (page) => {
    currentPageCategories.value = page;
};

const prevPageCategories = () => {
    if (currentPageCategories.value > 1) {
        currentPageCategories.value--;
    }
};

const nextPageCategories = () => {
    if (currentPageCategories.value < totalPagesCategories.value) {
        currentPageCategories.value++;
    }
};

const clearDate = () => {
    dateFilters.value = [];
};

watch(() => [dnmhData.value, dateFilters.value], () => {
    paginateData();
}, {deep: true});

const page = usePage();
const controlWells = computed(() => page.props.auth.controlWells);
</script>

<template>
    <Head :title="item.Name"/>

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
            <div class="flex flex-col gap-5 p-8">

                <!-- Flex [ | ] -->
                <div class="flex w-full items-stretch gap-10">

                    <div class="flex flex-col gap-5 w-2/4">

                        <div class="flex gap-5 items-center mt-2">
                            <div
                                :class="item.Connect ? 'bg-green-100 dark:bg-green-800 dark:bg-opacity-50' : 'bg-gray-100 dark:bg-gray-700'"
                                class="w-5 h-5 rounded-full z-1 flex items-center justify-center cursor-pointer">
                                <div
                                    :class="item.Connect ? 'bg-green-300 dark:bg-green-400' : 'bg-gray-300 dark:bg-gray-600'"
                                    class="w-1/2 h-1/2 rounded-full z-2"></div>
                            </div>
                            <span class="font-bold text-gray-800 dark:text-gray-300 text-lg">{{ item.Name }}</span>
                            <div class="flex items-center gap-[10px] ml-auto cursor-pointer hover:opacity-80"
                                 @click="make_ai_analysis">
                                <span class="text-[13px] font-medium text-purple-400">AI анализ</span>
                                <div class="flex items-center bg-purple-200 justify-center p-1 rounded-[5px]">
                                    <span class="text-[11px] uppercase font-bold text-purple-800">бета</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col border border-gray-200 dark:border-gray-700 rounded-xl mt-2">
                            <div class="flex gap-2 p-3 items-center border-b border-gray-200 dark:border-gray-700">
                                <span class="text-sm text-gray-500 w-1/4">Номер</span>
                                <span class="text-lg font-medium text-gray-800 dark:text-gray-400">{{
                                        extractWellNumber(item.Name)
                                    }}</span>
                            </div>
                            <div class="flex gap-2 p-3 items-center border-b border-gray-200 dark:border-gray-700">
                                <span class="text-sm text-gray-500 w-1/4">ПЛК</span>
                                <span class="text-lg font-medium text-gray-800 dark:text-gray-400">{{
                                        item.PlcName
                                    }}</span>
                            </div>
                            <div class="flex gap-2 p-3 items-center border-b border-gray-200 dark:border-gray-700">
                                <span class="text-sm text-gray-500 w-1/4">НГДУ</span>
                                <span class="text-lg font-medium text-gray-800 dark:text-gray-400">{{
                                        item.NgduName
                                    }}</span>
                            </div>
                            <div class="flex gap-2 p-3 items-center">
                                <span class="text-sm text-gray-500 w-1/4">Цех</span>
                                <span class="text-lg font-medium text-gray-800 dark:text-gray-400">{{
                                        item.ShopName
                                    }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <Link :href="route('matrix.hourarch', item.public_id)">
                                <div
                                    class="p-6 flex gap-5 bg-white rounded-lg shadow border border-gray-200 dark:bg-gray-700 dark:border-gray-600 items-center hover:bg-gray-100 dark:hover:bg-opacity-80 cursor-pointer h-10">
                                    <HourArchIcon/>
                                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-300">Архивы</span>
                                </div>
                            </Link>
                            <Link :href="route('matrix.askstats', item.public_id)">
                                <div
                                    class="p-6 flex gap-5 bg-white rounded-lg shadow border border-gray-200 dark:bg-gray-700 dark:border-gray-600 items-center hover:bg-gray-100 dark:hover:bg-opacity-80 cursor-pointer h-10">
                                    <AskStatsIcon/>
                                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-300">Опросы</span>
                                </div>
                            </Link>
                            <Link :href="route('matrix.alarms', item.public_id)">
                                <div
                                    class="p-6 flex gap-5 bg-white rounded-lg shadow border border-gray-200 dark:bg-gray-700 dark:border-gray-600 items-center hover:bg-gray-100 dark:hover:bg-opacity-80 cursor-pointer h-10">
                                    <AlarmIcon/>
                                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-300">Аварии</span>
                                </div>
                            </Link>

                            <Link :href="route('matrix.diagrams', item.public_id)">
                                <div
                                    class="p-6 flex gap-5 bg-white rounded-lg shadow border border-gray-200 dark:bg-gray-700 dark:border-gray-600 items-center hover:bg-gray-100 dark:hover:bg-opacity-80 cursor-pointer h-10">
                                    <DiagramsIcon/>
                                    <span
                                        class="text-sm font-semibold text-gray-800 dark:text-gray-300">Диаграммы</span>
                                </div>
                            </Link>

                            <Link v-if="controlWells" :href="route('matrix.control', item.public_id)">
                                <div
                                    class="p-6 flex gap-5 bg-green-600 rounded-lg shadow border border-green-500 items-center hover:bg-opacity-80 dark:hover:bg-opacity-80 cursor-pointer h-10">
                                    <EngineIcon/>
                                    <span class="text-sm font-semibold text-white">Управление</span>
                                </div>
                            </Link>
                        </div>

                    </div>

                    <div v-if="dnmData.length > 0"
                         class="w-3/4 flex flex-col items-start border border-gray-200 dark:border-gray-700 rounded-xl">
                        <DnmChart :data="dnmData"/>
                        <div class="relative w-full mt-[20px]">

                            <div v-if="showAiReportWindow" class="absolute top-[110%] w-full">
                                <div class="relative w-full bg-white rounded-lg shadow-lg dark:border-gray-700 dark:bg-gray-900 p-4 gap-[20px]
                           flex flex-col border border-gray-200">
                                    <ClearIcon @click="showAiReportWindow = false"
                                               class="absolute top-[10px] right-[10px] cursor-pointer"/>
                                    <div class="flex items-center gap-[10px]">
                                        <DinamographLogo/>
                                        <code class="text-gray-800 dark:text-white text-[14px]">Отчёт Динамографа</code>
                                    </div>
                                    <div v-if="!processingAiAnalysis && !aiError" class="flex flex-col gap-[15px] pl-2">
                                        <div v-for="(dnm, index) in predictionsData"
                                             :key="index"
                                             class="flex items-center gap-[10px]">
                                            <div :style="{ 'background-color': dnm.color }"
                                                 class="rounded-full w-[10px] h-[10px]"></div>
                                            <code>{{ dnm.prediction }}</code>
                                            <span class="text-[13px] text-gray-400">{{
                                                    dnmhData.find(item => item.public_id === dnm.public_id).DnmAdress
                                                }}</span>
                                        </div>
                                    </div>
                                    <div v-else-if="aiError">
                                        <code class="text-red-500">{{ aiError }}</code>
                                    </div>
                                    <Spinner class="fill-white" v-else/>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div v-else
                         class="flex flex-col gap-10 w-3/4 min-h-full items-center justify-center border border-gray-200 dark:border-gray-700 rounded-xl">
                        <Dinamogram/>
                        <span class="text-gray-300 font-regular max-w-[400px] text-center">Выберите динамограмму для отображения в таблице ниже</span>
                    </div>

                </div>

                <div class="flex w-full flex-col gap-5">

                    <div class="flex w-full items-center gap-4">

                        <div class="flex items-center bg-gray-100 dark:bg-gray-900 rounded-lg p-1 gap-2">
                            <div v-for="(item, index) in paginationSourceTypes"
                                 :key="index"
                                 class="flex items-center gap-2"
                                 @click="paginationSource = item">
                                <span
                                    class="p-2 cursor-pointer rounded-lg text-gray-300 dark:text-gray-600 font-semibold text-[12px]"
                                    :class="{ 'bg-white shadow-sm dark:bg-gray-700 text-gray-800 dark:text-white hover:bg-opacity-80' : paginationSource === item }">{{
                                        item
                                    }}</span>
                                <span
                                    v-if="index !== paginationSourceTypes.length - 1"
                                    class="text-[13px] font-light text-gray-300 dark:text-gray-600"
                                >
                                    |
                                </span>
                            </div>
                        </div>

                        <date-picker v-if="paginationSource === 'Динамограммы'" class="flex relative h-9 w-56"
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
                                <CalendarIcon/>
                            </template>

                            <template #icon-clear>
                                <ClearIcon/>
                            </template>
                        </date-picker>

                        <ul v-if="paginationSource === 'Параметры'"
                            class="flex items-center -space-x-px h-9 text-sm ml-auto">
                            <li>
                                <button @click="prevPageCategories" :disabled="currentPageCategories === 1" href="#"
                                        class="flex items-center justify-center px-3 h-9 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <span class="sr-only">Пред.</span>
                                    <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="M5 1 1 5l4 4"/>
                                    </svg>
                                </button>
                            </li>
                            <li v-for="page in visiblePagesCategories" :key="page">
                                <button
                                    @click="setCurrentPageCategories(page)"
                                    :class="{ 'font-bold text-green-600': currentPageCategories === page }"
                                    class="flex items-center justify-center px-3 h-9 leading-tight text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                >
                                    {{ page }}
                                </button>
                            </li>
                            <li>
                                <button @click="nextPageCategories"
                                        :disabled="currentPageCategories === totalPagesCategories" href="#"
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
                        <ul v-if="paginationSource === 'Динамограммы'"
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
                                <button @click="nextPage" :disabled="currentPage === totalPages" href="#"
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

                    <div v-if="paginationSource === 'Параметры'" class="w-full grid grid-cols-5 gap-[5px]">
                        <div v-if="paginatedDataCategories.length"
                             v-for="(category, index) in paginatedDataCategories"
                             :key="index"
                             class="flex h-[150px] items-center justify-between bg-white border border-gray-100 dark:bg-gray-900
                         shadow-md p-4 rounded-lg dark:border-gray-700">
                            <div class="flex flex-col h-full justify-between">
                                <span class="text-[18px] font-black text-gray-800 dark:text-white">{{
                                        category.CatNameShorted
                                    }}</span>
                                <span class="text-[14px] font-normal text-gray-800 dark:text-gray-400 max-w-[150px]">{{
                                        category.CatName
                                    }}</span>
                            </div>

                            <div class="flex flex-col items-end h-full justify-between">
                                <code
                                    class="bg-gray-200 w-min dark:bg-gray-800 rounded-[10px] p-2 text-[20px] font-semibold">
                                    {{ category.FactValue }}
                                </code>
                                <div class="flex items-center gap-2">
                                    <span class="text-[14px] text-gray-400">АРМИТС</span>
                                    <code v-if="category.ArmitsValue"
                                          class="bg-gray-200 w-min dark:bg-gray-800 rounded-[10px] p-2 text-[16px] font-semibold">
                                        {{ category.ArmitsValue }}
                                    </code>
                                    <span v-else class="text-[14px] text-red-500 font-semibold">Пусто</span>
                                </div>
                            </div>
                        </div>

                        <SkeletonDnmhTable v-else/>
                    </div>

                    <div v-if="paginationSource === 'Динамограммы'"
                         class="w-full overflow-x-auto overflow-y-auto border border-gray-200 dark:border-gray-700 rounded-xl">
                        <table v-if="paginatedData.length" class="w-full">
                            <thead>
                            <tr class="border-b bg-gray-50 border-gray-200 dark:bg-gray-900 dark:bg-opacity-40 dark:border-gray-700 ">
                                <th scope="col" class="px-6 py-4 text-left w-[50px]">
                                    <span class="text font-semibold text-gray-800"></span>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700 ">
                                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Дата</span>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700 ">
                                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Опрос</span>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700 ">
                                    <span
                                        class="text font-semibold text-gray-800 dark:text-gray-300">Наименование</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(row, index) in paginatedData" :key="index"
                                class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="row"
                                    class="font-normal text-gray-500 px-6 py-4 text-left border-b border-gray-200 dark:border-gray-700">
                                    <input
                                        @change="() => selectDinamogram(row.public_id)"
                                        :value="row.public_id"
                                        :checked="dnmData.some((item) => item.public_id === row.public_id)"
                                        :style="{ color: dnmData.find((item) => item.public_id === row.public_id)?.color }"
                                        class="bg-gray-100 text-gray-100 dark:text-gray-800 dark:bg-gray-800 dark:border-gray-700 focus:ring-gray-100 dark:focus:ring-gray-800  border-gray-300 rounded cursor-pointer"
                                        type="checkbox"
                                    />
                                </th>
                                <td class="font-normal border-l border-gray-200 dark:border-gray-700  text-gray-500 px-6 py-4 text-left">
                                    {{ row.Dat }}
                                </td>
                                <td class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-400">
                                    {{ row.AskLong }}
                                </td>
                                <td class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-400">
                                    {{ row.DnmAdress }}
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <SkeletonDnmhTable v-else/>
                    </div>

                </div>

            </div>
        </div>
    </AuthorizedLayout>
</template>
