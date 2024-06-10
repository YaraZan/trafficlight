<template>
    <button :class="[defaultClasses, {'border-green-400 dark:border-green-400' : isActive}]" class="flex items-center bg-white shadow border-gray-200 dark:bg-gray-700 dark:border-gray-600
            border rounded-xl hover:bg-gray-50 dark:hover:bg-opacity-75 gap-2 focus:outline-none">
        <slot name="prefix" />
        <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ text }}</span>
        <slot name="suffix" />
    </button>
</template>

<script setup>
defineProps({
    text: {
        type: String,
        required: false,
        default: 'Button'
    },
    defaultClasses: {
        type: String,
        required: false,
        default: 'w-full items-center justify-center px-3 py-1'
    },
    isActive: {
        type: Boolean,
        required: false,
        default: false,
    }
})
</script>
