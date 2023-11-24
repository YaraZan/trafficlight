<script setup>
const props = defineProps({
    text: {
        type: String,
        required: true
    },
    active: {
        type: Boolean,
        required: true
    }
});
</script>

<template>
    <span
    :class="active ? 'font-semibold bg-gray-100 dark:bg-gray-700' : ''"
    class="flex items-center w-full px-2 py-1 rounded-md hover:font-semibold text-gray-800 dark:text-gray-400 font-medium text-sm">
        {{ text }}
    </span>
</template>