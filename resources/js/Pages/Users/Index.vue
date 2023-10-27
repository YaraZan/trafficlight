<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import NoDataIcon from '@/Components/Icons/NoDataIcon.vue'
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { Input } from 'flowbite-vue';
import { ref } from 'vue';
import CreateUserForm from './Partials/CreateUserForm.vue';
import EditUserForm from './Partials/EditUserForm.vue';

const props = defineProps({
    users: {
        type: Array,
        required: false
    },
    roles: {
        type: Array,
        required: true
    },
    ngdus: {
        type: Array,
        required: true
    }
});

</script>

<template>
    <Head title="Пользователи" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('users')">
                <BreadCrumb
                :name="'Пользователи'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">   
            <div class="w-full h-full overflow-x-auto">
                <table class="w-full" striped>
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th scope="col" class="bg-gray-50 px-6 py-3 text-left">
                                <span class="text font-semibold text-gray-800">Ф.И.О</span>
                            </th>
                            <th scope="col" class="bg-gray-50 px-6 py-3 text-left border-l border-gray-200">
                                <span class="text font-semibold text-gray-800">Пароль</span>
                            </th>
                            <th scope="col" class="bg-gray-50 px-6 py-3 text-left border-l border-gray-200">
                                <span class="text font-semibold text-gray-800">Роль</span>
                            </th>
                            <th scope="col" class="bg-gray-50 px-6 py-3 text-left border-l border-gray-200">
                                <span class="text font-semibold text-gray-800">Почта</span>
                            </th>
                            <th scope="col" class="bg-gray-50 px-6 py-3 text-left border-l border-gray-200">
                                <span class="text font-semibold text-gray-800">НГДУ</span>
                            </th>
                            <th scope="col" class="bg-gray-50 px-6 py-3 text-left border-l border-gray-200">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <CreateUserForm :roles="roles" :ngdus="ngdus" />
                        <EditUserForm v-if="props.users.length" v-for="user in users" :key="user.id" :user="user" :roles="roles" :ngdus="ngdus" />
                    </tbody>
                </table>  
                <div v-if="!props.users.length" class="flex flex-col gap-4 items-center justify-center w-full pt-20">
                    <NoDataIcon />
                    <span class="text-gray-500 text-lg font-semibold">Данных нет..</span>
                </div>
            </div>
        
        </div>

    </AuthorizedLayout>
</template>
