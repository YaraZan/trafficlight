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
import DetailNavigationTabMenu from '../DetailNavigationTabMenu.vue';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    }
});

const tabs = ref(['Категории', 'Динамограммы']);
const currentTab = ref('Категории');

function changeTab(tab) {
    currentTab.value = tab;
}

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

                    <div class="w-2/4 h-[400px] flex flex-col gap-5 ">
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
                                        <AlarmIcon/>
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
                        </div>
                    </div>
                </div>

                <DetailNavigationTabMenu :pagination-source-types="tabs" :current-source-type="currentTab" @select="changeTab" />

            </div>


        </div>
    </AuthorizedLayout>
</template>

