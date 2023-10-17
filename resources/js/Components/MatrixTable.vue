<script setup>
import { Table, TableHead, TableBody, TableHeadCell, TableRow, TableCell } from 'flowbite-vue';
import ARDCell from '@/Components/ARDCell.vue';

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
</script>

<template>
    <Table striped>
            <table-head>
                <table-head-cell class="bg-gray-50 items-start" v-for="param in params">
                    <span class="text font-semibold text-gray-800"></span>{{ param }}
                </table-head-cell>
            </table-head>
            <table-body>
                <table-row v-for="row in data" :key="row.id" class="border-b border-gray-200">
                    <table-cell class="font-bold">{{ row.WellName }}</table-cell>
                    <table-cell>{{ row.WellState }}</table-cell>
                    <table-cell>{{ row.Date }}</table-cell>
                    <table-cell>{{ row.SumErr }}</table-cell>
                    <table-cell>
                        <span v-if="row.Ask" class="py-1 px-2 bg-green-100 text-green-600 rounded-3xl border border-green-600">Выполнен</span>
                        <span v-else class="py-1 px-2 bg-red-100 text-red-600 rounded-3xl border border-red-600">Нет</span>
                    </table-cell>
                    <table-cell>
                        <span v-if="row.Connect" class="py-1 px-2 bg-green-100 text-green-600 rounded-3xl border border-green-600">Установлена</span>
                        <span v-else class="py-1 px-2 bg-red-100 text-red-600 rounded-3xl border border-red-600">Потеряна</span>
                    </table-cell>
                    <ARDCell :alarm="row.Alarm1" :setting="row.Ref1" :diff="row.Dif1" :stat="row.Stat1"></ARDCell>
                    <ARDCell :alarm="row.Alarm2" :setting="row.Ref2" :diff="row.Dif2" :stat="row.Stat2"></ARDCell>
                    <ARDCell :alarm="row.Alarm3" :setting="row.Ref3" :diff="row.Dif3" :stat="row.Stat3"></ARDCell>
                    <ARDCell :alarm="row.Alarm4" :setting="row.Ref4" :diff="row.Dif4" :stat="row.Stat4"></ARDCell>
                    <ARDCell :alarm="row.Alarm6" :setting="row.Ref6" :diff="row.Dif6" :stat="row.Stat6"></ARDCell>
                    <ARDCell :alarm="row.Alarm7" :setting="row.Ref7" :diff="row.Dif7" :stat="row.Stat7"></ARDCell>
                    <ARDCell :alarm="row.Alarm8" :setting="row.Ref8" :diff="row.Dif8" :stat="row.Stat8"></ARDCell>
                    <ARDCell :alarm="row.Alarm11" :setting="row.Ref11" :diff="row.Dif11" :stat="row.Stat11"></ARDCell>
                    <ARDCell :alarm="row.Alarm12" :setting="row.Ref12" :diff="row.Dif12" :stat="row.Stat12"></ARDCell>
                </table-row>
            </table-body>
        </Table>   
</template>

