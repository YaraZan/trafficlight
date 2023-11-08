<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head } from '@inertiajs/vue3';
import AlarmsTable from '@/Pages/Alarms/Partials/AlarmsTable.vue';
import NoDataIcon from '@/Components/Icons/NoDataIcon.vue';
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import UserDefaultIcon from '@/Components/Icons/UserDefaultIcon.vue';

const props = defineProps({
    profile_data: {
        type: Object
    }
});

</script>

<template>
    <Head title="Профиль" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('profile')">
                <BreadCrumb
                :name="'Профиль'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="flex w-full p-4 items-center justify-center">

            <div class="flex flex-col items-center mt-32">
                <UserDefaultIcon />

                <h2 class="font-semibold text-gray-800 dark:text-gray-200 text-2xl mt-3">{{ profile_data.name }}</h2>
                <span class="text-gray-400">.</span>
                <span class="font-normal text-gray-400 text-lg">{{ profile_data.email }}</span>

                <Link :href="route('logout')" method="post">
                    <span class="border border-gray-200 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:bg-gray-900 px-3 py-2 w-32 rounded-lg mt-12 font-medium flex items-center justify-center hover:bg-gray-50">
                        Выход
                    </span>
                </Link>
            </div>

        </div>
    </AuthorizedLayout>
</template>
