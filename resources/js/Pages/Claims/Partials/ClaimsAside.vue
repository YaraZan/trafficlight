<template>
    <div class="w-1/3 overflow-y-scroll flex flex-col gap-[10px] h-full no-scrollbar rounded-2xl bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
        <div class="p-10 flex flex-col gap-2 border-b border-gray-200 dark:border-gray-700">
            <div class="w-full flex items-center gap-2">
                <div class="flex flex-col gap-1">
                    <span class="text-[52px] text-green-400 font-semibold leading-[92px]">{{ totalClaims }}</span>
                    <span class="text-sm text-gray-800 dark:text-white font-semibold">Заявок создано</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[52px] text-green-400 font-semibold leading-[92px]">{{ wellsWorked }}</span>
                    <span class="text-sm text-gray-800 dark:text-white font-semibold">Скважин задействовано</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[52px] text-green-400 font-semibold leading-[92px]">{{ usersWorked }}</span>
                    <span class="text-sm text-gray-800 dark:text-white font-semibold">Человек задействовано</span>
                </div>
            </div>

            <TotalClaimsCreatedChart :claims="claims" />
        </div>

        <div class="p-10 flex flex-col gap-2 border-b border-gray-200 dark:border-gray-700">

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
