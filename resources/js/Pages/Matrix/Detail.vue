<script setup>
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import HourArchIcon from '@/Components/Icons/HourArchIcon.vue';
import AskStatsIcon from '@/Components/Icons/AskStatsIcon.vue';
import AlarmIcon from '@/Components/Icons/AlarmIcon.vue';
import DiagramsIcon from '@/Components/Icons/DiagramsIcon.vue';
import {Link, Head, usePage} from '@inertiajs/vue3';
import {ref, onMounted, computed} from 'vue';
import axios from 'axios';
import DnmChart from './Partials/DnmChart.vue';
import Dinamogram from '@/Components/Icons/Dinamogram.vue';
import DinamographLogo from "@/Components/Icons/DinamographLogo.vue";
import {Spinner} from "flowbite-vue";
import ClearIcon from "@/Components/Icons/ClearIcon.vue";
import DetailParams from "@/Pages/Matrix/Partials/DetailParams.vue";
import DetailDinamograms from "@/Pages/Matrix/Partials/DetailDinamograms.vue";
import DetailUserClaims from "@/Pages/Matrix/Partials/DetailUserClaims.vue";
import DetailWellClaims from "@/Pages/Matrix/Partials/DetailWellClaims.vue";
import DetailClaimsUntracked from "@/Pages/Matrix/Partials/DetailClaimsUntracked.vue";
import DetailMoveWell from "@/Pages/Matrix/Partials/DetailMoveWell.vue";
import DetailMoveWellUser from "@/Pages/Matrix/Partials/DetailMoveWellUser.vue";
import DetailNavigationTabMenu from './Partials/DetailNavigationTabMenu.vue';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    }
});

const user = usePage().props.auth

const API_KEY = import.meta.env.VITE_API_KEY
const DINAMOGRAPH_API_URL = import.meta.env.VITE_DINAMOGRAPH_API_URL
const DEFAULT_AI_VERSION = import.meta.env.VITE_DEFAULT_AI_VERSION

const selectedDinamograms = ref([])
const selectedDnmh = ref([])
const predictionsData = ref([]);
const paginatedData = ref([]);
const processingAiAnalysis = ref(false);
const showAiReportWindow = ref(false);
const aiError = ref('');
const paginationSource = ref('Параметры')
const paginationSourceTypes = ['Параметры', 'Динамограммы'];

const handleSelectDnm = (value) => {
    selectedDinamograms.value = value;
}

const handleSelectDnmh = (value) => {
    selectedDnmh.value = value;
}

