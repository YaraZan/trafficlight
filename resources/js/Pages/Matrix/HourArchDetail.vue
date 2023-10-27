<script setup>
import { ref, computed, watch } from 'vue';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Link, Head } from '@inertiajs/vue3';
import HourArchDetailTable from './Partials/HourArchDetailTable.vue';

const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
    well_item: {
        type: Object,
        required: true,
    },
    head_hour_item: {
        type: Object,
        required: true,
    },
});

</script>

<template>
    <Head title="Часовые архивы" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('matrix')">
                <BreadCrumb
                :name="'Матрица'"
                ></BreadCrumb>
            </Link>
            <Link :href="route('matrix.detail', well_item.public_id)">
                <BreadCrumb
                :name="well_item.Name"
                ></BreadCrumb>
            </Link>
            <Link :href="route('matrix.hourarch', well_item.public_id)">
                <BreadCrumb
                :name="'Часовые архивы'"
                ></BreadCrumb>
            </Link>
            <Link :href="route('matrix.hourarch.detail', { well_uuid: well_item.public_id, head_hour_uuid: head_hour_item.public_id})">
                <BreadCrumb
                :name="head_hour_item.Date"
                ></BreadCrumb>
            </Link>

        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">
            <div class="w-full h-full overflow-x-auto">
                <HourArchDetailTable :data="data"></HourArchDetailTable>
            </div>
        </div>
    </AuthorizedLayout>
</template>