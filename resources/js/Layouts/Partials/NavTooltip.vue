<template>
    <div
        v-on:mouseover="show = true"
        v-on:mouseleave="show = false"
        class="relative flex items-center justify-center gap-2">
        <slot />

        <div v-if="show" class="absolute left-[110%] h-full flex items-center justify-center px-2 bg-gray-900 border border-gray-700 rounded-lg shadow">
            <span class="text-sm font-semibold text-white">{{ props.title }}</span>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps(['title']);

const show = ref(false);
</script>
