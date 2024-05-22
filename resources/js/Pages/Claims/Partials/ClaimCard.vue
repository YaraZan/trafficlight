<template>
    <div class="bg-wjite rounded-md shadow dark:bg-gray-900 p-5">
        <div class="flex items-center gap-4">
            <svg
                :class="claim.OldValue <= claim.Value ? 'fill-green-400' : 'fill-red-400 rotate-180'"
                class="w-5 h-5" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.56699 0.75C3.75944 0.416666 4.24056 0.416667 4.43301 0.75L7.03109 5.25C7.22354 5.58333 6.98298 6 6.59808 6H1.40192C1.01702 6 0.776461 5.58333 0.968911 5.25L3.56699 0.75Z"/>
            </svg>
            <span class="text-[16px] text-gray-800 dark:text-white font-bold">{{ claim.CatName }}</span>
            <span class="text-[16px] text-gray-800 dark:text-white font-bold">{{ claim.OldValue }}</span>
            <span class="text-[16px] text-gray-800 dark:text-white font-bold">-></span>
            <span class="text-[16px] text-gray-800 dark:text-white font-bold">{{ claim.Value }}</span>
        </div>
    </div>
</template>

<script setup>
defineProps({
    claim: Object
})
</script>
