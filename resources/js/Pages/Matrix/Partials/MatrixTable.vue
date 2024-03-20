<script setup>
import ARDCell from '@/Components/ARDCell.vue';
import ErrorIcon from '@/Components/Icons/ErrorIcon.vue';
import DoneIcon from '@/Components/Icons/DoneIcon.vue';
import WebwisuIcon from '@/Components/Icons/WebwisuIcon.vue';
import { router } from '@inertiajs/vue3';
import {A} from "flowbite-vue";
import TableHeadSortIcon from "@/Components/Icons/TableHeadSortIcon.vue";
import {value} from "lodash/seq.js";

const props = defineProps({
    data: {
        type: Array,
        required: true
    }
});



const params = ['Связь','НГДУ', 'Цех', 'Скважина', 'Состояние', 'Дата', 'Штраф', 'Опрос',
 'Число качаний, об/мин', 'Нагрузка максимальная, кг',
 'Нагрузка минимальная, кг', 'Температура масла в ГБ, °С', 'Давление в ГН , МПа',
 'Давление в ГЦ , МПа', 'Давление в ПГА, МПа', 'Ток, А', 'Напряжение, В'];

const extractWellNumber = (string) => {
  const elements = string.split('-');
  return elements[elements.length - 1];
};

const extractNgdu = (string) => {
  const elements = string.split('-');
  return elements[elements.length - 3];
};

function extractNumericPart(data) {
  const match = data.match(/\d+/);
  return match ? match[0] : null;
}

function normalizeDate(dateSting) {
    const newDate = new Date(dateSting);

    return newDate.toLocaleDateString() + ' ' + newDate.getHours() + ':' + (newDate.getMinutes() === 0 ? '00' : newDate.getMinutes());
}

const emit = defineEmits(['sortByDate', 'sortByState', 'sortByShop', 'sortByNgdu', 'sortByNumber', 'sortByQn'])
</script>

