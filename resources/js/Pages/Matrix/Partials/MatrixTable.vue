<script setup>
import ARDCell from '@/Components/ARDCell.vue';
import ErrorIcon from '@/Components/Icons/ErrorIcon.vue';
import DoneIcon from '@/Components/Icons/DoneIcon.vue';
import WebwisuIcon from '@/Components/Icons/WebwisuIcon.vue';
import { Link, router } from '@inertiajs/vue3';
import WebwisuConnLostIcon from '@/Components/Icons/WebwisuConnLostIcon.vue';

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
</script>

<template>
    <table id="exportMatrix" class="w-full">
        <thead class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 border-spacing-0 sticky z-[5] top-0">
            <tr class="border bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700">
                <th rowspan="2" class="items-center px-4 py-1 text-left">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Связь</span>
                </th>
                <th rowspan="2" class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">НГДУ</span>
                </th>
                <th rowspan="2" class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Цех</span>
                </th>
                <th rowspan="2" class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Скважина</span>
                </th>
                <th rowspan="2" class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Состояние</span>
                </th>
                <th rowspan="2" class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Дата</span>
                </th>
                <th rowspan="2" class="items-center px-4 py-1 text-center border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Штраф</span>
                </th>
                <th rowspan="2" class="items-center px-4 py-1 text-center border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Опрос</span>
                </th>
                <th colspan="4" class="items-center px-4 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Число качаний, об/мин</span>
                </th>
                <th colspan="4" class="items-center px-4 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Нагрузка максимальная, кг</span>
                </th>
                <th colspan="4" class="items-center px-4 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Нагрузка минимальная, кг</span>
                </th>
                <th colspan="4" class="items-center px-4 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Температура масла в ГБ, °С</span>
                </th>
                <th colspan="4" class="items-center px-4 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Давление в ГН , МПа</span>
                </th>
                <th colspan="4" class="items-center px-4 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Давление в ГЦ , МПа</span>
                </th>
                <th colspan="4" class="items-center px-4 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Давление в ПГА, МПа</span>
                </th>
                <th colspan="4" class="items-center px-4 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Ток, А</span>
                </th>
                <th colspan="4" class="items-center px-4 py-1 text-center border-gray-200 dark:border-gray-700 border-l border-b">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Напряжение, В</span>
                </th>
            </tr>
            <tr class="border-y bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700">
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">АРМИТС</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">АРМИТС</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">АРМИТС</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">АРМИТС</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">АРМИТС</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">АРМИТС</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">АРМИТС</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">АРМИТС</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">АРМИТС</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Уставка</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Факт</span>
                </th>
                <th class="items-center px-4 py-1 text-left border-gray-200 dark:border-gray-700 border-l">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Отклонение</span>
                </th>
            </tr>
        </thead>
        <tbody class="h-[800px] overflow-y-auto">
            <tr v-for="(row, index) in data" :key="index"
                class="hover:bg-gray-50 dark:hover:bg-gray-900 dark:hover:bg-opacity-40 border-b border-gray-200 dark:border-gray-700 cursor-pointer"
                v-on:dblclick="router.get(`/matrix/${row.public_id}`)"
             >
                <th scope="row" class="relative px-4 py-2" :class="{ 'border-l border-red-500' : !row.Connect }">
                    <span v-if="row.Connect" class="text-[16px] font-semibold text-green-400">Есть</span>
                    <span v-else class="text-[16px] font-semibold text-red-500 dark:text-red-500">Нет</span>

                    <a v-if="row.Web !== '#' && row.Web !== null" target="_blank" :href="row.Web"
                       class="absolute flex flex-col items-end p-1 cursor-pointer top-0 right-0 bottom-0 left-0">
                        <WebwisuIcon />
                    </a>
                </th>

                <td class="font-bold px-4 py-2 text-center border-l border-gray-200 dark:border-gray-700">
                    <span :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-400 dark:text-gray-600'">{{ extractNgdu(row.WellName) }}</span>
                </td>
                <td :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-400 dark:text-gray-600'" class="px-4 py-2 text-center border-l border-gray-200 dark:border-gray-700">{{ extractNumericPart(row.ShopName) }}</td>
                <td :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-400 dark:text-gray-600'" class="px-4 py-2 text-center border-l border-gray-200 dark:border-gray-700">{{ extractWellNumber(row.WellName) }}</td>
                <td :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-400 dark:text-gray-600'" class="px-4 py-2 text-left border-l border-gray-200 dark:border-gray-700">{{ row.WellState }}</td>
                <td :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-400 dark:text-gray-600'" class="px-4 py-2 text-left border-l border-gray-200 dark:border-gray-700">{{ row.Date }}</td>
                <td :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-400 dark:text-gray-600'" class="px-4 py-2 text-center border-l border-gray-200 dark:border-gray-700">{{ row.SumErr ? row.SumErr : '-' }}</td>
                <td class="px-4 py-2 text-center border-l border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-400">
                    <span class="flex items-center justify-center">
                        <DoneIcon v-if="row.Ask" />
                        <ErrorIcon v-else />
                    </span>
                </td>
                <ARDCell :alarm="row.Alarm1" :arm="row.Arm1" :setting="row.Ref1" :diff="row.Dif1" :stat="row.Stat1"></ARDCell>
                <ARDCell :alarm="row.Alarm2" :arm="row.Arm2" :setting="row.Ref2" :diff="row.Dif2" :stat="row.Stat2"></ARDCell>
                <ARDCell :alarm="row.Alarm3" :arm="row.Arm3" :setting="row.Ref3" :diff="row.Dif3" :stat="row.Stat3"></ARDCell>
                <ARDCell :alarm="row.Alarm4" :arm="row.Arm4" :setting="row.Ref4" :diff="row.Dif4" :stat="row.Stat4"></ARDCell>
                <ARDCell :alarm="row.Alarm6" :arm="row.Arm5" :setting="row.Ref6" :diff="row.Dif6" :stat="row.Stat6"></ARDCell>
                <ARDCell :alarm="row.Alarm7" :arm="row.Arm6" :setting="row.Ref7" :diff="row.Dif7" :stat="row.Stat7"></ARDCell>
                <ARDCell :alarm="row.Alarm8" :arm="row.Arm7" :setting="row.Ref8" :diff="row.Dif8" :stat="row.Stat8"></ARDCell>
                <ARDCell :alarm="row.Alarm11" :arm="row.Arm8" :setting="row.Ref11" :diff="row.Dif11" :stat="row.Stat11"></ARDCell>
                <ARDCell :alarm="row.Alarm12" :arm="row.Arm9" :setting="row.Ref12" :diff="row.Dif12" :stat="row.Stat12"></ARDCell>
            </tr>
        </tbody>
    </Table>
</template>
