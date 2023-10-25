<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import LogsTableVue from '@/Pages/Admin/Partials/LogsTable.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    logs: {
        type: Array,
        required: false
    }
});
</script>

<template>
    <Head title="Панель администратора" />

    <AdminLayout>
        <template #nav>
            <Link :href="route('admin')">
                <BreadCrumb
                :name="'Административная панель'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">

            <div class="flex items-center p-4 w-full justify-between">

            </div>      

            <div class="flex items-center gap-3 p-4 pt-0 w-full">
                
            </div>  
            
            <div v-if="props.logs.length" class="w-full h-full overflow-x-auto">
                <LogsTableVue :logs="props.logs"></LogsTableVue>
            </div>
            <div v-else class="w-full h-full overflow-x-auto p-4">
                Данных пока нет
            </div>
        </div>

    </AdminLayout>
</template>
