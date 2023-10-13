<script setup>
const props = defineProps({
    ngdu: {
        type: String
    },
});
</script>

<template>
    <li class="flex items-center">
        <input :id="ngdu.id" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-green-600 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
        <label :for="ngdu.id" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ ngdu.NgduName }}</label>
    </li>
</template>