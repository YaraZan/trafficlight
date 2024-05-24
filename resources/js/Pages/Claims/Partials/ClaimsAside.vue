<template>
    <div class="w-1/3 overflow-y-scroll flex flex-col gap-[10px] h-full no-scrollbar">
        <div class="p-10 flex flex-col gap-2 rounded-lg bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
            <span class="text-[92px] bg-gradient-to-r from-lime-300 to-green-400 font-bold bg-clip-text text-transparent w-max leading-[92px]">{{ totalClaims }}</span>
            <span class="text-[22px] text-gray-800 dark:text-white font-semibold">Заявок создано</span>
<!--             <TotalClaimsCreatedChart :claims="claims" /> -->
        </div>
        <div class="p-10 flex flex-col gap-2 rounded-lg bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-900 justify-end">
            <span class="text-[92px] bg-gradient-to-r from-lime-300 to-green-400 font-bold bg-clip-text text-transparent w-max leading-[92px]">{{ wellsWorked }}</span>
            <span class="text-[22px] text-gray-800 dark:text-white font-semibold">Скважин задействовано</span>
        </div>
        <div class="p-10 flex flex-col gap-2 rounded-lg bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-900 justify-end">
            <span class="text-[92px] bg-gradient-to-r from-lime-300 to-green-400 font-bold bg-clip-text text-transparent w-max leading-[92px]">{{ usersWorked }}</span>
            <span class="text-[22px] text-gray-800 dark:text-white font-semibold">Человек задействовано</span>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import TotalClaimsCreatedChart from './TotalClaimsCreatedChart.vue';

const props = defineProps({
    claims: {
        type: Array
    }
})

const totalClaims = computed(() => {
    return props.claims.length;
});

const wellsWorked = computed(() => {
    return new Set(props.claims.map(claim => claim.WellName )).size;
});

const usersWorked = computed(() => {
    return new Set(props.claims.map(claim => claim.UserName )).size;
});
</script>
