<script setup>

import {computed, ref, watch} from "vue";

const props = defineProps({
    categories: {
        type: Object,
        required: true,
    }
});

const currentPage = ref(1);
const perPage = ref(8);

const totalPages = computed(() => {
    return Math.ceil(props.categories.length / perPage.value);
});

const paginatedData = computed(() => {
    const data = props.categories || []

    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;


    return data.slice(start, end);
});

const visiblePages = computed(() => {
    const totalVisiblePages = 5;
    const pages = [];
    let startPage;

    if (totalPages.value <= totalVisiblePages) {
        startPage = 1;
    } else if (currentPage.value <= 2) {
        startPage = 1;
    } else if (currentPage.value >= totalPages.value - 2) {
        startPage = totalPages.value - totalVisiblePages + 1;
    } else {
        startPage = currentPage.value - Math.floor(totalVisiblePages / 2);
    }

    for (let i = 0; i < totalVisiblePages && startPage <= totalPages.value; i++) {
        pages.push(startPage);
        startPage++;
    }

    return pages;
});

const setCurrentPage = (page) => {
    currentPage.value = page;
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

</script>

<template>
    <div class="w-full flex flex-col gap-4">

        <div class="w-full flex items-center justify-between">

            <span class="text-gray-300 dark:text-gray-600 text-[13px] font-semibold">Ваши заявки</span>

            <ul class="flex items-center ml-auto -space-x-px h-9 text-sm md:ml-0">
                <li>
                    <button @click="prevPage" :disabled="currentPage === 1" href="#" class="flex items-center justify-center px-3 h-9 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">Пред.</span>
                        <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                        </svg>
                    </button>
                </li>
                <li v-for="page in visiblePages" :key="page">
                    <button
                        @click="setCurrentPage(page)"
                        :class="{ 'font-bold text-green-600': currentPage === page }"
                        class="flex items-center justify-center px-3 h-9 leading-tight text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    >
                        {{ page }}
                    </button>
                </li>
                <li>
                    <button @click="nextPage" :disabled="currentPage === totalPages" href="#" class="flex items-center justify-center px-3 h-9 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">След.</span>
                        <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                    </button>
                </li>
            </ul>

        </div>

        <div class="grid grid-cols-4 grid-rows-2 gap-[5px]">
            <div v-if="paginatedData.length"
                 v-for="(category, index) in paginatedData"
                 :key="index"
                 class="flex items-center justify-between bg-white dark:bg-gray-900 p-4 rounded-lg">
                <div class="flex flex-col h-full justify-between">
                    <span class="text-[18px] font-black text-gray-800 dark:text-white">{{ category.CatNameShorted }}</span>
                    <span class="text-[14px] font-normal text-gray-800 dark:text-gray-400 max-w-[150px]">{{ category.CatName }}</span>
                </div>

                <div class="flex flex-col items-end h-full justify-between">
                    <code class="bg-gray-200 w-min dark:bg-gray-800 rounded-[10px] p-2 text-[20px] font-semibold">
                        {{ category.FactValue }}
                    </code>
                    <div class="flex items-center gap-2">
                        <span class="text-[14px] text-gray-400">АРМИТС</span>
                        <code v-if="category.ArmitsValue" class="bg-gray-200 w-min dark:bg-gray-800 rounded-[10px] p-2 text-[16px] font-semibold">
                            {{ category.ArmitsValue }}
                        </code>
                        <span v-else class="text-[14px] text-red-500 font-semibold">Пусто</span>
                    </div>
                </div>
            </div>

            <SkeletonDnmhTable v-else />
        </div>

    </div>
</template>

