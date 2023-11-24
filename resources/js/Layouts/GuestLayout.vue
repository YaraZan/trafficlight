<script setup>
import { useDark, useToggle } from '@vueuse/core';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const isDark = useDark();

</script>

<template>
    <div class="bg-white dark:bg-gray-800 w-screen h-screen overflow-hidden flex justify-center font-montserrat">
        <slot />
    </div>
</template>