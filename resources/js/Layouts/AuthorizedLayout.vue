<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import LightThemeIcon from '@/Components/Icons/LightThemeIcon.vue';
import DarkThemeIcon from '@/Components/Icons/DarkThemeIcon.vue';
import Navigation from './Partials/Navigation.vue';
import Logo from '@/Components/Logo.vue';
import { useDark, useToggle } from '@vueuse/core';

const isDark = useDark();
const toggleDark = useToggle(isDark);

</script>

<template>
    <div class="bg-white dark:bg-gray-800 min-w-screen min-h-screen font-montserrat overflow-x-hidden">

        <!-- Page Heading -->
        <nav
            :class="$slots.subAside ? 'ml-[250px]' : 'ml-[70px]'"
            class="fixed flex items-center w-[calc(100%-70px)] border-b border-gray-200
            dark:border-gray-700 bg-white dark:bg-gray-800 h-[71px] z-10 px-4">

            <slot name="nav" />

            <button
            @click="toggleDark()"
            class="px-2 py-2 flex items-center justify-center hover:bg-gray-100 rounded-lg dark:hover:bg-gray-700 ml-auto"
            >
            <LightThemeIcon v-if="isDark" />
            <DarkThemeIcon v-else />
            </button>
        </nav>

        <aside class="fixed top-0 left-0 z-40 w-[70px] h-screen border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div class="w-full h-[71px] flex items-center justify-center border-b border-gray-200 dark:border-gray-700">
                <Link
                :href="route('matrix')">
                    <Logo></Logo>
                </Link>
            </div>

            <Navigation />
        </aside>

        <aside v-if="$slots.subAside" class="fixed top-0 left-[70px] z-40 w-[200px] h-screen border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <slot name="subAside" />
        </aside>

        <!-- Page Content -->
        <main>
            <div :class="$slots.subAside ? 'ml-[250px]' : 'ml-[70px]'" class="mt-[70px]">
                <slot />
            </div>
        </main>

    </div>
</template>
