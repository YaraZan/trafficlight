<script setup>
import TrafficLightLayout from '@/Layouts/TrafficLightLayout.vue';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import Table from '@/Pages/Matrix/Partials/Table.vue'
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    matrix_data: {
        type: Array
    }
});
</script>

<template>
    <Head title="Матрица" />

    <TrafficLightLayout>
        <template #nav>
            <BreadCrumb
            :to="'matrix'"
            :name="'Матрица'"
            ></BreadCrumb>
        </template>


        <div class="p-6 font-bold text-3xl text-gray-900 dark:text-gray-100">Это Матрица!</div>
        <Table :data="matrix_data"></Table>

    </TrafficLightLayout>
</template>
