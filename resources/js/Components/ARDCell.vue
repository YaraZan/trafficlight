<script setup>
import { TableRow, TableCell } from 'flowbite-vue';
import WarningIcon from './Toasts/WarningIcon.vue';
import ErrorIcon from './Toasts/ErrorIcon.vue';

const props = defineProps({
    alarm: {
        type: String
    },
    setting : {
        type: String
    },
    diff: {
        type: String
    },
    stat: {
        type: Number
    },
});
</script>

<template>
    <table-cell>
        <div class="flex items-center gap-2">
            <div :class="stat === 2 ? 'bg-orange-400' : '' || stat === 3 ? 'bg-red-500' : ''" class="flex gap-2 h-[30px] rounded-lg p-2">
                <div class="flex items-center gap-1">
                    <span :class="stat === 2 || stat === 3 ? 'text-gray-50' : 'text-gray-400'">Ф:</span>
                    <span :class="stat === 2 || stat === 3 ? 'text-white' : ''" class="font-semibold">{{ alarm }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <span :class="stat === 2 || stat === 3 ? 'text-gray-50' : 'text-gray-400'">У:</span>
                    <span :class="stat === 2 || stat === 3 ? 'text-white' : ''" class="font-semibold">{{ setting }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <span :class="stat === 2 || stat === 3 ? 'text-gray-50' : 'text-gray-400'">О:</span>
                    <span :class="stat === 2 || stat === 3 ? 'text-white' : ''" class="font-semibold">{{ diff }}</span>
                </div>
            </div>  
            <WarningIcon v-if="stat === 2"/>
            <ErrorIcon v-if="stat === 3"/>
        </div>
    </table-cell>
</template>