<template>
    <Link :href="props.href">
        <svg :class="[ props.active ? 'stroke-green-500 hover:stroke-green-500' : 'stroke-gray-300 dark:stroke-gray-500 hover:stroke-gray-500 dark:hover:stroke-gray-300', 'cursor-pointer']"  width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M5.42308 13.7262H16.2787C17.3491 13.7262 18.2149 14.5939 18.2149 15.6644C18.2149 16.7348 17.3472 17.6026 16.2767 17.6026H5.42308M6.97361 9.46212H16.2769C19.7022 9.46212 22.4788 12.239 22.4788 15.6644C22.4788 19.0898 19.7021 21.8666 16.2767 21.8666H6.97361M25.7715 8.63807C21.0883 2.35249 11.6304 2.47717 7.1102 8.88095C4.25103 12.9316 4.30131 18.3585 7.2368 22.3541C11.7685 28.5224 20.9452 28.6387 25.6358 22.5902C28.8091 18.4982 28.8654 12.7905 25.7715 8.63807Z" stroke-width="2"/>
        </svg>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps(['active', 'href']);
</script>







