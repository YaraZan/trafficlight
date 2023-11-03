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
            <tr class="border-y border-gray-200">
                <th scope="col" class="bg-gray-50 px-6 py-4 text-left">
                    <span class="text font-semibold text-gray-800">Дата</span>
                </th>
                <th scope="col" class="bg-gray-50 px-6 py-4 text-left border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Скважина</span>
                </th>
                <th scope="col" class="bg-gray-50 px-6 py-4 text-left border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Регистр</span>
                </th>
                <th scope="col" class="bg-gray-50 px-6 py-4 text-left border-l border-gray-200">
                    <span class="text font-semibold text-gray-800">Значение</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(row, index) in data" :key="index" class="border-b border-gray-200">
                <th scope="row" class="font-normal text-gray-800 px-6 py-4 text-left">{{ row.Date }}</th>
                <td class="font-semibold border-l border-gray-200 text-gray-800 px-6 py-4 text-left">{{ row.WellName }}</td>
                <td class="px-6 py-4 text-left border-l border-gray-200">{{ row.RegDescript }}</td>
                <td class="px-6 py-4 text-left border-l border-gray-200">
                    <span v-if="row.Value" class="py-1 px-2 bg-green-100 text-green-600 rounded-3xl">Да</span>
                    <span v-else class="py-1 px-2 bg-red-100 text-red-600 rounded-3xl">Нет</span>
                </td>
            </tr>
        </tbody>
    </table>   
</template>