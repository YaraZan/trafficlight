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
import SkeletonDnmhTable from './Partials/SkeletonDnmhTable.vue';
import DnmChart from './Partials/DnmChart.vue';
import NoDataIcon from '@/Components/Icons/NoDataIcon.vue';
import EngineIcon from '@/Components/Icons/EngineIcon.vue';
import {watch} from 'vue';
import Dinamogram from '@/Components/Icons/Dinamogram.vue';
import DinamographLogo from "@/Components/Icons/DinamographLogo.vue";
import {Spinner} from "flowbite-vue";
import ClearIcon from "@/Components/Icons/ClearIcon.vue";
import {encryptStorage} from "@/utils/storage.js";
import DatePicker from "vue-datepicker-next";
import 'vue-datepicker-next/index.css';
import 'vue-datepicker-next/locale/ru.es';
import CalendarIcon from "@/Components/Icons/CalendarIcon.vue";
import {fetchDnmData, fetchDnmhData, fetchWellCategories} from "@/Api/matrix.js";
import DetailParams from "@/Pages/Matrix/Partials/DetailParams.vue";
import DetailDinamograms from "@/Pages/Matrix/Partials/DetailDinamograms.vue";
import DetailUserClaims from "@/Pages/Matrix/Partials/DetailUserClaims.vue";
import DetailWellClaims from "@/Pages/Matrix/Partials/DetailWellClaims.vue";
import DetailClaimsUntracked from "@/Pages/Matrix/Partials/DetailClaimsUntracked.vue";

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
const paginationSourceTypes = ['Параметры', 'Динамограммы', 'Заявки']