<template>
    <table id="exportMatrix" class="w-full border-separate border-spacing-0">
        <thead class="sticky top-0 z-[5] after:bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
            <tr class="border bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700">
                <th rowspan="2" class="items-center px-3 py-1 text-left border-gray-200 dark:border-gray-700">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Связь</span>
                </th>
                <th rowspan="2" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Опрос</span>
                </th>
                <th rowspan="2" class="items-center px-3 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Обзор</span>
                </th>
                <th rowspan="2" class="items-center px-3 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <div class="flex gap-4 items-center justify-between w-full">
                        <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">НГДУ</span>
                        <TableHeadSortIcon
                            @click="emit('sortByNgdu')"
                            class="cursor-pointer"  />
                    </div>
                </th>
                <th rowspan="2" class="items-center px-3 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <div class="flex gap-4 items-center justify-between w-full">
                        <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Цех</span>
                        <TableHeadSortIcon
                            @click="emit('sortByShop')"
                            class="cursor-pointer"  />
                    </div>
                </th>
                <th rowspan="2" class="items-center px-3 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <div class="flex gap-4 items-center justify-between w-full">
                        <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Скважина</span>
                        <TableHeadSortIcon
                            @click="emit('sortByNumber')"
                            class="cursor-pointer"  />
                    </div>
                </th>
                <th rowspan="2" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l">
                    <div class="flex gap-4 items-center justify-between w-full">
                        <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Qн факт</span>
                        <TableHeadSortIcon
                            @click="emit('sortByQn')"
                            class="cursor-pointer"  />
                    </div>
                </th>
                <th rowspan="2" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l">
                    <div class="flex gap-4 items-center justify-between w-full">
                        <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Потери</span>
                        <TableHeadSortIcon
                            @click="emit('sortByQnLost')"
                            class="cursor-pointer"  />
                    </div>
                </th>
                <th rowspan="2" class="items-center px-3 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <div class="flex gap-4 items-center justify-between w-full">
                        <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Состояние</span>
                        <TableHeadSortIcon
                            @click="emit('sortByState')"
                            class="cursor-pointer"  />
                    </div>
                </th>
                <th rowspan="2" class="items-center px-3 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <div class="flex gap-4 items-center justify-between w-full">
                        <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Дата</span>
                        <TableHeadSortIcon
                            @click="emit('sortByDate')"
                            class="cursor-pointer"  />
                    </div>
                </th>
                <th colspan="4" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Число качаний, об/мин</span>
                </th>
                <th colspan="3" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Длина хода</span>
                </th>
                <th colspan="3" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Нагрузка максимальная, кг</span>
                </th>
                <th colspan="3" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Нагрузка минимальная, кг</span>
                </th>
                <th colspan="3" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Температура масла в ГБ, °С</span>
                </th>
                <th colspan="3" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Давление в ГН , МПа</span>
                </th>
                <th colspan="3" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Давление в ГЦ , МПа</span>
                </th>
                <th colspan="3" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Давление в ПГА, МПа</span>
                </th>
                <th colspan="3" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Ток, А</span>
                </th>
                <th colspan="3" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Напряжение, В</span>
                </th>
                <th rowspan="2" class="items-center px-3 py-1 text-center border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Штраф</span>
                </th>
            </tr>
            <tr class="border-y bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700">
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">АРМИТС</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">АРМИТС</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text-[13px] font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
            </tr>
        </thead>
        <tbody class="h-full overflow-y-auto">
            <tr v-for="(row, index) in data" :key="index"
                class="hover:bg-gray-50 dark:hover:bg-gray-900 dark:hover:bg-opacity-40 border-b border-gray-200 dark:border-gray-700"
             >
                <th scope="row" class="relative px-4 py-2" :class="{ 'border-l border-red-500' : !row.Connect }">
                    <span v-if="row.Connect" class="text-[13px] font-semibold text-green-400">Есть</span>
                    <span v-else class="text-[13px] font-semibold text-red-500 dark:text-red-500">Нет</span>

                    <a v-if="row.Web !== '#' && row.Web !== null" target="_blank" :href="row.Web"
                       class="absolute flex flex-col items-end p-1 cursor-pointer top-0 right-0 bottom-0 left-0">
                        <WebwisuIcon />
                    </a>
                </th>

                <td class="px-4 py-2 text-center border-l border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-400">
                    <span class="flex items-center justify-center">
                        <DoneIcon class="w-4 h-4" v-if="row.Ask" />
                        <ErrorIcon class="w-4 h-4" v-else />
                    </span>
                </td>

                <td class="relative text-center border-l border-gray-200 dark:border-gray-700">
                    <a :href="`/matrix/${row.public_id}`"
                       target="_blank"
                       class="group before:absolute before:w-full before:h-full flex items-center justify-center"
                    >
                        <svg class="w-4 h-4 stroke-gray-400 group-hover:stroke-green-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 17L17 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M7 7H17V17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </td>

                <td class="font-semibold text-[13px] px-3 py-1 text-center border-l border-gray-200 dark:border-gray-700">
                    <span :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-400 dark:text-gray-600'"
                    >{{ extractNgdu(row.WellName) }}</span>
                </td>
                <td :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-300 dark:text-gray-600'"
                    class="font-semibold text-[13px] px-3 py-1 text-center border-l border-gray-200 dark:border-gray-700"
                    >{{ extractNumericPart(row.ShopName) }}</td>
                <td :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-300 dark:text-gray-600'"
                    class="font-semibold text-[13px] px-3 py-1 text-center border-l border-gray-200 dark:border-gray-700"
                    >{{ extractWellNumber(row.WellName) }}</td>
                <td :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-300 dark:text-gray-600'"
                    class="font-semibold text-[12px] px-3 py-1 text-left border-l border-gray-200 dark:border-gray-700"
                >{{ row.QnFak ? row.QnFak : 'Пусто' }}</td>
                <td :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-300 dark:text-gray-600'"
                    class="font-semibold text-[12px] px-3 py-1 text-left border-l border-gray-200 dark:border-gray-700"
                >{{ row.QnLost ? row.QnLost : 'Пусто' }}</td>
                <td :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-300 dark:text-gray-600'"
                    class="font-semibold text-[13px] px-3 py-1 text-left border-l border-gray-200 dark:border-gray-700"
                    >{{ row.WellState ? row.WellState : 'Пусто' }}</td>
                <td :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-300 dark:text-gray-600'"
                    class="font-semibold text-[12px] px-3 py-1 text-left border-l border-gray-200 dark:border-gray-700"
                    >{{ row.Date ? normalizeDate(row.Date) : 'Пусто' }}</td>
                <ARDCell :isConnected="row.Connect" :withArmits="true" :arm="row.Arm1" :setting="row.Ref1" :alarm="row.Alarm1" :diff="row.Dif1" :stat="row.Stat1"></ARDCell>
                <ARDCell :isConnected="row.Connect" :withSetpoint="false" :withArmits="true" :arm="row.Arm10" :setting="row.Ref10" :alarm="row.Alarm10" :diff="row.Dif10" :stat="row.Stat10"></ARDCell>

                <ARDCell :isConnected="row.Connect" :setting="row.Ref2" :alarm="row.Alarm2" :diff="row.Dif2" :stat="row.Stat2"></ARDCell>
                <ARDCell :isConnected="row.Connect" :setting="row.Ref3" :alarm="row.Alarm3" :diff="row.Dif3" :stat="row.Stat3"></ARDCell>
                <ARDCell :isConnected="row.Connect" :setting="row.Ref4" :alarm="row.Alarm4" :diff="row.Dif4" :stat="row.Stat4"></ARDCell>
                <ARDCell :isConnected="row.Connect" :setting="row.Ref6" :alarm="row.Alarm6" :diff="row.Dif6" :stat="row.Stat6"></ARDCell>
                <ARDCell :isConnected="row.Connect" :setting="row.Ref7" :alarm="row.Alarm7" :diff="row.Dif7" :stat="row.Stat7"></ARDCell>
                <ARDCell :isConnected="row.Connect" :setting="row.Ref8" :alarm="row.Alarm8" :diff="row.Dif8" :stat="row.Stat8"></ARDCell>
                <ARDCell :isConnected="row.Connect" :setting="row.Ref11" :alarm="row.Alarm11" :diff="row.Dif11" :stat="row.Stat11"></ARDCell>
                <ARDCell :isConnected="row.Connect" :setting="row.Ref12" :alarm="row.Alarm12" :diff="row.Dif12" :stat="row.Stat12"></ARDCell>
                <td :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-300 dark:text-gray-600'" class="px-4 py-2 text-center border-l border-gray-200 dark:border-gray-700">
                    {{ row.SumErr ? row.SumErr : 'Пусто' }}
                </td>
            </tr>
        </tbody>
    </table>
</template>