const fetchRawPrediction = async (data) => {
    processingAiAnalysis.value = true;

    return axios.post(`${DINAMOGRAPH_API_URL}/v1/ai/predict/raw`, {
        raw_data: data,
        model_name: DEFAULT_AI_VERSION
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

    for (const dnm of selectedDinamograms.value) {
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

const extractWellNumber = (string) => {
    const elements = string.split('-');
    return elements[elements.length - 1];
};

const page = usePage();

const changePaginationSource = (val) => {
    paginationSource.value = val;
};

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

                    <div :class="[{ 'w-full' : paginationSource !== 'Динамограммы' }]"
                         class="w-2/4 h-[400px] flex flex-col gap-5 ">

                        <div class="flex gap-5 items-center mt-2">
                            <div
                                :class="item.Connect ? 'bg-green-100 dark:bg-green-800 dark:bg-opacity-50' : 'bg-gray-100 dark:bg-gray-700'"
                                class="w-5 h-5 rounded-full z-1 flex items-center justify-center cursor-pointer">
                                <div
                                    :class="item.Connect ? 'bg-green-300 dark:bg-green-400' : 'bg-gray-300 dark:bg-gray-600'"
                                    class="w-1/2 h-1/2 rounded-full z-2"></div>
                            </div>
                            <span class="font-bold text-gray-800 dark:text-gray-300 text-lg">{{ item.Name }}</span>
                        </div>

                        <div
                            class="min-w-[300px] flex flex-col border border-gray-200 dark:border-gray-700 rounded-xl mt-2">
                            <div class="flex gap-2 p-3 items-center border-b border-gray-200 dark:border-gray-700">
                                <span class="text-[13px] text-gray-500 w-1/4">Номер</span>
                                <span class="text-[14px] font-medium text-gray-800 dark:text-gray-400">{{
                                        extractWellNumber(item.Name)
                                    }}</span>
                            </div>
                            <div class="flex gap-2 p-3 items-center border-b border-gray-200 dark:border-gray-700">
                                <span class="text-[13px] text-gray-500 w-1/4">ПЛК</span>
                                <span class="text-[14px] font-medium text-gray-800 dark:text-gray-400">{{
                                        item.PlcName
                                    }}</span>
                            </div>
                            <div class="flex gap-2 p-3 items-center border-b border-gray-200 dark:border-gray-700">
                                <span class="text-[13px] text-gray-500 w-1/4">НГДУ</span>
                                <span class="text-[14px] font-medium text-gray-800 dark:text-gray-400">{{
                                        item.NgduName
                                    }}</span>
                            </div>
                            <div class="flex gap-2 p-3 items-center">
                                <span class="text-[13px] text-gray-500 w-1/4">Цех</span>
                                <span class="text-[14px] font-medium text-gray-800 dark:text-gray-400">{{
                                        item.ShopName
                                    }}</span>
                            </div>
                        </div>

                        <div class="w-full grid grid-cols-4 gap-3 h-full">
                            <Link :href="route('matrix.hourarch', item.public_id)">
                                <div class="h-full flex flex-col gap-2 items-center justify-center bg-gray-100 rounded-lg
                                    hover:border dark:hover:border hover:border-gray-300 dark:hover:border-gray-500 dark:bg-gray-900"
                                >
                                    <div
                                        class="h-12 w-12 flex items-center justify-center bg-gray-200 dark:bg-gray-800 rounded-md">
                                        <HourArchIcon/>
                                    </div>

                                    <span class="text-[13px] font-semibold text-gray-400">Архивы</span>
                                </div>
                            </Link>
                            <Link :href="route('matrix.askstats', item.public_id)">
                                <div class="h-full flex flex-col gap-2 items-center justify-center bg-gray-100 rounded-lg
                                    hover:border dark:hover:border hover:border-gray-300 dark:hover:border-gray-500 dark:bg-gray-900"
                                >
                                    <div
                                        class="h-12 w-12 flex items-center justify-center bg-gray-200 dark:bg-gray-800 rounded-md">
                                        <AskStatsIcon/>
                                    </div>

                                    <span class="text-[13px] font-semibold text-gray-400">Опросы</span>
                                </div>
                            </Link>
                            <Link :href="route('matrix.alarms', item.public_id)">
                                <div class="h-full flex flex-col gap-2 items-center justify-center bg-gray-100 rounded-lg
                                    hover:border dark:hover:border hover:border-gray-300 dark:hover:border-gray-500 dark:bg-gray-900"
                                >
                                    <div
                                        class="h-12 w-12 flex items-center justify-center bg-gray-200 dark:bg-gray-800 rounded-md">
                                        <svg class="fill-gray-400" width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5749 3.11468L16.6404 0.901245L15.6939 3.10962L13.5382 8.13956L9.19276 6.31727L6.92739 5.36728L7.85031 7.64381L9.73453 12.2915L5.70966 11.6996L2.89673 11.286L4.80248 13.3959L9.57213 18.6766L11.0891 17.3064L8.22518 14.1357L11.204 14.5738L12.9708 14.8336L12.2999 13.1786L10.6676 9.15235L13.6829 10.4168L14.6181 10.809L15.0176 9.87691L16.6263 6.12322L18.9283 11.5753L19.2753 12.3972L20.1366 12.1644L24.1875 11.0696L23.2224 12.9194L22.773 13.7807L23.6103 14.2732L24.7333 14.9337L20.8435 16.5354L21.6218 18.4256L27.4135 16.0407L29.3155 15.2576L27.5426 14.2147L25.484 13.0038L27.0788 9.94707L28.1578 7.87904L25.906 8.48763L20.4645 9.95831L17.5749 3.11468ZM7.30473 21.8537C6.98832 21.8537 6.73181 22.1102 6.73181 22.4266V28.0976C6.73181 28.7442 6.20766 29.2683 5.56108 29.2683C4.91451 29.2683 4.39035 28.7442 4.39035 28.0976V22.4266C4.39035 20.8171 5.69516 19.5122 7.30473 19.5122H24.5004C26.1099 19.5122 27.4147 20.817 27.4147 22.4266V28.0976C27.4147 28.7442 26.8906 29.2683 26.244 29.2683C25.5974 29.2683 25.0733 28.7442 25.0733 28.0976V22.4266C25.0733 22.1102 24.8168 21.8537 24.5004 21.8537H7.30473ZM14.5368 26.9269C13.8902 26.9269 13.3661 27.451 13.3661 28.0976C13.3661 28.7442 13.8902 29.2683 14.5368 29.2683H21.1709C21.8175 29.2683 22.3417 28.7442 22.3417 28.0976C22.3417 27.451 21.8175 26.9269 21.1709 26.9269H14.5368ZM9.85389 29.2684C10.5005 29.2684 11.0246 28.7442 11.0246 28.0977C11.0246 27.4511 10.5005 26.9269 9.85389 26.9269C9.20732 26.9269 8.68316 27.4511 8.68316 28.0977C8.68316 28.7442 9.20732 29.2684 9.85389 29.2684Z" />
                                        </svg>
                                    </div>

                                    <span class="text-[13px] font-semibold text-gray-400">Аварии</span>
                                </div>
                            </Link>

                            <Link :href="route('matrix.diagrams', item.public_id)">
                                <div class="h-full flex flex-col gap-2 items-center justify-center bg-gray-100 rounded-lg
                                    hover:border dark:hover:border hover:border-gray-300 dark:hover:border-gray-500 dark:bg-gray-900"
                                >
                                    <div
                                        class="h-12 w-12 flex items-center justify-center bg-gray-200 dark:bg-gray-800 rounded-md">
                                        <DiagramsIcon/>
                                    </div>

                                    <span class="text-[13px] font-semibold text-gray-400">Диаграммы</span>
                                </div>
                            </Link>

                        </div>

                    </div>

                    <div v-if="paginationSource === 'Динамограммы'"
                         class="w-3/4 h-[400px] flex flex-col items-start border border-gray-200 dark:border-gray-700
                            rounded-xl"
                    >
                        <DnmChart v-if="selectedDinamograms.length > 0" :data="selectedDinamograms"/>

                        <div v-else class="w-full h-full flex flex-col items-center justify-center gap-4">
                            <Dinamogram/>
                            <span class="text-gray-300 font-regular max-w-[400px] text-center">Выберите динамограмму для отображения во вкладке "динамограммы"</span>
                        </div>
                        <div class="relative w-full mt-[20px]">

                            <div v-if="showAiReportWindow" class="absolute top-[110%] w-full z-[99]">
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
                                             class="flex items-center gap-10"
                                        >
                                            <div :style="{ 'background-color': dnm.color }"
                                                 class="rounded-full w-[10px] h-[10px]"></div>

                                            <div class="flex flex-col gap-1">
                                                    <span class="text-[13px] text-gray-400">{{
                                                            selectedDnmh.find(src => src.public_id === dnm.public_id).DnmAdress
                                                        }}</span>
                                                <code>{{ dnm.prediction }}</code>
                                            </div>

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

                </div>

                <DetailParams v-if="paginationSource === 'Параметры'"
                              :is-control="user.controlWells"
                              @created="() => { paginationSource = 'Заявки' }"
                              :item="item">
                    <div class="flex items-center bg-gray-100 dark:bg-gray-900 rounded-lg p-1 gap-2">
                        <DetailNavigationTabMenu :pagination-source-types="paginationSourceTypes" :current-source-type="paginationSource" @select="changePaginationSource" />
                    </div>
                </DetailParams>

                <DetailDinamograms v-if="paginationSource === 'Динамограммы'"
                                   @select-dnmh="handleSelectDnmh"
                                   @select-dnm="handleSelectDnm"
                                   :item="item">
                    <template class="flex items-center gap-2">
                        <div class="flex items-center bg-gray-100 dark:bg-gray-900 rounded-lg p-1 gap-2">
                            <DetailNavigationTabMenu :pagination-source-types="paginationSourceTypes" :current-source-type="paginationSource" @select="changePaginationSource" />
                        </div>
                        <div
                            class="relative p-4 flex gap-3 bg-white rounded-lg shadow border border-gray-200 dark:bg-gray-700
                                dark:border-gray-600 items-center hover:bg-gray-100 dark:hover:bg-opacity-80
                                cursor-pointer h-10"
                            @click="make_ai_analysis"
                        >
                            <DinamographLogo class="w-5 h-5"/>
                            <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">AI анализ</span>

                            <div class="flex items-center bg-purple-200 justify-center p-1 rounded-[5px]">
                                <span class="text-[11px] uppercase font-bold text-purple-800">бета</span>
                            </div>
                        </div>
                    </template>
                </DetailDinamograms>

            </div>


        </div>
    </AuthorizedLayout>
</template>

