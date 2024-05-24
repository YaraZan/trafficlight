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

        <div class="flex p-4 w-full gap-[10px] h-[calc(100vh-90px)]">

            <!-- Aside -->
            <ClaimsAside v-if="!claimsLoading" :claims="claims" />
            <div v-else class="border border-dashed border-gray-300 dark:border-gray-700 w-full p-10 flex flex-col items-center justify-center gap-16 rounded-lg" >

            </div>

            <!-- Claims -->
            <div class="w-2/3 flex flex-col gap-[10px] h-full">
                <div class="w-full flex items-center gap-4">
                    <ClaimsFilters />
                </div>
                <div v-if="!claimsLoading" class="relative w-full grid grid-cols-3 gap-[10px] pr-5 h-full overflow-y-scroll no-scrollbar">
                    <NewClaimCard />
                    <ClaimCard v-for="(claim, index) in claims" :key="index" :claim="claim" />
                </div>
                <div v-else class="p-10 w-2/3 flex items-center justify-center">
                    <OilWellAnimatedGray class="w-20 h-20" />
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
import ClaimsAside from './Partials/ClaimsAside.vue';
import ClaimCard from './Partials/ClaimCard.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import OilWellAnimatedGray from '@/Components/Icons/OilWellAnimatedGray.vue';
import NewClaimCard from './Partials/NewClaimCard.vue';
import ClaimsFilters from './Partials/ClaimsFilters.vue';

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
