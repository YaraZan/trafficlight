<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    active: {
        type: Boolean,
        required: true,
    }
});

</script>

<template>
    <Link>
        <div :class="{ 'bg-gray-100 dark:bg-gray-700': active }" class="flex items-center justify-center p-[10px] dark:hover:bg-gray-700 hover:bg-gray-100 rounded-[10px] cursor-pointer">
            <slot />
        </div>
    </Link>
</template>
