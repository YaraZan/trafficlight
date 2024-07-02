<template>
    <div
        class="
        w-[calc(100vw-20px)]
        md:w-[500px]
        flex flex-col border border-gray-200 dark:border-gray-700 rounded-xl font-montserrat overflow-visible">

        <template v-if="detailClaim && !detailClaimLodaing">
            <div class="p-5 flex flex-col items-center justify-center gap-5 border-b border-gray-200 dark:border-gray-700">
                <span class=" text-xl text-gray-800 dark:text-white font-semibold">Просмотр заявки от {{ detailClaim.claim.Dat }}</span>
            </div>

            <!-- Well -->
            <div class="p-5 w-full flex flex-col gap-3 border-b border-gray-200 dark:border-gray-700">
                <span class="text-sm text-gray-800 dark:text-white font-semibold">Скважина</span>
                <WellTab :data="detailClaim.claim"/>
            </div>

            <!-- Category -->
            <div class="p-5 w-full flex flex-col gap-3 border-b border-gray-200 dark:border-gray-700">
                <span class="text-sm text-gray-800 dark:text-white font-semibold">Категория</span>
                <CategoryTab :data="detailClaim.claim"/>
            </div>

            <!-- User -->
            <div class="p-5 w-full flex flex-col gap-3 border-b border-gray-200 dark:border-gray-700">
                <span class="text-sm text-gray-800 dark:text-white font-semibold">Пользователь</span>
                <UserTab :data="detailClaim.claim" />
            </div>

            <!-- Values -->
            <div class="p-5 w-full flex flex-col gap-3 border-b border-gray-200 dark:border-gray-700">
                <span class="text-sm text-gray-800 dark:text-white font-semibold">Изменение</span>
                <ValuesTab :data="detailClaim.claim" />
            </div>

            <div class="p-5 w-full flex flex-col gap-3">
                <span class="text-sm text-gray-800 dark:text-white font-semibold">Комментарий</span>
                <div class="flex items-center justify-center gap-4 p-5 bg-gray-100 dark:bg-gray-900 rounded-md">
                    <span class="text-sm text-normal text-gray-400">{{ detailClaim.claim.Comment }}</span>
                </div>
            </div>

            <!-- Action -->
            <div class="p-5 w-full flex items-center gap-1 border-t border-gray-200 dark:border-gray-700">
                <DeleteClaimWindow
                    v-if="detailClaim.permissions.canDelete"
                    @delete="handleClaimDeleted"
                    @error="handleClaimNotDeleted"
                    :claim="props.claim" />

                <template v-if="detailClaim.permissions.canConsider">
                    <DeclineClaimWindow
                        @decline="handleClaimDeclined"
                        @error="handleClaimNotDeclined"
                        :claim="props.claim"
                        />

                    <ConsiderClaimWindow
                        @consider="handleClaimConsidered"
                        @error="handleClaimNotConsidered"
                        :claim="props.claim"/>
                </template>
            </div>

        </template>

        <div v-if="detailClaimLodaing" class="p-20 flex items-center justify-center">
            <Spinner class="fill-gray-800 dark:fill-white" />
        </div>

    </div>
</template>

<script setup>
import axios from 'axios';
import { computed, onMounted, ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Spinner } from 'flowbite-vue';
import UserTab from './UserTab.vue';
import WellTab from './WellTab.vue';
import CategoryTab from './CategoryTab.vue';
import ValuesTab from './ValuesTab.vue';
import DeleteClaimWindow from './DeleteClaimWindow.vue';
import ConsiderClaimWindow from './ConsiderClaimWindow.vue';
import DeclineClaimWindow from './DeclineClaimWindow.vue';

const props = defineProps(['claim']);
const emit = defineEmits([
    'claim-deleted-success',
    'claim-deleted-error',
    'claim-considered-success',
    'claim-considered-error',
    'claim-declined-success',
    'claim-declined-error'
 ]);

const detailClaim = ref(null);
const detailClaimLodaing = ref(false);

function fetchDetailClaimData() {
    detailClaimLodaing.value = true;

    axios.get('/api/claims/getClaimDetails', {
        params: {
            claim_id: props.claim.Id
        }
    }).then(res => {
        detailClaim.value = res.data;

        detailClaimLodaing.value = false;
    }).catch(err => {
        // handle
        detailClaimLodaing.value = false;
    })
}

function handleClaimDeleted() {
    emit('claim-deleted-success');
}

function handleClaimNotDeleted() {
    emit('claim-deleted-error');
}

function handleClaimConsidered() {
    emit('claim-considered-success');
}

function handleClaimNotConsidered() {
    emit('claim-considered-error');
}

function handleClaimDeclined() {
    emit('claim-declined-success');
}

function handleClaimNotDeclined() {
    emit('claim-declined-error');
}

onMounted(() => {
    fetchDetailClaimData();
})
</script>
