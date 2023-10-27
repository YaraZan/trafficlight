<script setup>
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import HourArchIcon from '@/Components/Icons/HourArchIcon.vue';
import AskStatsIcon from '@/Components/Icons/AskStatsIcon.vue';
import AlarmIcon from '@/Components/Icons/AlarmIcon.vue';
import DiagramsIcon from '@/Components/Icons/DiagramsIcon.vue';
import { Link, Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    }
});

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

            <div class="flex p-10 gap-5 w-1/2">

                <div class="flex flex-col gap-10">

                    <div class="flex gap-5 items-center">
                        <div :class="item.Connect ? 'bg-green-100' : 'bg-gray-200'" class="w-5 h-5 rounded-full z-1 flex items-center justify-center cursor-pointer" data-tooltip-target="operation-connect-tooltip" data-tooltip-placement="bottom">
                            <div :class="item.Connect ? 'bg-green-300' : 'bg-gray-400'" class="w-1/2 h-1/2 rounded-full z-2"></div>
                        </div >
                        <span class="font-bold text-gray-800 text-lg">{{ item.Name }}</span>
                    </div>

                    <div class="flex border border-gray-200 items-center rounded-xl">
                        <div class="flex flex-col gap-2 p-5 border-r border-gray-200">
                            <span class="text-sm text-gray-500">Название</span>
                            <span class="text-lg font-semibold text-gray-800">{{ item.Name }}</span>
                        </div>
                        <div class="flex flex-col gap-2 p-5 border-r border-gray-200">
                            <span class="text-sm text-gray-500">ПЛК</span>
                            <span class="text-lg font-semibold text-gray-800">{{ item.PlcName }}</span>
                        </div>
                        <div class="flex flex-col gap-2 p-5 border-r border-gray-200">
                            <span class="text-sm text-gray-500">НГДУ</span>
                            <span class="text-lg font-semibold text-gray-800">{{ item.NgduName }}</span>
                        </div>
                        <div class="flex flex-col gap-2 p-5 border- border-gray-200">
                            <span class="text-sm text-gray-500">Цех</span>
                            <span class="text-lg font-semibold text-gray-800">{{ item.ShopName }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <Link :href="route('matrix.hourarch', item.public_id)">
                            <div class="p-6 flex gap-5 bg-white rounded-lg shadow border border-gray-200 items-center hover:bg-gray-100 cursor-pointer">
                                <HourArchIcon />
                                <span class="text-sm font-semibold text-gray-800">Часовые архивы</span>
                            </div>
                        </Link>
                        <Link :href="route('matrix.askstats', item.public_id)">
                            <div class="p-6 flex gap-5 bg-white rounded-lg shadow border border-gray-200 items-center hover:bg-gray-100 cursor-pointer">
                                <AskStatsIcon />
                                <span class="text-sm font-semibold text-gray-800">Статистика опроса</span>
                            </div>
                        </Link>
                        <div class="p-6 flex gap-5 bg-white rounded-lg shadow border border-gray-200 items-center hover:bg-gray-100 cursor-pointer">
                            <AlarmIcon />
                            <span class="text-sm font-semibold text-gray-800">Аварии</span>
                        </div>
                        <div class="p-6 flex gap-5 bg-white rounded-lg shadow border border-gray-200 items-center hover:bg-gray-100 cursor-pointer">
                            <DiagramsIcon />
                            <span class="text-sm font-semibold text-gray-800">Диаграммы</span>
                        </div>
                    </div>

                </div>
                

            </div>
        </div>
    </AuthorizedLayout>
</template>