<template>
    <div @click="newTab" class="w-full px-4 py-2 flex items-center gap-4 bg-white rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700
    hover:border-green-400 dark:hover:border-green-400 cursor-pointer">
        <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-900 flex items-center justify-center">
            <svg  width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path class="stroke-gray-400" d="M9.17072 26.7317L10.7317 22.4331M22.2439 26.7317L21.7877 25.561M21.7877 25.561L10.7317 22.4331M21.7877 25.561L19.3546 19.3171M10.7317 22.4331L12.7135 16.9756M19.3546 19.3171L17.1591 13.6828C16.5748 12.1835 14.4447 12.2082 13.8955 13.7207L12.7135 16.9756M19.3546 19.3171L12.7135 16.9756"  stroke-width="2.34146" stroke-linecap="round"/>
            <path class="stroke-gray-400" d="M7.80491 7.21954C7.80491 7.21954 2.34149 7.60979 2.34149 11.3171C2.34149 15.0244 7.80491 15.6098 7.80491 15.6098" stroke-width="2.34146" stroke-linecap="round"/>
            <path class="fill-gray-400" fill-rule="evenodd" clip-rule="evenodd" d="M24.7805 15.2196C26.0333 15.2196 27.2167 14.7919 28.0191 13.798C28.7452 12.8986 28.8781 11.8748 28.8781 11.2253C28.8781 10.5658 28.7399 9.49972 27.9017 8.60982C27.0417 7.69685 25.8702 7.41467 24.7805 7.41467C23.7991 7.41467 22.6033 7.6156 21.7028 8.52203C21.1923 9.03581 20.9337 9.61893 20.805 10.1464H7.02443C6.37785 10.1464 5.8537 10.6705 5.8537 11.3171C5.8537 11.9637 6.37785 12.4878 7.02443 12.4878H20.8461C20.9732 12.944 21.1947 13.4308 21.5753 13.8813C22.4228 14.8842 23.6307 15.2196 24.7805 15.2196ZM26.5366 11.2253C26.5366 11.9599 26.217 12.8781 24.7805 12.8781C23.3441 12.8781 23.0244 12.0743 23.0244 11.2253C23.0244 10.3762 23.3441 9.75614 24.7805 9.75614C26.217 9.75614 26.5366 10.4907 26.5366 11.2253Z" />
            </svg>
        </div>
        <div class="flex flex-col gap-1">
            <span class="text-sm text-gray-800 dark:text-white font-bold">{{ data.WellName }}</span>
            <span class="text-sm text-gray-400 font-normal">{{ data.NgduName }}</span>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps(['data']);

const newTab = (e) => {
    e.preventDefault();
    window.open(route('matrix.detail', props.data.WellPublicId));
}
</script>
