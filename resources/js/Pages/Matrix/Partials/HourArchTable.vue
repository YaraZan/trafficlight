<script setup>
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
     <table class="w-full" striped>
        <tr class="border-y border-gray-200">
            <th scope="col" class="bg-gray-50 px-6 py-4 text-left">
                <span class="text font-semibold text-gray-800">Дата</span>
            </th>
            <th scope="col" class="bg-gray-50 px-6 py-4 text-left border-l border-gray-200">
                <span class="text font-semibold text-gray-800">Ранг</span>
            </th>
            <th scope="col" class="bg-gray-50 px-6 py-4 text-left border-l border-gray-200">
                <span class="text font-semibold text-gray-800">Дебит</span>
            </th>
            <th scope="col" class="bg-gray-50 px-6 py-4 text-left border-l border-gray-200">
                <span class="text font-semibold text-gray-800">Действие</span>
            </th>
        </tr> 
        <tbody>
            <tr v-for="(row, index) in data" :key="index" class="border-b border-gray-200">
                <th scope="row" class="font-bold px-6 py-4 text-left text-gray-400">{{ row.Date }}</th>
                <td class="px-6 py-4 text-left border-l border-gray-200">{{ row.SumErr }}</td>
                <td class="px-6 py-4 text-left border-l border-gray-200">{{ row.Debit }}</td>
                <td class="px-6 py-4 text-left border-l border-gray-200">
                    <Link :href="route('matrix.hourarch.detail', { well_uuid: item.public_id, head_hour_uuid: row.public_id})">
                        <span class="text font-semibold text-green-500">Просмотр</span>
                    </Link>
                </td>
            </tr>
        </tbody>
    </table>   
</template>