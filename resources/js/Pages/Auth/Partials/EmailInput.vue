<template>
    <input
        v-model="model"
        type="text"
        placeholder="Почта"
        class="w-full h-[47px] px-5 py-3 border border-gray-300 dark:border-gray-700 bg-transparent
         placeholder:text-gray-300 dark:placeholder:text-gray-700 rounded-[10px] placeholder:text-sm
         text-sm text-gray-800 dark:text-white font-semibold placeholder:font-medium focus:border-green-400 dark:focus:border-green-400 focus:ring-0 ring-0" />
</template>

<script setup>
const model = defineModel();
</script>
