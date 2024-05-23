<template>
    <div class="w-full p-10 min-h-[300px] flex flex-col items-center justify-center gap-10 rounded-lg bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center gap-4">
            <span class="text-[52px] bg-gradient-to-r from-lime-400 to-green-500 font-bold bg-clip-text text-transparent">{{ totalClaims }}</span>
            <span class="text-[14px] text-gray-500 dark:text-gray-300 font-normal">Заявок создано</span>
        </div>
        <div class="flex items-center gap-20">
            <div class="flex items-center gap-4">
                <span class="text-[16px] font-semibold text-green-500">{{ wellsWorked }}</span>
                <span class="text-[14px] font-normal dark:text-gray-300 text-gray-500">Скважин задействовано</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-[16px] font-semibold text-green-500">{{ usersWorked }}</span>
                <span class="text-[14px] font-normal dark:text-gray-300 text-gray-500">Человек задействовано</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

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
