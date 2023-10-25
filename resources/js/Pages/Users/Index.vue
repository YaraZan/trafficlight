<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import UsersTable from '@/Pages/Admin/Partials/UsersTable.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    users: {
        type: Array,
        required: false
    }
});
</script>

<template>
    <Head title="Пользователи" />

    <AdminLayout>
        <template #nav>
            <Link :href="route('users')">
                <BreadCrumb
                :name="'Пользователи'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">

            <div class="flex items-center p-4 w-full justify-between">

            </div>      

            <div class="flex items-center gap-3 p-4 pt-0 w-full">
                
            </div>  

            <div v-if="props.users.length" class="w-full h-full overflow-x-auto">
                <UsersTable :users="props.users"></UsersTable>
            </div>
            <div v-else class="w-full h-full overflow-x-auto p-4">
                Данных пока нет
            </div>
        </div>

        
    </AdminLayout>
</template>
