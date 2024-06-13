<template>
    <div class="relative py-[10px] px-[5px] flex flex-col items-center gap-6 w-full h-full">
        <!-- Admin routes -->
        <UsersIcon v-if="isAdmin" :href="route('users')" :active="$page.component.includes('Users/')"></UsersIcon>
        <RolesIcon v-if="isAdmin" :href="route('roles')" :active="$page.component.includes('Roles/')"></RolesIcon>
        <LogsIcon v-if="isAdmin" :href="route('logs')" :active="$page.component.includes('Logs/')"></LogsIcon>
        <Dinamograph v-if="isTrainer || isAdmin" :href="route('dinamograph')" :active="$page.component.includes('Dinamograph/')"></Dinamograph>

        <!-- Regular routes -->
        <MatrixIcon :href="route('matrix')" :active="$page.component.includes('Matrix/')"></MatrixIcon>
        <ClaimsIcon v-if="isAdmin || controlWells || isClaimModerator" :href="route('claims')" :active="$page.component.includes('Claims/')"></ClaimsIcon>
        <AlarmIcon :href="route('alarms')" :active="$page.component.includes('Alarms/')"></AlarmIcon>
        <SettingsIcon :href="route('settings')" :active="$page.component.includes('Settings/')" />
        <HelpIcon :href="route('docs.matrix')" :active="$page.component.includes('Docs/')" />
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import MatrixIcon from '@/Components/Icons/MatrixIcon.vue';
import Dinamograph from '@/Components/Icons/Dinamograph.vue';
import AlarmIcon from '@/Components/Icons/AlarmIcon.vue';
import SettingsIcon from '@/Components/Icons/SettingsIcon.vue';
import HelpIcon from '@/Components/Icons/HelpIcon.vue';
import UsersIcon from '@/Components/Icons/UsersIcon.vue';
import RolesIcon from '@/Components/Icons/RolesIcon.vue';
import LogsIcon from '@/Components/Icons/LogsIcon.vue';
import {computed, onMounted, ref} from 'vue';
import { useDark, useToggle } from '@vueuse/core';
import ClaimsIcon from '@/Components/Icons/ClaimsIcon.vue';
import AdminPanelIcon from '@/Components/Icons/AdminPanelIcon.vue';

const page = usePage();
const isDark = useDark();
const toggleDark = useToggle(isDark);
const isAdmin = computed(() => page.props.auth.isAdmin);
const isClaimModerator = computed(() => page.props.auth.isClaimModerator);
const controlWells = computed(() => page.props.auth.controlWells);
const isTrainer = computed(() => page.props.auth.isTrainer);

</script>
