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
        <tr class="border-y bg-gray-50 border-gray-200 dark:bg-gray-900 dark:bg-opacity-40 dark:border-gray-700">
            <th scope="col" class="px-6 py-4 text-left">
                <span class="text font-semibold text-gray-800 dark:text-gray-300">Дата</span>
            </th>
            <th scope="col" class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700">
                <span class="text font-semibold text-gray-800 dark:text-gray-300">Ранг</span>
            </th>
            <th scope="col" class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700">
                <span class="text font-semibold text-gray-800 dark:text-gray-300">Дебит</span>
            </th>
            <th scope="col" class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700">
                <span class="text font-semibold text-gray-800 dark:text-gray-300">Действие</span>
            </th>
        </tr> 
        <tbody>
            <tr v-for="(row, index) in data" :key="index" class="border-b border-gray-200 dark:border-gray-700">
                <th scope="row" class="font-normal text-gray-800 dark:text-gray-400 px-6 py-4 text-left">{{ row.Date }}</th>
                <td class="px-6 py-4 text-left border-l border-gray-200 text-gray-800 dark:text-gray-400 dark:border-gray-700">{{ row.SumErr }}</td>
                <td class="px-6 py-4 text-left border-l border-gray-200 text-gray-800 dark:text-gray-400 dark:border-gray-700">{{ row.Debit }}</td>
                <td class="px-4 py-2 text-left border-l border-gray-200 text-gray-800 dark:text-gray-400 dark:border-gray-700">
                    <Link :href="route('matrix.hourarch.detail', { well_uuid: item.public_id, head_hour_uuid: row.public_id})">
                        <span class="text font-semibold text-green-500 px-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">Просмотр</span>
                    </Link>
                </td>
            </tr>
        </tbody>
    </table>   
</template>