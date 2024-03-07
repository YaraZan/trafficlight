<script setup>
import axios from "axios";
import {computed, onMounted, ref} from "vue";
import ClearIcon from "@/Components/Icons/ClearIcon.vue";
import {Input, P, Spinner} from "flowbite-vue";
import Modal from "@/Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import NoDataIcon from "@/Components/Icons/NoDataIcon.vue";

const props = defineProps({
    claims: {
        type: Object,
        required: true,
    }
});

const currentPage = ref(1);
const perPage = ref(4);

const selectedOnDeletionClaim = ref(null)

const showDeletingClaimWindow = ref(false)

const totalPages = computed(() => {
    return Math.ceil(props.claims.length / perPage.value);
});

const paginatedData = computed(() => {
    const data = props.claims || []

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

const getStatusColor = (color) => {
    let statusColor = 'text-gray-400'
    switch (color) {
        case 'Выполнено':
            statusColor = 'text-green-500'
            break
        case 'Отклонено':
            statusColor = 'text-red-500'
            break
    }

    return statusColor
}

</script>

<template>
    <div v-if="claims.length > 0" class="w-1/2 flex flex-col gap-4">

        <div class="flex items-center justify-between">

            <span class="text-gray-300 dark:text-gray-600 text-[13px] font-semibold">История изменений</span>

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

        <div class="grid grid-cols-1 grid-rows-4 gap-[5px]">
            <div v-for="(claim, index) in paginatedData"
                 :key="index"
                 class="h-full p-4 bg-white dark:bg-gray-900 border border-gray-200
                 dark:border-gray-700
                 rounded-lg flex items-center justify-between shadow-sm gap-10">

                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-4">
                        <span class="text-[13px] text-gray-300 dark:text-gray-500 font-medium">{{ claim.UserName }}</span>
                        <span class="select-none text-[13px] text-gray-300 dark:text-gray-500 font-medium">·</span>
                        <span class="text-[13px] text-gray-300 dark:text-gray-500 font-medium">{{ claim.Dat }}</span>
                    </div>

                    <div class="flex items-center gap-4">
                        <svg
                            :class="claim.OldValue <= claim.Value
                    ? 'fill-green-400' : 'fill-red-400 rotate-180'
                    "
                            class="w-5 h-5" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.56699 0.75C3.75944 0.416666 4.24056 0.416667 4.43301 0.75L7.03109 5.25C7.22354 5.58333 6.98298 6 6.59808 6H1.40192C1.01702 6 0.776461 5.58333 0.968911 5.25L3.56699 0.75Z"/>
                        </svg>
                        <span class="text-[16px] text-gray-800 dark:text-white font-bold">{{ claim.CatName }}</span>
                        <span class="text-[16px] text-gray-800 dark:text-white font-bold">{{ claim.OldValue }}</span>
                        <span class="text-[16px] text-gray-800 dark:text-white font-bold">-></span>
                        <span class="text-[16px] text-gray-800 dark:text-white font-bold">{{ claim.Value }}</span>
                    </div>
                </div>

                <span class="text-[13px] font-semibold" :class="getStatusColor(claim.StatusName)">{{ claim.StatusName }}</span>


            </div>
            <div v-if="paginatedData.length < perPage"
                 v-for="(_, index) in Array.from({ length: perPage - paginatedData.length })"
                 :key="index"
                 class="group border border-dashed border-gray-300 dark:border-gray-700 rounded-lg flex flex-col justify-between p-5
                 relative">
            </div>
        </div>
    </div>

    <div v-else class="w-1/2 h-full flex flex-col gap-4 items-center justify-center mt-[120px] rounded-lg
        ">
        <NoDataIcon/>
        <span class="text-[14px] text-gray-400 font-semibold">На скважине нет заявок</span>
    </div>

    <Modal :show="showDeletingClaimWindow" @close="closeModal">
        <div class="flex flex-col p-5 w-[400px] items-center gap-4">
            <span class="text-[18px] text-gray-800 dark:text-white font-semibold">
                Вы точно хотите удалить заявку?
            </span>

            <code class="p-4 bg-gray-50 dark:bg-gray-700 rounded-md text-[14px] text-normal text-gray-400">
                {{ selectedOnDeletionClaim.Comment }}
            </code>

            <button
                @click="deleteClaim"
                :disabled="form.processing"
                class="ml-3 flex border border-red-600 bg-red-600 px-4 py-2 rounded-lg text-white text-sm font-normal text-center hover:bg-opacity-80"
            >
                <Spinner v-if="form.processing"/>
                <span v-else class="text-white text-sm font-semibold">Удалить</span>
            </button>
        </div>
    </Modal>
</template>

