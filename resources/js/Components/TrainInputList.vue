<script setup>
import {computed} from 'vue';

const props = defineProps({
    markers: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <div class="absolute flex flex-col w-full p-4 bg-white
    dark:bg-gray-800 gap-[10px] rounded-lg border border-gray-200
    dark:border-gray-700 bottom-[80px] max-h-[400px] overflow-y-auto">
        <div v-for="marker in markers" :key="marker.id"
            class="w-full p-4 flex items-center bg-white gap-[30px] rounded-lg
             hover:bg-gray-100 cursor-pointer dark:bg-gray-800 dark:hover:bg-gray-700">
            <img class="w-[120px] h-[60px] rounded-lg border border-gray-200 dark:border-gray-700" :src="marker.url">
            <div class="flex flex-col gap-[10px]">
                <span class="text-gray-800 dark:text-gray-300 font-semibold text-lg">{{ marker.name }}</span>
                <span class="text-gray-400 font-normal text-xm">{{ `#${marker.id}` }}</span>
            </div>
        </div>
    </div>
</template>
