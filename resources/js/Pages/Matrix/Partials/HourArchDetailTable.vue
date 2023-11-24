<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Array,
        required: true
    },
    well: {
        type: Object,
        required: true
    },
    head_hour: {
        type: Object,
        required: true
    }
});

</script>

<template>
     <table id="hourarchTable" striped>
        <thead>
            <tr class="border-b bg-gray-50 dark:bg-gray-900 dark:bg-opacity-40 dark:border-gray-700 border-gray-200">
                <th class="text-left px-4 py-3">
                    <span class="font-semibold text-gray-800 dark:text-gray-300">Категория</span>
                </th>
                <th class="text-left px-4 py-3 border-l border-gray-200 dark:border-gray-700">
                    <span class="font-semibold text-gray-800 dark:text-gray-300">Уставка А</span>
                </th>
                <th class="text-left px-4 py-3 border-l border-gray-200 dark:border-gray-700">
                    <span class="font-semibold text-gray-800 dark:text-gray-300">Значение А</span>
                </th>
                <th class="text-left px-4 py-3 border-l border-gray-200 dark:border-gray-700">
                    <span class="font-semibold text-gray-800 dark:text-gray-300">Отклонение А, %</span>
                </th>
                <th class="text-left px-4 py-3 border-l border-gray-200 dark:border-gray-700">
                    <span class="font-semibold text-gray-800 dark:text-gray-300">Ранг А</span>
                </th>
                <th class="text-left px-4 py-3 border-l border-gray-200 dark:border-gray-700">
                    <span class="font-semibold text-gray-800 dark:text-gray-300">Уставка B</span>
                </th>
                <th class="text-left px-4 py-3 border-l border-gray-200 dark:border-gray-700">
                    <span class="font-semibold text-gray-800 dark:text-gray-300">Значение B</span>
                </th>
                <th class="text-left px-4 py-3 border-l border-gray-200 dark:border-gray-700">
                    <span class="font-semibold text-gray-800 dark:text-gray-300">Отклонение B, %</span>
                </th>
                <th class="text-left px-4 py-3 border-l border-gray-200 dark:border-gray-700">
                    <span class="font-semibold text-gray-800 dark:text-gray-300">Ранг B</span>
                </th>
                <th class="text-left px-4 py-3 border-l border-gray-200 dark:border-gray-700">
                    <span class="font-semibold text-gray-800 dark:text-gray-300">Уставка C</span>
                </th>
                <th class="text-left px-4 py-3 border-l border-gray-200 dark:border-gray-700">
                    <span class="font-semibold text-gray-800 dark:text-gray-300">Значение C</span>
                </th>
                <th class="text-left px-4 py-3 border-l border-gray-200 dark:border-gray-700">
                    <span class="font-semibold text-gray-800 dark:text-gray-300">Отклонение C, %</span>
                </th>
                <th class="text-left px-4 py-3 border-l border-gray-200 dark:border-gray-700">
                    <span class="font-semibold text-gray-800 dark:text-gray-300">Ранг C</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(row, index) in data" :key="index" class="border-b border-gray-200 dark:border-gray-700">
                <td class="px-4 py-3 font-semibold text-gray-800 dark:text-gray-400">{{ row.CatName }}</td>
                <td class="px-4 py-3 border-l text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700">{{ row.Ref1 }}</td>
                <td class="px-4 py-3 border-l text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700">{{ row.Cur1 }}</td>
                <td class="px-4 py-3 border-l text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700">{{ row.Res1 }}</td>
                <td class="px-4 py-3 border-l text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700">{{ row.Err1 }}</td>
                <td class="px-4 py-3 border-l text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700">{{ row.Ref2 }}</td>
                <td class="px-4 py-3 border-l text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700">{{ row.Cur2 }}</td>
                <td class="px-4 py-3 border-l text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700">{{ row.Res2 }}</td>
                <td class="px-4 py-3 border-l text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700">{{ row.Err2 }}</td>
                <td class="px-4 py-3 border-l text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700">{{ row.Ref3 }}</td>
                <td class="px-4 py-3 border-l text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700">{{ row.Cur3 }}</td>
                <td class="px-4 py-3 border-l text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700">{{ row.Res3 }}</td>
                <td class="px-4 py-3 border-l text-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700">{{ row.Err3 }}</td>
            </tr>
        </tbody>
    </table>   
</template>