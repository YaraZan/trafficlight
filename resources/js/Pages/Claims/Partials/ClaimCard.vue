<template>
    <div class="px-5 pt-5 flex flex-col gap-6 bg-white rounded-xl shadow border border-gray-200 dark:border-gray-700 dark:bg-gray-900 hover:border-green-400 dark:hover:border-green-400">

        <div class="w-full flex flex-col gap-2">
            <div class="flex items-center gap-2">
                <svg :class="claim.OldValue <= claim.Value ? 'fill-green-500' : 'fill-red-500 rotate-180'"
                    class="w-5 h-5" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.56699 0.75C3.75944 0.416666 4.24056 0.416667 4.43301 0.75L7.03109 5.25C7.22354 5.58333 6.98298 6 6.59808 6H1.40192C1.01702 6 0.776461 5.58333 0.968911 5.25L3.56699 0.75Z"/>
                </svg>
                <span class="text-[16px] text-gray-800 dark:text-white font-bold">{{ claim.CatName }}</span>
                <span v-if="claim.OldValue" class="text-[16px] text-gray-800 dark:text-white font-bold">{{ claim.OldValue }}</span>
                <span v-else class="p-1 bg-gray-100 dark:bg-gray-800 text-[16px] text-red-500 font-semibold rounded-md">Пусто</span>
                <span class="text-[16px] text-gray-800 dark:text-white font-bold">-></span>
                <span v-if="claim.Value" class="text-[16px] text-gray-800 dark:text-white font-bold">{{ claim.Value }}</span>
                <span v-else class="p-1 bg-gray-100 dark:bg-gray-800 text-[16px] text-red-500 font-semibold rounded-md">Пусто</span>
            </div>

            <Link class="w-max" :href="route('matrix.detail', claim.WellPublicId)">
                <span class="text-[14px] text-green-500 hover:text-green-800 font-semibold">{{ claim.WellName }}</span>
            </Link>
        </div>

        <div class="w-full flex items-center flex-wrap gap-2">
            <span class="text-[14px] text-gray-800 dark:text-gray-300 font-normal whitespace-nowrap">{{ claim.UserName }}</span>
            <span class="text-[14px] text-gray-400 font-normal whitespace-nowrap">{{ claim.Dat }}</span>
        </div>

        <div class="w-full p-5 flex items-center justify-center border-t border-gray-200 dark:border-gray-700">
            <span :class="`text-${claim.StatusColor}-500`" class="text-sm font-semibold">{{ claim.StatusName }}</span>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    claim: Object
})
</script>
