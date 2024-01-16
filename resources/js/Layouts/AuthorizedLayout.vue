<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import MatrixIcon from '@/Components/Icons/MatrixIcon.vue';
import Dinamograph from '@/Components/Icons/Dinamograph.vue';
import AlarmIcon from '@/Components/Icons/AlarmIcon.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import OperatingIcon from '@/Components/Icons/OperatingIcon.vue';
import AnalyticsIcon from '@/Components/Icons/AnalyticsIcon.vue';
import Logo from '@/Components/Logo.vue';
import AdminPanelIcon from '@/Components/Icons/AdminPanelIcon.vue';
import SettingsIcon from '@/Components/Icons/SettingsIcon.vue';
import UsersIcon from '@/Components/Icons/UsersIcon.vue';
import RolesIcon from '@/Components/Icons/RolesIcon.vue';
import LogsIcon from '@/Components/Icons/LogsIcon.vue';
import { computed, ref } from 'vue';
import { useDark, useToggle } from '@vueuse/core';
import LightThemeIcon from '@/Components/Icons/LightThemeIcon.vue';
import DarkThemeIcon from '@/Components/Icons/DarkThemeIcon.vue';
import QuestionIcon from '@/Components/Icons/QuestionIcon.vue';
import { onMounted } from 'vue';
import Modal from '@/Components/Modal.vue';
import Help from '@/Components/Help.vue';

const page = usePage();
const isDark = useDark();
const toggleDark = useToggle(isDark);
const isAdmin = computed(() => page.props.auth.isAdmin);

const readingHelpSurvey = ref(false);
const closeModal = () => {
    readingHelpSurvey.value = false;
};

</script>

<template>
    <div class="bg-white dark:bg-gray-800 min-w-screen min-h-screen font-montserrat overflow-x-hidden">

        <!-- Page Heading -->
        <nav class="flex items-center w-screen border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800" v-if="$slots.nav">
            <div class="ml-[50px] w-full h-[50px] px-[20px] flex items-center">
                <slot name="nav" />

                <button
                @click="toggleDark()"
                class="px-2 py-2 flex items-center justify-center hover:bg-gray-100 rounded-lg dark:hover:bg-gray-700 ml-auto"
                >
                <LightThemeIcon v-if="isDark" />
                <DarkThemeIcon v-else />
                </button>
            </div>
        </nav>

        <aside class="fixed top-0 left-0 z-40 w-[50px] h-screen border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div class="w-full h-[51px] flex items-center justify-center border-b border-gray-200 dark:border-gray-700">
                <Link
                :href="route('matrix')">
                    <Logo></Logo>
                </Link>
            </div>
            <div class="py-[10px] px-[5px] flex flex-col gap-[10px] w-full h-full">
                <NavLink v-if="isAdmin" :href="route('users')" :active="$page.component.includes('Users/')"><UsersIcon></UsersIcon></NavLink>
                <NavLink v-if="isAdmin" :href="route('roles')" :active="$page.component.includes('Roles/')"><RolesIcon></RolesIcon></NavLink>
                <NavLink v-if="isAdmin" :href="route('logs')" :active="$page.component.includes('Logs/')"><LogsIcon></LogsIcon></NavLink>
                <div v-if="isAdmin" class="border-b border-gray-200 dark:border-gray-700 w-full"></div>

                <NavLink :href="route('matrix')" :active="$page.component.includes('Matrix/')"><MatrixIcon></MatrixIcon></NavLink>
                <NavLink :href="route('dinamograph')" :active="$page.component.includes('Dinamograph/')"><Dinamograph></Dinamograph></NavLink>
                <NavLink  :href="route('alarms')" :active="$page.component.includes('Alarms/')"><AlarmIcon></AlarmIcon></NavLink>
                <NavLink :href="route('analytics')" :active="$page.component.includes('Analytics/')"><AnalyticsIcon></AnalyticsIcon></NavLink>
                <NavLink :href="route('settings')" :active="$page.component.includes('Settings/')"><SettingsIcon /></NavLink>
            </div>

        </aside>

        <aside v-if="$slots.subAside" class="fixed top-0 left-[50px] z-40 w-[200px] h-screen border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <slot name="subAside" />
        </aside>

        <div v-on:click="readingHelpSurvey = !readingHelpSurvey" class="group fixed z-40 bottom-4 right-4
            rounded-full w-[24px] h-[24px] p-[4px] flex items-center justify-center
            bg-gray-200 dark:bg-black cursor-pointer hover:bg-green-500 dark:hover:bg-green-500">
            <span class="text-gray-800 dark:text-white group-hover:text-white">?</span>
        </div>

        <Modal :show="readingHelpSurvey" @close="closeModal">
            <Help />
        </Modal>

        <!-- Page Content -->
        <main>
            <div :class="$slots.subAside ? 'ml-[250px]' : 'ml-[50px]'">
                <slot />
            </div>
        </main>

    </div>
</template>
