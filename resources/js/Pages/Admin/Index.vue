<template>
    <Head title="Админ панель"/>

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('admin.view')">
                <BreadCrumb
                    :name="'Админ панель'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="pt-5 w-full flex flex-col">

            <div class="self-center w-max flex items-center bg-gray-100 dark:bg-gray-900 rounded-lg p-1 gap-2">
                <div v-for="(item, index) in pages"
                    :key="index"
                    class="flex items-center gap-2"
                    @click="selectPage(item)">
                    <span class=""
                        :class="[{ 'bg-white shadow-sm dark:bg-gray-700 text-gray-800 dark:text-white' : currentPage === item },
                                'p-2 cursor-pointer rounded-lg text-gray-400 dark:text-gray-600 font-semibold text-[12px] hover:bg-gray-50 dark:hover:bg-gray-800'
                        ]">{{ item }}</span>
                    <span v-if="index !== pages.length - 1"
                        class="text-[13px] font-light text-gray-300 dark:text-gray-600">|</span>
                </div>
            </div>

            <Logs v-if="currentPage === 'Логи'"/>

        </div>

    </AuthorizedLayout>
</template>

<script setup>
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Link, Head } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import { computed, ref } from 'vue';
import Logs from './Partials/Logs.vue';

const pages = ref(['Логи', 'Роли', 'Пользователи']);
const currentPage = ref('Логи');

function selectPage(page) {
    currentPage.value = page;
}
</script>

