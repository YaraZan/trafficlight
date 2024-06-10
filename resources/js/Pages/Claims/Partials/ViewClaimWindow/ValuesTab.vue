<template>
    <div class="w-full flex items-center justify-center gap-4 p-3 bg-gray-100 dark:bg-gray-900 rounded-lg">
        <svg :class="data.OldValue <= data.Value ? 'fill-green-500' : 'fill-red-500 rotate-180'"
            class="w-5 h-5" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3.56699 0.75C3.75944 0.416666 4.24056 0.416667 4.43301 0.75L7.03109 5.25C7.22354 5.58333 6.98298 6 6.59808 6H1.40192C1.01702 6 0.776461 5.58333 0.968911 5.25L3.56699 0.75Z"/>
        </svg>

        <div class="flex items-center gap-2">
            <span v-if="data.OldValue" class="text-lg text-gray-800 dark:text-white font-bold">{{ data.OldValue }}</span>
            <span v-else class="p-1 bg-gray-100 dark:bg-gray-800 text-[16px] text-red-500 font-semibold rounded-md">Пусто</span>

            <span class="text-[16px] text-gray-800 dark:text-white font-bold">-></span>

            <span v-if="data.Value" class="text-lg text-gray-800 dark:text-white font-bold">{{ data.Value }}</span>
            <span v-else class="p-1 bg-gray-100 dark:bg-gray-800 text-[16px] text-red-500 font-semibold rounded-md">Пусто</span>
        </div>
    </div>
</template>

<script setup>
const props = defineProps(['data']);
</script>
