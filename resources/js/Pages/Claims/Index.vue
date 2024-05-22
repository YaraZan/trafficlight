<template>
    <Head title="Заявки" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('dinamograph.training')">
                <BreadCrumb
                    :name="'Заявки'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="flex p-4 w-full flex-col gap-5">
            <ClaimsHeader v-if="!claimsLoading" :claims="claims" />
            <div v-else class="border border-dashed border-gray-300 dark:border-gray-700 w-full h-[300px] p-10 flex flex-col items-center justify-center gap-16 rounded-lg" >
                <OilWellAnimatedGray class="w-20 h-20" />
            </div>

            <div class="w-full flex items-center justify-between">

            </div>

            <div class="w-full flex justify-between">
                <div class="w-2/3 grid grid-cols-3 gap-10">
                    <ClaimCard v-for="(claim, index) in claims" :key="index" :claim="claim" />
                </div>

                <div class="w-1/3 flex flex-col"></div>
            </div>
        </div>
    </AuthorizedLayout>
</template>

<script setup>
import {Head, Link} from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import ClaimsHeader from './Partials/ClaimsHeader.vue';
import ClaimCard from './Partials/ClaimCard.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import OilWellAnimatedGray from '@/Components/Icons/OilWellAnimatedGray.vue';

const claims = ref([]);
const claimsLoading = ref(true);

onMounted(() => {
    axios.get('/api/claims/all')
    .then((res) => {
        claims.value = res.data;
        claimsLoading.value = false;
    })
    .catch((error) => {
        console.error('Ошибка', error);
    })
    .finally(() => {
        claimsLoading.value = false;
    });
});
</script>
