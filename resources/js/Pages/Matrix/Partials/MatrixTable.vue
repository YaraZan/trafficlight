<script setup>
import ARDCell from '@/Components/ARDCell.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Array,
        required: true
    },
    params: {
        type: Array,
        required: true
    }
});

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
    <table class="w-full" striped>
            <thead>
                <tr class="border-y border-gray-200">
                    <th scope="col" class="bg-gray-50 items-center px-6 py-4 text-left border-gray-200 border-l" v-for="param in params">
                        <span class="text font-semibold text-gray-800">{{ param }}</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in data" :key="index"  class="hover:bg-gray-50 border-b border-gray-200 cursor-pointer">
                    <td scope="row" class="px-6 py-4 text-center items-center">
                        <div :class="row.Connect ? 'bg-green-100' : 'bg-gray-200'" class="w-5 h-5 rounded-full z-1 flex items-center justify-center cursor-pointer" data-tooltip-target="operation-connect-tooltip" data-tooltip-placement="bottom">
                            <div :class="row.Connect ? 'bg-green-300' : 'bg-gray-400'" class="w-1/2 h-1/2 rounded-full z-2"></div>
                        </div >
                    </td>
                    <td class="font-bold px-6 py-4 text-left border-l border-gray-200">{{ extractNgdu(row.WellName) }}</td>
                    <td class="px-6 py-4 text-left border-l border-gray-200">{{ extractNumericPart(row.ShopName) }}</td>
                    <td class="px-6 py-4 text-left border-l border-gray-200">{{ extractWellNumber(row.WellName) }}</td>
                    <td class="px-6 py-4 text-left border-l border-gray-200">{{ row.WellState }}</td>
                    <td class="px-6 py-4 text-left border-l border-gray-200">{{ row.Date }}</td>
                    <td class="px-6 py-4 text-left border-l border-gray-200">{{ row.SumErr }}</td>
                    <td class="px-6 py-4 text-left border-l border-gray-200">
                        <span v-if="row.Ask" class="py-1 px-2 bg-green-100 text-green-600 rounded-3xl">Выполнен</span>
                        <span v-else class="py-1 px-2 bg-red-100 text-red-600 rounded-3xl">Нет</span>
                    </td>
                    <ARDCell :alarm="row.Alarm1" :setting="row.Ref1" :diff="row.Dif1" :stat="row.Stat1"></ARDCell>
                    <ARDCell :alarm="row.Alarm2" :setting="row.Ref2" :diff="row.Dif2" :stat="row.Stat2"></ARDCell>
                    <ARDCell :alarm="row.Alarm3" :setting="row.Ref3" :diff="row.Dif3" :stat="row.Stat3"></ARDCell>
                    <ARDCell :alarm="row.Alarm4" :setting="row.Ref4" :diff="row.Dif4" :stat="row.Stat4"></ARDCell>
                    <ARDCell :alarm="row.Alarm6" :setting="row.Ref6" :diff="row.Dif6" :stat="row.Stat6"></ARDCell>
                    <ARDCell :alarm="row.Alarm7" :setting="row.Ref7" :diff="row.Dif7" :stat="row.Stat7"></ARDCell>
                    <ARDCell :alarm="row.Alarm8" :setting="row.Ref8" :diff="row.Dif8" :stat="row.Stat8"></ARDCell>
                    <ARDCell :alarm="row.Alarm11" :setting="row.Ref11" :diff="row.Dif11" :stat="row.Stat11"></ARDCell>
                    <ARDCell :alarm="row.Alarm12" :setting="row.Ref12" :diff="row.Dif12" :stat="row.Stat12"></ARDCell>
                </tr>
            </tbody>
        </Table>   
</template>

