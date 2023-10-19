<script setup>
import { Table, TableHead, TableBody, TableHeadCell, TableRow, TableCell } from 'flowbite-vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Array,
        required: true
    },
    item: {
        type: Object,
        required: true,
    }
});
</script>

<template>
     <Table striped>
        <table-head>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Дата</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Ранг</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Дебит</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Действие</span>
            </table-head-cell>
        </table-head>
        <table-body>
            <table-row v-for="(row, index) in data" :key="index" class="border-b border-gray-200">
                <table-cell class="font-bold">{{ row.Date }}</table-cell>
                <table-cell>{{ row.SumErr }}</table-cell>
                <table-cell>{{ row.Debit }}</table-cell>
                <table-cell>
                    <Link :href="route('operations.hourarch.detail', { operation_uuid: item.public_id, head_hour_uuid: row.public_id})">
                        <span class="text font-semibold text-green-500">Просмотр</span>
                    </Link>
                </table-cell>
            </table-row>
        </table-body>
    </Table>   
</template>