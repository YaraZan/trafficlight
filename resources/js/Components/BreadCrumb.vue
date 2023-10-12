<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    to: {
        type: String,
        required: true,
    },
    name: {
        type: String,
    }
});

</script>

<template>
    <Link :href="route(to)">
        <span class="text-gray-800 text-[12px] font-semibold p-[10px] hover:bg-gray-100 rounded-[10px] cursor-pointer before:content-['/'] before:pr-[10px] before:text-gray-400">{{ name }}</span>
    </Link>
</template>