const currentClaimType = ref('История')
const claimTypes = ['История', 'Мои', user.isClaimModerator ? 'Утверждение' : null].filter(Boolean);

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

                    <div :class="[{ 'w-full' : paginationSource !== 'Динамограммы' }]" class="w-2/4 h-[400px] flex flex-col gap-5 ">

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

                        <div class="min-w-[300px] flex flex-col border border-gray-200 dark:border-gray-700 rounded-xl mt-2">
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
                                    hover:bg-opacity-70 dark:hover:bg-opacity-70 dark:bg-gray-900"
                                >
                                    <div class="h-12 w-12 flex items-center justify-center bg-gray-200 dark:bg-gray-800 rounded-md">
                                        <HourArchIcon/>
                                    </div>

                                    <span class="text-[13px] font-semibold text-gray-400">Архивы</span>
                                </div>
                            </Link>
                            <Link :href="route('matrix.askstats', item.public_id)">
                                <div class="h-full flex flex-col gap-2 items-center justify-center bg-gray-100 rounded-lg
                                    hover:bg-opacity-70 dark:hover:bg-opacity-70 dark:bg-gray-900"
                                >
                                    <div class="h-12 w-12 flex items-center justify-center bg-gray-200 dark:bg-gray-800 rounded-md">
                                        <AskStatsIcon/>
                                    </div>

                                    <span class="text-[13px] font-semibold text-gray-400">Опросы</span>
                                </div>
                            </Link>
                            <Link :href="route('matrix.alarms', item.public_id)">
                                <div class="h-full flex flex-col gap-2 items-center justify-center bg-gray-100 rounded-lg
                                    hover:bg-opacity-70 dark:hover:bg-opacity-70 dark:bg-gray-900"
                                >
                                    <div class="h-12 w-12 flex items-center justify-center bg-gray-200 dark:bg-gray-800 rounded-md">
                                        <AlarmIcon/>
                                    </div>

                                    <span class="text-[13px] font-semibold text-gray-400">Аварии</span>
                                </div>
                            </Link>

                            <Link :href="route('matrix.diagrams', item.public_id)">
                                <div class="h-full flex flex-col gap-2 items-center justify-center bg-gray-100 rounded-lg
                                    hover:bg-opacity-70 dark:hover:bg-opacity-70 dark:bg-gray-900"
                                >
                                    <div class="h-12 w-12 flex items-center justify-center bg-gray-200 dark:bg-gray-800 rounded-md">
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

                <DetailParams v-if="paginationSource === 'Параметры'" @created="() => { paginationSource = 'Заявки' }"
                              :item="item">
                    <div class="flex items-center bg-gray-100 dark:bg-gray-900 rounded-lg p-1 gap-2">
                        <div v-for="(item, index) in paginationSourceTypes"
                             :key="index"
                             class="flex items-center gap-2"
                             @click="paginationSource = item">
                                <span
                                    class="p-2 cursor-pointer rounded-lg text-gray-400 dark:text-gray-600 font-semibold text-[12px]"
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
                </DetailParams>

                <DetailDinamograms v-if="paginationSource === 'Динамограммы'"
                                   @select-dnmh="handleSelectDnmh"
                                   @select-dnm="handleSelectDnm"
                                   :item="item">
                    <template class="flex items-center gap-2">
                        <div class="flex items-center bg-gray-100 dark:bg-gray-900 rounded-lg p-1 gap-2">
                            <div v-for="(item, index) in paginationSourceTypes"
                                 :key="index"
                                 class="flex items-center gap-2"
                                 @click="paginationSource = item">
                                <span
                                    class="p-2 cursor-pointer rounded-lg text-gray-400 dark:text-gray-600 font-semibold text-[12px]"
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

                <DetailUserClaims
                    v-if="paginationSource === 'Заявки' && currentClaimType === 'Мои'"
                    :item="item">
                    <template #claims-switcher>
                        <div class="flex items-center gap-3">
                            <div v-for="(claimType, index) in claimTypes"
                                 :key="index"
                                 class="flex items-center gap-2"
                            >
                                <input
                                    :checked="currentClaimType === claimType"
                                    v-model="currentClaimType"
                                    :id="`claim-type-${index}`"
                                    type="radio"
                                    :value="claimType"
                                    class="ring-0 focus:ring-0 text-green-500 dark:bg-gray-800 dark:border-gray-700 bg-gray-100 border-gray-300"/>
                                <label
                                    :for="`claim-type-${index}`"
                                    class="font-semibold text-[13px] text-gray-800 dark:text-gray-400"
                                >{{ claimType }}</label>
                            </div>
                        </div>
                    </template>
                    <div class="flex items-center bg-gray-100 dark:bg-gray-900 rounded-lg p-1 gap-2">
                        <div v-for="(item, index) in paginationSourceTypes"
                             :key="index"
                             class="flex items-center gap-2"
                             @click="paginationSource = item">
                                <span
                                    class="p-2 cursor-pointer rounded-lg text-gray-400 dark:text-gray-600 font-semibold text-[12px]"
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
                </DetailUserClaims>

                <DetailWellClaims
                    v-if="paginationSource === 'Заявки' && currentClaimType === 'История'"
                    :item="item">
                    <template #claims-switcher>
                        <div class="flex items-center gap-3">
                            <div v-for="(claimType, index) in claimTypes"
                                 :key="index"
                                 class="flex items-center gap-2"
                            >
                                <input
                                    :checked="currentClaimType === claimType"
                                    v-model="currentClaimType"
                                    :id="`claim-type-${index}`"
                                    type="radio"
                                    :value="claimType"
                                    class="ring-0 focus:ring-0 text-green-500 dark:bg-gray-800 dark:border-gray-700 bg-gray-100 border-gray-300"/>
                                <label
                                    :for="`claim-type-${index}`"
                                    class="font-semibold text-[13px] text-gray-800 dark:text-gray-400"
                                >{{ claimType }}</label>
                            </div>
                        </div>
                    </template>
                    <div class="flex items-center bg-gray-100 dark:bg-gray-900 rounded-lg p-1 gap-2">
                        <div v-for="(item, index) in paginationSourceTypes"
                             :key="index"
                             class="flex items-center gap-2"
                             @click="paginationSource = item">
                                <span
                                    class="p-2 cursor-pointer rounded-lg text-gray-400 dark:text-gray-600 font-semibold text-[12px]"
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
                </DetailWellClaims>

                <DetailClaimsUntracked v-if="paginationSource === 'Заявки' && currentClaimType === 'Утверждение'"
                                       :item="item">
                    <template #claims-switcher>
                        <div class="flex items-center gap-3">
                            <div v-for="(claimType, index) in claimTypes"
                                 :key="index"
                                 class="flex items-center gap-2"
                            >
                                <input
                                    :checked="currentClaimType === claimType"
                                    v-model="currentClaimType"
                                    :id="`claim-type-${index}`"
                                    type="radio"
                                    :value="claimType"
                                    class="ring-0 focus:ring-0 text-green-500 dark:bg-gray-800 dark:border-gray-700 bg-gray-100 border-gray-300"/>
                                <label
                                    :for="`claim-type-${index}`"
                                    class="font-semibold text-[13px] text-gray-800 dark:text-gray-400"
                                >{{ claimType }}</label>
                            </div>
                        </div>
                    </template>
                    <div class="flex items-center bg-gray-100 dark:bg-gray-900 rounded-lg p-1 gap-2">
                        <div v-for="(item, index) in paginationSourceTypes"
                             :key="index"
                             class="flex items-center gap-2"
                             @click="paginationSource = item">
                                <span
                                    class="p-2 cursor-pointer rounded-lg text-gray-400 dark:text-gray-600 font-semibold text-[12px]"
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
                </DetailClaimsUntracked>

            </div>
        </div>
    </AuthorizedLayout>
</template>

