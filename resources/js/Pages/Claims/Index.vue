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

        <div class="w-full relative flex flex-col h-[calc(100vh-90px)]">

            <!-- Filters -->
            <div class="fixed p-4 shadow dark:border-b z-50 w-full border-t border-gray-200 dark:border-gray-700 flex items-center gap-4 bg-white dark:bg-gray-800">
                <NgduFilter @change="handleChangeNgdu" />
                <StatusFilter @change="handleChangeStatus" />
            </div>

            <!-- Claims body -->
            <template v-if="claims.length > 0">
                <div class="p-4 w-full flex flex-col gap-4 items-center justify-center mt-24">
                    <div class="relative w-full grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-[10px] pr-5 overflow-y-scroll no-scrollbar">
                        <NewClaimCard @click="showCreateNewClaimWindow = !showCreateNewClaimWindow" />
                        <ClaimCard v-for="(claim, index) in claims" :key="index" :claim="claim" />
                    </div>
                    <div class="w-full flex flex-col py-10 items-center justify-center">
                        <LoadMoreClaims @click="loadMoreClaims" />
                    </div>
                </div>
            </template>

            <!-- No data -->
            <NoData v-else-if="!claimsLoading && claims.length === 0">
                <NewClaimCard @click="showCreateNewClaimWindow = !showCreateNewClaimWindow" />
            </NoData>

            <!-- Loading -->
            <div v-if="claimsLoading" class="p-4 mt-24 w-full grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-[10px] pr-5 overflow-y-scroll no-scrollbar">
                <ClaimCardSkeleton/>
            </div>
        </div>

        <Modal :custom-styles="'mt-20'" :show="showCreateNewClaimWindow" @close="showCreateNewClaimWindow = false">
            <CreateNewClaimWindow />
        </Modal>
        <Modal :show="showEditClaimWindow" @close="showEditClaimWindow = false">

        </Modal>

        <Banner :show="showAllClaimsLoadedWarn" text="Новых заявок нет." type="warn"/>
    </AuthorizedLayout>
</template>

<script setup>
import {Head, Link} from '@inertiajs/vue3';
import { Spinner } from 'flowbite-vue';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import LoadMoreClaims from './Partials/ClaimList/LoadMoreClaims.vue';
import ClaimCard from './Partials/ClaimList/ClaimCard.vue';
import { computed, onMounted, ref, watch } from 'vue';
import axios from 'axios';
import NewClaimCard from './Partials/ClaimList/NewClaimCard.vue';
import NoData from './Partials/ClaimList/NoData.vue';
import NgduFilter from './Partials/ClaimList/NgduFilter.vue';
import StatusFilter from './Partials/ClaimList/StatusFilter.vue';
import Modal from '@/Components/Modal.vue';
import CreateNewClaimWindow from './Partials/CreateNewClaimWindow/CreateNewClaimWindow.vue';
import ClaimCardSkeleton from './Partials/ClaimList/ClaimCardSkeleton.vue';
import Banner from '@/Components/Banners/Banner.vue';

const SKIP_INIT = 0;
const AMOUNT_INIT = 10;

const claims = ref([]);
const skip = ref(SKIP_INIT);
const amount = ref(AMOUNT_INIT);
const claimsLoading = ref(false);
const showCreateNewClaimWindow = ref(false);
const showEditClaimWindow = ref(false);

/* Handle exceptions */
const showAllClaimsLoadedWarn = ref(false);

/* Filter refs */
const ngduFilters = ref([]);
const statusFilters = ref([]);

/* Change handlers */
function handleChangeNgdu(ngdus) {
    ngduFilters.value = ngdus;
}

function handleChangeStatus(statuses) {
    statusFilters.value = statuses;
}

/* Helper funcs */
function loadClaims() {
    claimsLoading.value = true;

    axios.get(`/api/claims/get`, {
        params: {
            skip: skip.value,
            amount: amount.value,
            ngdus: ngduFilters.value,
            statuses: statusFilters.value
        }
    })
    .then((res) => {

        if (res.data.length === 0 && ngduFilters.value.length === 0 && statusFilters.value.length === 0) {
            showAllClaimsLoadedWarn.value = true;
            setTimeout(() => {
                showAllClaimsLoadedWarn.value = false;
            }, 7000);
            claimsLoading.value = false;

            return;
        }

        res.data.forEach(item => {
            claims.value.push(item)
        });

        claimsLoading.value = false;
    })
    .catch((error) => {
        claimsLoading.value = false;
    });
}

function loadMoreClaims() {
    skip.value += amount.value;
    loadClaims();
}

onMounted(() => {
    loadClaims();
});

watch([ngduFilters, statusFilters], () => {
    claims.value = [];
    skip.value = SKIP_INIT;
    loadClaims();
}, { deep: true });
</script>
