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

        <div class="flex p-4 w-full flex-col gap-[10px]">

            <!-- Header -->
            <ClaimsHeader v-if="!claimsLoading" :claims="claims" />
            <div v-else class="border border-dashed border-gray-300 dark:border-gray-700 w-full h-[300px] p-10 flex flex-col items-center justify-center gap-16 rounded-lg" >
                <OilWellAnimatedGray class="w-20 h-20" />
            </div>

            <div class="w-full flex items-center justify-between">

            </div>

            <!-- Claims -->
            <div class="w-full flex justify-between">
                <div v-if="!claimsLoading" class="relative w-2/3 grid grid-cols-3 gap-[10px] overflow-auto max-h-[500px] pr-5">
                    <!-- Add new claim -->
                    <div class="group bg-gray-50 flex flex-col gap-2 items-center justify-center rounded-md border-2 border-dashed border-gray-300 hover:border-green-400 cursor-pointer">
                        <svg class="w-10 h-10 stroke-gray-400 group-hover:stroke-green-400" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.125 5.08179V19.0818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M5.125 12.0818H19.125" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="text-[14px] text-gray-400 group-hover:text-green-400 font-semibold">Новая заявка</span>
                    </div>
                    <ClaimCard v-for="(claim, index) in claims" :key="index" :claim="claim" />
                    <div class=""></div>
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
