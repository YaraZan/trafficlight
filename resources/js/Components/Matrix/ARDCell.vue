<script setup>
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
});
</script>

<template>
<div class="flex flex-col gap-1 items-end">
    <div class="flex items-center gap-2">
        <span class="text-gray-300">Факт:</span>
        <span>{{ alarm }}</span>
    </div>
    <div class="flex items-center gap-2">
        <span class="text-gray-300">Уст:</span>
        <span>{{ setting }}</span>
    </div>
    <div class="flex items-center gap-2">
        <span class="text-gray-300">Откл:</span>
        <span>{{ diff }}</span>
    </div>
</div>
</template>