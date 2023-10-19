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
                <span class="text font-semibold text-gray-800">Связь</span>
            </table-head-cell>
            <table-head-cell class="bg-gray-50 text-left">
                <span class="text font-semibold text-gray-800">Интервал</span>
            </table-head-cell>
        </table-head>
        <table-body>
            <table-row v-for="(row, index) in data" :key="index" class="border-b border-gray-200">
                <table-cell class="font-bold">{{ row.Date }}</table-cell>
                <table-cell>
                    <table-cell>
                        <span v-if="row.Quality" class="py-1 px-2 bg-green-100 text-green-600 rounded-3xl">Установлена</span>
                        <span v-else class="py-1 px-2 bg-red-100 text-red-600 rounded-3xl">Потеряна</span>
                    </table-cell>
                </table-cell>
                <table-cell>{{ row.AskLong }}</table-cell>
            </table-row>
        </table-body>
    </Table>   
</template>