<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Аналитика" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('analytics')">
                <BreadCrumb
                :name="'Аналитика'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 font-bold text-3xl text-gray-900 dark:text-gray-100">Это Аналитика!</div>
                </div>
            </div>
        </div>
    </AuthorizedLayout>
</template>
