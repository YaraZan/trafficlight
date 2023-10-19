<script setup>
import { Table, TableHead, TableBody, TableHeadCell, TableRow, TableCell } from 'flowbite-vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Array,
        required: true
    }
});
</script>

<template>
     <Table striped>
        <table-head>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Категория</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Уставка А</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Значение А</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Отклонение А, %</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Ранг А</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Уставка B</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Значение B</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Отклонение B, %</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Ранг B</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Уставка C</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Значение C</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Отклонение C, %</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Ранг C</span>
            </table-head-cell>
        </table-head>
        <table-body>
            <table-row v-for="(row, index) in data" :key="index" class="border-b border-gray-200">
                <table-cell class="font-bold">{{ row.CatName }}</table-cell>
                <table-cell>{{ row.Ref1 }}</table-cell>
                <table-cell>{{ row.Cur1 }}</table-cell>
                <table-cell>{{ row.Res1 }}</table-cell>
                <table-cell>{{ row.Err1 }}</table-cell>
                <table-cell>{{ row.Ref2 }}</table-cell>
                <table-cell>{{ row.Cur2 }}</table-cell>
                <table-cell>{{ row.Res2 }}</table-cell>
                <table-cell>{{ row.Err2 }}</table-cell>
                <table-cell>{{ row.Ref3 }}</table-cell>
                <table-cell>{{ row.Cur3 }}</table-cell>
                <table-cell>{{ row.Res3 }}</table-cell>
                <table-cell>{{ row.Err3 }}</table-cell>
            </table-row>
        </table-body>
    </Table>   
</template>