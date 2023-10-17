<script setup>
import BreadCrumb from '@/Components/BreadCrumb.vue';
import TrafficLightLayout from '@/Layouts/TrafficLightLayout.vue';
import { Link, Head } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Object,
        required: true,
    }
});
</script>

<template>
    <Head :title="data.Name" />

    <TrafficLightLayout>
        <template #nav>
            <Link :href="route('operations')">
                <BreadCrumb
                :name="'Наработки'"
                ></BreadCrumb>
            </Link>
            <Link :href="route('operations.general', data.public_id)">
                <BreadCrumb
                :name="data.Name"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">
            <h1>{{ data.Name }}</h1>
        </div>
    </TrafficLightLayout>
</template>