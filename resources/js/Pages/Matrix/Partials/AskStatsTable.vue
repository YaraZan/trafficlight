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
        <thead>
            <tr class="border-y bg-gray-50 dark:bg-gray-900 dark:bg-opacity-40 border-gray-200 dark:border-gray-700">
                <th scope="col" class="px-6 py-4 text-left">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Дата</span>
                </th>
                <th scope="col" class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Связь</span>
                </th>
                <th scope="col" class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Интервал</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(row, index) in data" :key="index" class="border-b border-gray-200 dark:border-gray-700">
                <th scope="row" class="font-normal text-gray-400 px-6 py-4 text-left">{{ row.Date }}</th>
                <td>
                    <td class="px-6 py-4 text-left border-l border-gray-200 dark:border-gray-700">
                        <span v-if="row.Quality" class="py-1 px-2 bg-green-100 text-green-600 dark:bg-green-500 dark:text-white rounded-3xl">Установлена</span>
                        <span v-else class="py-1 px-2 bg-red-100 text-red-600 dark:bg-red-500 dark:text-white rounded-3xl">Потеряна</span>
                    </td>
                </td>
                <td class="px-6 py-4 text-left border-l text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700">{{ row.AskLong }}</td>
            </tr>
        </tbody>
    </table>   
</template>