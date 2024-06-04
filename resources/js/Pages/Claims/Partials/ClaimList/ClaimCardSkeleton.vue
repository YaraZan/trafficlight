<template>
    <div v-for="(item, key) in Array.from({ length: 30 })" class="flex flex-col gap-6 bg-gray-100 dark:bg-gray-900 rounded-xl">
        <div class="p-5 w-full flex flex-col gap-2">
            <div class="flex items-center gap-2">
                <span class="h-10 bg-gray-200 dark:bg-gray-800 rounded-lg w-1/2"></span>
                <span class="h-10 bg-gray-200 dark:bg-gray-800 rounded-lg w-1/3"></span>
            </div>

            <span class="h-10 bg-gray-200 dark:bg-gray-800 rounded-lg w-1/3"></span>

            <div class="w-full flex items-center flex-wrap gap-2">
                <span class="h-10 bg-gray-200 dark:bg-gray-800 rounded-lg w-1/3"></span>
                <span class="h-10 bg-gray-200 dark:bg-gray-800 rounded-lg w-1/2"></span>
            </div>
        </div>

        <div class="w-full p-5 flex items-center justify-center">
            <span class="h-10 bg-gray-200 dark:bg-gray-800 rounded-lg w-1/2"></span>
        </div>
    </div>
</template>
