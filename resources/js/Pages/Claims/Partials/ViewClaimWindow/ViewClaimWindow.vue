<template>
    <div
        class="
        w-[calc(100vw-20px)]
        md:w-[500px]
        flex flex-col border border-gray-200 dark:border-gray-700 rounded-xl font-montserrat overflow-visible">

        <template v-if="detailClaim && !detailClaimLodaing">
            <div class="p-5 flex flex-col items-center justify-center gap-5 border-b border-gray-200 dark:border-gray-700">
                <span class=" text-xl text-gray-800 dark:text-white font-semibold">Просмотр заявки от {{ detailClaim.Dat }}</span>
            </div>

            <!-- Well -->
            <div class="p-5 w-full flex flex-col gap-3 border-b border-gray-200 dark:border-gray-700">
                <span class="text-sm text-gray-800 dark:text-white font-semibold">Скважина</span>
                <WellTab :data="detailClaim"/>
            </div>

            <!-- Category -->
            <div class="p-5 w-full flex flex-col gap-3 border-b border-gray-200 dark:border-gray-700">
                <span class="text-sm text-gray-800 dark:text-white font-semibold">Категория</span>
                <CategoryTab :data="detailClaim"/>
            </div>

            <!-- User -->
            <div class="p-5 w-full flex flex-col gap-3 border-b border-gray-200 dark:border-gray-700">
                <span class="text-sm text-gray-800 dark:text-white font-semibold">Пользователь</span>
                <UserTab :data="detailClaim" />
            </div>

            <!-- Values -->
            <div class="p-5 w-full flex flex-col gap-3">
                <span class="text-sm text-gray-800 dark:text-white font-semibold">Изменение</span>
                <ValuesTab :data="detailClaim" />
            </div>

            <!-- Action -->
            <div class="p-5 w-full flex items-center gap-1 border-t border-gray-200 dark:border-gray-700">
                <button class="group ease-in hover:bg-red-500 dark:hover:bg-red-500 focus:bg-red-500 dark:focus:bg-red-500 p-1 w-full flex items-center justify-center gap-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 shadow rounded-lg outline-none">
                    <svg class="stroke-red-500 group-hover:stroke-white dark:group-hover:stroke-white group-focus:stroke-white dark:group-focus:stroke-white" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 9.84488H4.37314C5.3542 9.84488 6.1495 10.3707 6.1495 11.0193V25.2656C6.1495 25.9142 6.9448 26.44 7.92586 26.44H23.7222C24.7032 26.44 25.4985 25.9142 25.4985 25.2656V11.0193C25.4985 10.3707 25.859 9.84488 26.84 9.84488H29M9.02571 7H22.0994M12.4249 18.8536V13.638M19.2232 18.8536V13.638" stroke-width="2.56438" stroke-linecap="round"/>
                    </svg>
                    <span class="text-sm font-semibold text-red-500 group-hover:text-white dark:group-hover:text-white group-focus:text-white dark:group-focus:text-white">Удалить</span>
                </button>

                <button class="group ease-in hover:bg-red-500 dark:hover:bg-red-500 focus:bg-red-500 dark:focus:bg-red-500 p-1 w-full flex items-center justify-center gap-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 shadow rounded-lg outline-none">
                    <svg class="stroke-red-500 group-hover:stroke-white dark:group-hover:stroke-white group-focus:stroke-white dark:group-focus:stroke-white" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.2927 20.0976L16.1951 16M16.1951 16L20.0976 11.9024M16.1951 16L20.0976 20.0976M16.1951 16L12.2927 11.9024M8.19513 23.4146V8.58537C8.19513 8.36985 8.36985 8.19513 8.58537 8.19513H23.4146C23.6302 8.19513 23.8049 8.36985 23.8049 8.58537V23.4146C23.8049 23.6302 23.6302 23.8049 23.4146 23.8049H8.58537C8.36985 23.8049 8.19513 23.6302 8.19513 23.4146Z" stroke-width="1.59071" stroke-linecap="round"/>
                    </svg>
                    <span class="text-sm font-semibold text-red-500 group-hover:text-white dark:group-hover:text-white group-focus:text-white dark:group-focus:text-white">Отклонить</span>
                </button>

                <button class="group ease-in hover:bg-purple-500 dark:hover:bg-purple-500 focus:bg-purple-500 dark:focus:bg-purple-500 p-1 w-full flex items-center justify-center gap-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 shadow rounded-lg outline-none">
                    <svg class="stroke-purple-500 group-hover:stroke-white dark:group-hover:stroke-white group-focus:stroke-white dark:group-focus:stroke-white" width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.70728 21.1013C7.83507 21.9958 14.5316 25.7325 15.5126 26.2756C15.5938 26.3205 15.6807 26.3415 15.7735 26.3415H21.9756C22.3074 26.3415 22.5643 26.0526 22.523 25.7234C22.3661 24.474 22.0168 21.704 21.911 20.9634M7.70728 21.1013L21.911 20.9634M7.70728 21.1013C7.70728 20.6896 8.42437 19.151 9.14489 17.709M21.911 20.9634C21.911 20.627 21.2217 19.1419 20.5157 17.709M19.0151 14.7579L14.0507 14.8393M19.0151 14.7579C19.0151 14.7579 19.7746 16.2047 20.5157 17.709M19.0151 14.7579L18.729 11.4207M14.0507 14.8393L10.9265 14.8905C10.7268 14.8938 10.5448 15.0043 10.451 15.1806C10.1992 15.6541 9.67112 16.6558 9.14489 17.709M14.0507 14.8393L14.9152 11.4207M9.14489 17.709H20.5157M14.9152 11.4207L15.1865 10.3478C15.2484 10.1029 15.4687 9.9314 15.7212 9.9314H18.095C18.3814 9.9314 18.6202 10.1506 18.6446 10.4359L18.729 11.4207M14.9152 11.4207C14.9152 11.4207 12.1752 10.4278 12.5062 8.44208C12.8372 6.45632 14.9332 5.46344 16.9742 5.46344C19.0151 5.46344 20.7802 6.45632 21.4421 8.44208C22.104 10.4278 18.729 11.4207 18.729 11.4207" stroke-width="1.6548" stroke-linecap="round"/>
                    </svg>
                    <span class="text-sm font-semibold text-purple-500 group-hover:text-white dark:group-hover:text-white group-focus:text-white dark:group-focus:text-white">Утвердить</span>
                </button>
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
import { Spinner } from 'flowbite-vue';
import UserTab from './UserTab.vue';
import WellTab from './WellTab.vue';
import CategoryTab from './CategoryTab.vue';
import ValuesTab from './ValuesTab.vue';

const props = defineProps(['claim']);

const detailClaim = ref(null);
const detailClaimLodaing = ref(false);

const user = computed(() => {
    return { name: detailClaim.UserName, ngdu: detailClaim.UserNgduName, };
})

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

onMounted(() => {
    fetchDetailClaimData();
})
</script>
