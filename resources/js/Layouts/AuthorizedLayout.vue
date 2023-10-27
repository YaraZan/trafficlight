<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import MatrixIcon from '@/Components/Icons/MatrixIcon.vue';
import AlarmIcon from '@/Components/Icons/AlarmIcon.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import OperatingIcon from '@/Components/Icons/OperatingIcon.vue';
import AnalyticsIcon from '@/Components/Icons/AnalyticsIcon.vue';
import Logo from '@/Components/Logo.vue';
import AdminPanelIcon from '@/Components/Icons/AdminPanelIcon.vue';
import ProfileIcon from '@/Components/Icons/ProfileIcon.vue';
import UsersIcon from '@/Components/Icons/UsersIcon.vue';
import RolesIcon from '@/Components/Icons/RolesIcon.vue';
import { computed } from 'vue';

const page = usePage();

const isAdmin = computed(() => page.props.auth.isAdmin);

</script>

<template>
    <div class="min-w-screen min-h-screen bg-white font-montserrat overflow-x-hidden">
        
        <!-- Page Heading -->
        <nav class=" bg-white dark:bg-gray-800 w-screen border-b border-gray-200" v-if="$slots.nav">
            <div class="ml-[50px] w-full h-[50px] px-[20px] flex items-center">
                <slot name="nav" />
            </div>
        </nav>

        <aside class="fixed top-0 left-0 z-40 w-[50px] bg-white h-screen border-r border-gray-200">
            <div class="w-full h-[51px] flex items-center justify-center border-b border-gray-200">
                <Link
                :href="route('matrix')">
                    <Logo></Logo>
                </Link>
            </div>
            <div class="py-[10px] px-[5px] flex flex-col gap-[10px] w-full h-full">
                <NavLink v-if="isAdmin" :inc="'users'" :to="'users'"><UsersIcon></UsersIcon></NavLink>
                <NavLink v-if="isAdmin" :inc="'roles'" :to="'roles'"><RolesIcon></RolesIcon></NavLink>
                <div v-if="isAdmin" class="border-b border-gray-200 w-full"></div>

                <NavLink :inc="'matrix'" :to="'matrix'"><MatrixIcon></MatrixIcon></NavLink>
                <NavLink :inc="'alarms'" :to="'alarms'"><AlarmIcon></AlarmIcon></NavLink>
                <NavLink :inc="'analytics'" :to="'analytics'"><AnalyticsIcon></AnalyticsIcon></NavLink>
                <Dropdown align="left" width="48">
                    <template #trigger>
                        <div class="flex items-center justify-center p-[10px] hover:bg-gray-100 rounded-[10px] cursor-pointer">
                            <ProfileIcon />
                        </div>
                    </template>

                    <template #content>
                        <DropdownLink :href="route('logout')" method="post" as="button">
                            Выйти
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            
        </aside>

        <!-- Page Content -->
        <main>
            <div class="ml-[50px]">
                <slot />
            </div>
        </main>

    </div>
</template>
