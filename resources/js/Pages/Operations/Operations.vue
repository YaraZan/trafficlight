<script setup>
import BreadCrumb from '@/Components/BreadCrumb.vue';
import TrafficLightLayout from '@/Layouts/TrafficLightLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Наработки" />

    <TrafficLightLayout>
        <template #nav>
            <BreadCrumb
            :to="'operations'"
            :name="'Наработки'"
            ></BreadCrumb>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 font-bold text-3xl text-gray-900 dark:text-gray-100">Это Наработки!</div>
                </div>
            </div>
        </div>
    </TrafficLightLayout>
</template>
