<script setup>
import { TableRow, TableCell } from 'flowbite-vue';

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

let col = 1;
switch (props.stat) {
    case 1:
        col = 'bg-green-100 text-sm text-green-800';
        break;

    case 2:
        col = 'bg-yellow-100 text-sm text-yellow-800';
        break;

    case 3:
        col = 'bg-red-100 text-sm text-red-800';
        break;

}
</script>

<template>
    <table-cell :class="col">
        <div class="flex items-center gap-2">
            <span class="text-gray-400">Факт:</span>
            <span class="font-semibold">{{ alarm }}</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-gray-400">Уст:</span>
            <span class="font-semibold">{{ setting }}</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-gray-400">Откл:</span>
            <span class="font-semibold">{{ diff }}</span>
        </div>
    </table-cell>
</template>