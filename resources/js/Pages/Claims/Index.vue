<template>
    <Head title="Заявки" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('claims')">
                <BreadCrumb
                    :name="'Заявки'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="w-full relative flex flex-col h-[calc(100vh-90px)]">

            <!-- Filters -->
            <div class="fixed p-4 pr-[91px] shadow dark:border-b z-30 w-full h-max gap-2 border-t border-gray-200 dark:border-gray-700 flex items-center bg-white dark:bg-gray-800">
                <NgduFilter v-if="canViewNgdu" @change="handleChangeNgdu" />
                <StatusFilter @change="handleChangeStatus" />
                <ClaimsFilters
                    @change-sorting="handleChangeSorting"
                    @change-radio="handleChangeRadio"
                    @change-date="handleChangeDate" />
                <ExportCsv :claims="claims" />
                <button @click="showCreateNewClaimWindow = !showCreateNewClaimWindow" class="ml-auto px-3 py-1 self-stretch bg-green-600 border border-green-400 dark:hover:bg-opacity-80 hover:bg-green-700 text-sm text-white font-semibold rounded-lg">
                    Новая
                </button>
            </div>

            <!-- Claims body -->
            <template v-if="claims.length > 0">
                <div class="p-4 w-full flex flex-col gap-4 items-center justify-center mt-24">
                    <div class="relative w-full grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-4 gap-[10px] pr-5 overflow-y-scroll no-scrollbar">
                        <NewClaimCard @click="showCreateNewClaimWindow = !showCreateNewClaimWindow" />
                        <ClaimCard v-for="(claim, index) in claims" :key="index" @click="viewClaim(claim)" :claim="claim" />
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
            <CreateNewClaimWindow
                @created="handleClaimCreated"
                @error="handleClaimError" />
        </Modal>
        <Modal :custom-styles="'mt-14'" :show="showViewClaimWindow" @close="showViewClaimWindow = false">
            <ViewClaimWindow
                @claim-deleted-success="handleClaimDeleted"
                @claim-deleted-error="handleClaimNotDeleted"
                @claim-considered-success="handleClaimConsidered"
                @claim-considered-error="handleClaimNotConsidered"
                @claim-declined-success="handleClaimDeclined"
                @claim-declined-error="handleClaimNotDeclined"
            :claim="viewingClaim" />
        </Modal>

        <Banners v-model="bannersState" />
    </AuthorizedLayout>
</template>

<script setup>
import {Head, Link} from '@inertiajs/vue3';
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
import ViewClaimWindow from './Partials/ViewClaimWindow/ViewClaimWindow.vue';
import ClaimCardSkeleton from './Partials/ClaimList/ClaimCardSkeleton.vue';
import Banners from './Partials/Banners.vue';
import ClaimsFilters from './Partials/ClaimsFilters/ClaimsFilters.vue';
import ExportCsv from './Partials/ExportCsv.vue';

const props = defineProps({
    canViewNgdu: {
        type: Boolean
    }
})

const SKIP_INIT = 0;
const AMOUNT_INIT = 30;

const claims = ref([]);
const skip = ref(SKIP_INIT);
const amount = ref(AMOUNT_INIT);
const claimsLoading = ref(false);
const showCreateNewClaimWindow = ref(false);
const showViewClaimWindow = ref(false);

/* BannerState */
const bannersState = ref('');

/* Selected Claim */
const viewingClaim = ref(null);

/* Filter refs */
const ngduFilters = ref([]);
const statusFilters = ref([]);
const sortingType = ref('');
const radioType = ref('');
const dateFilter = ref([]);

/* View claim */
function viewClaim(claim) {
    viewingClaim.value = claim;
    showViewClaimWindow.value = true;
}

/* Create and delete handers */
function handleClaimCreated() { // 200
    showCreateNewClaimWindow.value = false;
    bannersState.value = 'claims:claim-created';

    handleUpdates();
}

function handleClaimError() {
    showCreateNewClaimWindow.value = false;
    bannersState.value = 'claims:claim-not-created';
}

function handleClaimDeleted() { // 200
    showViewClaimWindow.value = false;
    bannersState.value = 'claims:claim-deleted';

    handleUpdates();
}

function handleClaimNotDeleted() {
    showViewClaimWindow.value = false;
    bannersState.value = 'claims:claim-not-deleted';
}

function handleClaimConsidered() { // 200
    showViewClaimWindow.value = false;
    bannersState.value = 'claims:claim-considered';

    handleUpdates();
}

function handleClaimNotConsidered() {
    showViewClaimWindow.value = false;
    bannersState.value = 'claims:claim-not-considered';
}

function handleClaimDeclined() { // 200
    showViewClaimWindow.value = false;
    bannersState.value = 'claims:claim-declined';

    handleUpdates();
}

function handleClaimNotDeclined() {
    showViewClaimWindow.value = false;
    bannersState.value = 'claims:claim-not-declined';
}

/* Change handlers */
function handleChangeNgdu(ngdus) {
    ngduFilters.value = ngdus;
}

function handleChangeStatus(statuses) {
    statusFilters.value = statuses;
}

function handleChangeSorting(sorting) {
    sortingType.value = sorting;
}

function handleChangeRadio(radio) {
    radioType.value = radio;
}

function handleChangeDate(date) {
    dateFilter.value = date;
}

/* Helper funcs */
function loadClaims() {
    claimsLoading.value = true;

    axios.get(`/api/claims/get`, {
        params: {
            skip: skip.value,
            amount: amount.value,
            ngdus: ngduFilters.value,
            statuses: statusFilters.value,
            sorting: sortingType.value.code,
            radio: radioType.value.code,
            dates: dateFilter.value,
        }
    })
    .then((res) => {
        if (res.data.length === 0 && claims.value.length !== 0) {
            bannersState.value = 'claims:no-new-claims';
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

function handleUpdates() {
    claims.value = [];
    skip.value = SKIP_INIT;
    loadClaims();
}

watch([ngduFilters, statusFilters, sortingType, radioType, dateFilter], () => {
    handleUpdates();
}, { deep: true });
</script>
