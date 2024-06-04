<template>
    <div class="relative w-full flex flex-col">
    <!-- Dropdown -->
    <div @click="showCategoriesDropdown = !showCategoriesDropdown"
        :class="{'border-green-400 hover:border-green-400 dark:border-green-400 dark:hover:border-green-400' : showCategoriesDropdown}"
        class="w-full px-3 py-2 flex items-center justify-between bg-white border-gray-300 shadow dark:bg-gray-900 dark:border-gray-700
        border rounded-xl hover:border-green-400 cursor-pointer select-none">
            <span v-if="!selectedCategory" class="text-sm text-gray-800 font-semibold select-none dark:text-white">Выберите</span>
            <span v-else class="text-sm text-gray-800 dark:text-white font-semibold select-none">{{ selectedCategory.shortName }}</span>
            <svg class="fill-none w-6 h-6 stroke-gray-800 dark:stroke-white" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.09961 9.6687L12.0996 15.6687L18.0996 9.6687" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
    </div>
    <!-- Content -->
    <div v-show="showCategoriesDropdown" class="top-[110%] z-[50] absolute shadow-lg w-full flex flex-col gap-4 p-8 bg-white border border-gray-300 dark:bg-gray-900 dark:border-gray-700 rounded-lg select-none">
        <div class="flex flex-col gap-1 max-h-[300px] overflow-y-scroll no-scrollbar">
            <div
                @click="selectCategory(category)"
                v-for="(category, index) in categories" :key="index"
                :class="{ 'border-green-400 hover:border-green-400 dark:border-green-400 dark:hover:border-green-400' : isSelected(category)}"
                class="w-full px-4 py-2 flex items-center gap-4 bg-white rounded-lg shadow border border-gray-200
                cursor-pointer hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-opacity-60">
                <div class="flex flex-col gap-2">
                    <span class="text-sm text-gray-800 dark:text-white font-bold">{{ category.shortName }}</span>
                    <span class="text-sm text-gray-400 font-normal">{{ category.name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';
import { Spinner } from 'flowbite-vue';

const SKIP_INIT = 0;
const AMOUNT_INIT = 25;

const categories = ref([]);
const skip = ref(SKIP_INIT);
const amount = ref(AMOUNT_INIT);
const categoriesLoading = ref(false);
const showCategoriesDropdown = ref(false);

// Select
const selectedCategory = ref(null);

// Filter input
const nameInput = ref('');

// Fetch data
function fetchCategories() {
    categoriesLoading.value = true;

    axios.get(`/api/category/all`)
    .then(res => {
        const data = res.data;
        data.forEach(item => {
            categories.value.push(item);
        })
        categoriesLoading.value = false;
    })
    .catch(err => {
        // handle
        categoriesLoading.value = false;
    })
}

// Helper functions
function selectCategory(category) {
    showCategoriesDropdown.value = false;
    selectedCategory.value = category;
    emit('select', category);
}

function isSelected(category) {
    return selectedCategory.value?.id === category.id;
}

onMounted(() => {
    fetchCategories();
});

const emit = defineEmits(['select']);
</script>
