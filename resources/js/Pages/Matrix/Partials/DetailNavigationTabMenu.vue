<template>
<div v-for="(item, index) in paginationSourceTypes"
        :key="index"
        class="flex items-center gap-2"
        @click="emit('select', item)">
        <span
            class="p-2 cursor-pointer rounded-lg text-gray-400 dark:text-gray-600 font-semibold text-[12px] hover:bg-gray-50 dark:hover:bg-gray-800"
            :class="{ 'bg-white shadow-sm dark:bg-gray-700 text-gray-800 dark:text-white' : current === item }">{{
                item
            }}</span>
    <span
        v-if="index !== paginationSourceTypes.length - 1"
        class="text-[13px] font-light text-gray-300 dark:text-gray-600"
    >
            |
        </span>
</div>
</template>

<script setup>
import { computed } from 'vue';

    const props = defineProps({
        paginationSourceTypes: {
            type: Array,
            required: true
        },
        currentSourceType: {
            type: String,
        }
    });

    const emit = defineEmits(['select']);

    const current = computed(() => {
        return props.currentSourceType;
    });
</script>
