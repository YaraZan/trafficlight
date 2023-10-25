<script setup>
import { Link } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Logo from '@/Components/Logo.vue';
import AdminPanelIcon from '@/Components/Icons/AdminPanelIcon.vue';
import UsersIcon from '@/Components/Icons/UsersIcon.vue';
import RolesIcon from '@/Components/Icons/RolesIcon.vue';
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
                :href="route('logs')">
                    <Logo></Logo>
                </Link>
            </div>
            <div class="py-[10px] px-[5px] flex flex-col gap-[10px] w-full h-full">
                <NavLink :inc="'logs'" :to="'logs'"><AdminPanelIcon></AdminPanelIcon></NavLink>
                <NavLink :inc="'users'" :to="'users'"><UsersIcon></UsersIcon></NavLink>
                <NavLink :inc="'roles'" :to="'roles'"><RolesIcon></RolesIcon></NavLink>
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
