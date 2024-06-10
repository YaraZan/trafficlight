<template>
    <Link :href="props.href">
        <svg :class="[ props.active ? 'stroke-green-500 hover:stroke-green-500' : 'stroke-gray-300 dark:stroke-gray-500 hover:stroke-gray-500 dark:hover:stroke-gray-300', 'cursor-pointer']" width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.6828 9.36587H19.317M15.4145 14.8293H16.5853M26.3414 8.58538V27.7073H9.56089C7.40563 27.7073 5.65845 26.3696 5.65845 24.7195V11.5732M26.3414 3.51221V21.8537H9.56089C7.40563 21.8537 5.65845 20.5706 5.65845 18.9878V6.37806C5.65845 4.79529 7.40563 3.51221 9.56089 3.51221H26.3414Z" stroke-width="2.34146" stroke-linecap="round"/>
        </svg>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps(['active', 'href']);
</script>
