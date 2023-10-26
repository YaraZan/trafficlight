<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import NoDataIcon from '@/Components/Icons/NoDataIcon.vue'
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { Input } from 'flowbite-vue';
import { ref } from 'vue';
import CreateRoleForm from './Partials/CreateRoleForm.vue';
import EditRoleForm from './Partials/EditRoleForm.vue';

const props = defineProps({
    roles: {
        type: Array,
        required: false
    }
});

</script>

<template>
    <Head title="Роли" />

    <AdminLayout>
        <template #nav>
            <Link :href="route('roles')">
                <BreadCrumb
                :name="'Роли'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">   
            <div class="w-full h-full overflow-x-auto">
                <table class="w-full" striped>
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th scope="col" class="bg-gray-50 px-6 py-3 text-left border-l border-gray-200">
                                <span class="text font-semibold text-gray-800">Название</span>
                            </th>
                            <th scope="col" class="bg-gray-50 px-6 py-3 text-left border-l border-gray-200">
                                <span class="text font-semibold text-gray-800">Редактирование</span>
                            </th>
                            <th scope="col" class="bg-gray-50 px-6 py-3 text-left border-l border-gray-200">
                                <span class="text font-semibold text-gray-800">Все НГДУ</span>
                            </th>
                            <th scope="col" class="bg-gray-50 px-6 py-3 text-left border-l border-gray-200">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <CreateRoleForm />
                        <EditRoleForm v-if="props.roles.length" v-for="role in roles" :key="role.id" :role="role" />
                    </tbody>
                </table>  
                <div v-if="!props.roles.length" class="flex flex-col gap-4 items-center justify-center w-full pt-20">
                    <NoDataIcon />
                    <span class="text-gray-500 text-lg font-semibold">Данных нет..</span>
                </div>
            </div>
        
        </div>

    </AdminLayout>
</template>
