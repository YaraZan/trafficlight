<script setup>

const props = defineProps({
    data: {
        type: Array,
        required: true
    }
});
</script>

<template>
     <table class="w-full" striped>
        <thead>
            <tr class="border-y border-gray-200 dark:border-gray-700 dark:bg-opacity-40 bg-gray-50 dark:bg-gray-900">
                <th scope="col" class="px-6 py-2 text-left">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Скважина</span>
                </th>
                <th scope="col" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Дата</span>
                </th>
                <th scope="col" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Регистр</span>
                </th>
                <th scope="col" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
                    <span class="text font-semibold text-gray-800 dark:text-gray-300">Значение</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(row, index) in data" :key="index" class="border-b border-gray-200 dark:border-gray-700">
                <th scope="row" class="font-medium text-gray-800 dark:text-gray-400 px-6 py-3 text-left">{{ row.WellName }}</th>
                <td class="font-normal text-gray-800 dark:text-gray-400 px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">{{ row.Date }}</td>
                <td class="px-6 py-3 text-left text-gray-800 dark:text-gray-400 border-l border-gray-200 dark:border-gray-700">{{ row.RegDescript }}</td>
                <td class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
                    <span v-if="row.Value" class="py-1 px-2 bg-green-100 text-green-600 dark:bg-green-500 dark:text-white rounded-3xl">Да</span>
                    <span v-else class="py-1 px-2 bg-red-100 text-red-600 dark:bg-red-500 dark:text-white dark: rounded-3xl">Нет</span>
                </td>
            </tr>
        </tbody>
    </table>   
</template>