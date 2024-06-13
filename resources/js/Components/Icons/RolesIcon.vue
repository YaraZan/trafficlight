<template>
    <Link :href="props.href">
    <svg :class="[ props.active ? 'stroke-green-500 hover:stroke-green-500' : 'stroke-gray-300 dark:stroke-gray-500 hover:stroke-gray-500 dark:hover:stroke-gray-300', 'cursor-pointer']"  width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M11.5121 12.878H6.6341C5.77199 12.878 5.07312 13.5769 5.07312 14.439V24.5853C5.07312 25.4474 5.77199 26.1463 6.6341 26.1463H25.3658C26.2279 26.1463 26.9268 25.4474 26.9268 24.5853V14.439C26.9268 13.5769 26.2279 12.878 25.3658 12.878H20.4878M11.5121 12.878V5.65851C11.5121 4.79641 12.211 4.09753 13.0731 4.09753H18.9268C19.7889 4.09753 20.4878 4.79641 20.4878 5.65851V12.878M11.5121 12.878H20.4878M15.9999 21.4634V17.5609" stroke-width="2.30631" stroke-linecap="round"/>
        </svg>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps(['active', 'href']);
</script>



