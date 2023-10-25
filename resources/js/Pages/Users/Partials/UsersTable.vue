<script setup>

const props = defineProps({
    users: {
        type: Array
    }
});
</script>

<template>
    <table class="w-full" striped>
        <thead>
            <tr>
                <th scope="col" class="bg-gray-50 px-6 py-4 text-left">
                    <span class="text font-semibold text-gray-800">Ф.И.О</span>
                </th>
                <th scope="col" class="bg-gray-50 px-6 py-4 text-left">
                    <span class="text font-semibold text-gray-800">Роль</span>
                </th>
                <th scope="col" class="bg-gray-50 px-6 py-4 text-left">
                    <span class="text font-semibold text-gray-800">Почта</span>
                </th>
                <th scope="col" class="bg-gray-50 px-6 py-4 text-left">
                    <span class="text font-semibold text-gray-800">Нгду</span>
                </th>
            </tr>
        </thead>
        <tbody>
<!--             <tr v-for="(row, index) in users" :key="index" class="border-b border-gray-200">
                <th scope="row" class="font-bold text-gray-400 px-6 py-4 text-left">{{ row.Date }}</th>
                <td>
                    <td class="px-6 py-4 text-left">
                        <span v-if="row.Quality" class="py-1 px-2 bg-green-100 text-green-600 rounded-3xl">Установлена</span>
                        <span v-else class="py-1 px-2 bg-red-100 text-red-600 rounded-3xl">Потеряна</span>
                    </td>
                </td>
                <td class="px-6 py-4 text-left">{{ row.AskLong }}</td>
            </tr> -->
        </tbody>
    </table>  
</template>