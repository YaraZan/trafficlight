<template>
    <button :disabled="props.processing"
        class="h-[47px] px-5 py-3 bg-green-600 border border-green-400 rounded-[10px] flex items-center justify-center hover:bg-green-700 focus:bg-green-700 outline-none">

        <Spinner v-if="props.processing" class="fill-white" />
        <span v-else class="text-md font-bold text-white">Войти</span>
    </button>
</template>

<script setup>
import { Spinner } from 'flowbite-vue';

const props = defineProps(['processing'])
</script>
