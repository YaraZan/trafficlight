<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    to: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <Link :href="route(to)" :class="classes">
        <div :class="{ 'bg-gray-100': $page.url === '/traffic-light/' + to }" class="flex items-center justify-center p-[10px] hover:bg-gray-100 rounded-[10px] cursor-pointer">
        <slot />
        </div>
    </Link>
</template>
