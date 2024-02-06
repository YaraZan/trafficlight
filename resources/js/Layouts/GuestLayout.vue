<script setup>
import { useDark, useToggle } from '@vueuse/core';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const isDark = useDark();

const author_url = import.meta.env.VITE_AUTHOR_GITHUB_URL

</script>

<template>
    <div class="bg-white dark:bg-gray-800 w-screen h-screen overflow-hidden flex justify-center font-montserrat">
        <slot />
        <span class="absolute bottom-20 text-gray-400 text-[13px] text-normal flex items-center gap-[5px]">
            {{ `© ${new Date().getFullYear()} Светофор`}}
            <span>-</span>
            <a :href="author_url" class="hover:text-blue-500">Потёмкин Ярослав (GitHub)</a>
            <span>специально для ПАО «Татнефть»</span>
        </span>
    </div>
</template>
