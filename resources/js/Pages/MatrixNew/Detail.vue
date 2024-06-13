<script setup>
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Link, Head } from '@inertiajs/vue3';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    }
});

</script>

<template>
    <Head :title="item.Name"/>

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('matrix')">
                <BreadCrumb
                    :name="'Матрица'"
                ></BreadCrumb>
            </Link>
            <Link :href="route('matrix.detail', item.public_id)">
                <BreadCrumb
                    :name="item.Name"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="w-full flex flex-col items-center justify-center">

            <div class="h-20 bg-green-400 w-2/3 mt-10"></div>
        </div>
    </AuthorizedLayout>
</template>
