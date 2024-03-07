<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import OilWellAnimatedIcon from "@/Components/Icons/OilWellAnimatedIcon.vue";
import { Head } from '@inertiajs/vue3';
import axios from "axios";
import {computed, onMounted, ref} from "vue";
import ControlCategories from "@/Pages/Matrix/Partials/ControlCategories.vue";
import ControlClaims from "@/Pages/Matrix/Partials/ControlClaims.vue";
import WellClaimHistory from "@/Pages/Matrix/Partials/WellClaimHistory.vue";

const props = defineProps({
    item: {
        type: Object,
        required: true,
    }
});

const categories = ref([]);
const claims = ref([]);
const wellClaims = ref([]);

const categoriesLoading = ref(false);
const claimsLoading = ref(false);
const wellClaimsLoading = ref(false);

const paginationSource = ref('История')
const paginationSourceTypes = ['История', 'Ваши заявки']

const fetchUserClaims = () => {

    claimsLoading.value = true;

    return axios.get(`/api/control/${props.item.public_id}/claims`)
        .then((response) => {
            claims.value = response.data;
        })
        .catch((error) => {
            console.error('Ошибка', error);
        })
        .finally(() => {
            claimsLoading.value = false;
        });
};
const fetchWellClaims = () => {

    wellClaimsLoading.value = true;

    return axios.get(`/api/control/${props.item.public_id}/well-claims`)
        .then((response) => {
            wellClaims.value = response.data;
        })
        .catch((error) => {
            console.error('Ошибка', error);
        })
        .finally(() => {
            wellClaimsLoading.value = false;
        });
};
const fetchWellCategories = () => {

    categoriesLoading.value = true;

    return axios.get(`/api/control/${props.item.public_id}/categories`)
        .then((response) => {
            categories.value = response.data;
        })
        .catch((error) => {
            console.error('Ошибка', error);
        })
        .finally(() => {
            categoriesLoading.value = false;
        });
};

onMounted(() => {
    fetchUserClaims()
    fetchWellCategories()
    fetchWellClaims()
})

const handleChangedCategory = () => {
    fetchUserClaims()
    fetchWellCategories()
    fetchWellClaims()
}

const countConfirmedClaims = (claims) => {
    let count = 0;

    claims.forEach(claim => claim.StatusName === 'Выполнено' && count++)

    return count
}

const countDeniedClaims = (claims) => {
    let count = 0;

    claims.forEach(claim => claim.StatusName === 'Отклонено' && count++)

    return count
}

</script>

<template>
    <Head title="Управление" />

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
            <Link :href="route('matrix.control', item.public_id)">
                <BreadCrumb
                :name="'Управление'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full flex justify-center">

            <div class="w-full flex flex-col p-4">

                <div class="w-full flex p-4 rounded-[20px] bg-gray-100 dark:bg-gray-900 gap-[10px]">

                    <div class="relative w-1/3 flex flex-col items-center justify-center gap-4">
                        <OilWellAnimatedIcon/>
                        <code class="bg-gray-200 dark:bg-gray-800 rounded-[10px] p-2 text-[18px] font-semibold text-gray-800 dark:text-white">
                            {{ item.Name }}</code>
                        <div class="absolute top-4 left-4 flex items-center gap-4">
                            <div class="group flex items-center gap-1 relative">
                                <div class="absolute rounded-md hidden group-hover:flex items-center justify-center p-2 top-[110%] bg-gray-900 border border-gray-700">
                                    <span class="text-white font-bold text-[12px]">Принятые заявки</span>
                                </div>
                                <div class="bg-green-400 rounded-full w-[10px] h-[10px]"></div>
                                <span class="text-gray-400 text-[14px] font-normal">{{ countConfirmedClaims(claims) }}</span>
                            </div>
                            <div class="group flex items-center gap-1 relative">
                                <div class="absolute rounded-md hidden group-hover:flex items-center justify-center p-2 top-[110%] bg-gray-900 border border-gray-700">
                                    <span class="text-white font-bold text-[12px]">Отклонённые заявки</span>
                                </div>
                                <div class="bg-red-400 rounded-full w-[10px] h-[10px]"></div>
                                <span class="text-gray-400 text-[14px] font-normal">{{ countDeniedClaims(claims) }}</span>
                            </div>
                        </div>
                    </div>

                    <ControlCategories v-if="!categoriesLoading" @created="handleChangedCategory" :item="item" :categories="categories" />

                    <div v-else class="w-full grid grid-cols-3 gap-[5px]">
                        <div
                            v-for="(_, index) in Array.from({ length: 6 })"
                            :key="index"
                            class="animate-pulse bg-white dark:bg-gray-800 rounded-lg flex flex-col justify-between p-5
                 bg-opacity-60 h-[150px] relative">
                    </div>
                    </div>

                </div>

                <div class="w-full flex p-4 gap-10">

                    <WellClaimHistory v-if="!wellClaimsLoading" :claims="wellClaims"/>

                    <div v-else class="w-1/2 grid-cols-1 grid-rows-4 gap-[5px]">
                        <div
                            v-for="(_, index) in Array.from({ length: 4 })"
                            :key="index"
                            class="animate-pulse bg-gray-100 dark:bg-gray-900 rounded-lg flex flex-col justify-between p-5
                 relative">
                        </div>
                    </div>

                    <ControlClaims v-if="!claimsLoading" @deleted="fetchUserClaims" :claims="claims"/>

                    <div v-else class="w-1/2 grid-cols-1 grid-rows-4 gap-[5px]">
                        <div
                            v-for="(_, index) in Array.from({ length: 4 })"
                            :key="index"
                            class="animate-pulse bg-gray-100 dark:bg-gray-900 rounded-lg flex flex-col justify-between p-5
                 relative">
                        </div>
                    </div>

                </div>


            </div>

        </div>

    </AuthorizedLayout>
</template>
