<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Array,
        required: true
    }
});
</script>

<template>
     <table striped>
        <thead>
            <tr class="border-b border-gray-200">
                <th class="bg-gray-50 text-left px-4 py-3">
                    <span class="text font-semibold text-gray-800">Категория</span>
                </th>
                <th class="bg-gray-50 text-left px-4 py-3 border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Уставка А</span>
                </th>
                <th class="bg-gray-50 text-left px-4 py-3 border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Значение А</span>
                </th>
                <th class="bg-gray-50 text-left px-4 py-3 border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Отклонение А, %</span>
                </th>
                <th class="bg-gray-50 text-left px-4 py-3 border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Ранг А</span>
                </th>
                <th class="bg-gray-50 text-left px-4 py-3 border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Уставка B</span>
                </th>
                <th class="bg-gray-50 text-left px-4 py-3 border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Значение B</span>
                </th>
                <th class="bg-gray-50 text-left px-4 py-3 border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Отклонение B, %</span>
                </th>
                <th class="bg-gray-50 text-left px-4 py-3 border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Ранг B</span>
                </th>
                <th class="bg-gray-50 text-left px-4 py-3 border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Уставка C</span>
                </th>
                <th class="bg-gray-50 text-left px-4 py-3 border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Значение C</span>
                </th>
                <th class="bg-gray-50 text-left px-4 py-3 border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Отклонение C, %</span>
                </th>
                <th class="bg-gray-50 text-left px-4 py-3 border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Ранг C</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(row, index) in data" :key="index" class="border-b border-gray-200">
                <td class="px-4 py-3 font-semibold text-gray-800">{{ row.CatName }}</td>
                <td class="px-4 py-3 border-l border-gray-200">{{ row.Ref1 }}</td>
                <td class="px-4 py-3 border-l border-gray-200">{{ row.Cur1 }}</td>
                <td class="px-4 py-3 border-l border-gray-200">{{ row.Res1 }}</td>
                <td class="px-4 py-3 border-l border-gray-200">{{ row.Err1 }}</td>
                <td class="px-4 py-3 border-l border-gray-200">{{ row.Ref2 }}</td>
                <td class="px-4 py-3 border-l border-gray-200">{{ row.Cur2 }}</td>
                <td class="px-4 py-3 border-l border-gray-200">{{ row.Res2 }}</td>
                <td class="px-4 py-3 border-l border-gray-200">{{ row.Err2 }}</td>
                <td class="px-4 py-3 border-l border-gray-200">{{ row.Ref3 }}</td>
                <td class="px-4 py-3 border-l border-gray-200">{{ row.Cur3 }}</td>
                <td class="px-4 py-3 border-l border-gray-200">{{ row.Res3 }}</td>
                <td class="px-4 py-3 border-l border-gray-200">{{ row.Err3 }}</td>
            </tr>
        </tbody>
    </Table>   
</template>