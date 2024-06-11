<template>
    <div class="w-full grid grid-cols-5 grid-rows-2 gap-1">
        <div v-for="(category, index) in categories"
            :key="index"
            class="flex h-[150px] items-center justify-between bg-white border border-gray-100 dark:bg-gray-900
                        shadow-md p-4 rounded-lg dark:border-gray-700">
            <div class="flex flex-col h-full justify-between">
                <span class="text-[18px] font-black text-gray-800 dark:text-white">{{
                    category.CatNameShorted
                }}</span>
                <span class="text-[14px] font-normal text-gray-800 dark:text-gray-400 max-w-[150px]">{{
                    category.CatName
                }}</span>
            </div>

            <div class="flex flex-col items-end h-full justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-[13px] font-normal text-gray-300 dark:text-gray-600">Факт</span>
                    <code v-if="category.FactValue"
                            class="bg-gray-100 w-min dark:bg-gray-800 rounded-[10px] p-2 text-[14px] font-semibold">
                        {{ category.FactValue }}
                    </code>
                    <span v-else class="text-[13px] text-red-500 font-semibold">Пусто</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[13px] font-normal text-gray-300 dark:text-gray-600">Уставка</span>
                    <code v-if="category.CurrentValue"
                            class="bg-gray-100 w-min dark:bg-gray-800 rounded-[10px] p-2 text-[14px] font-semibold">
                        {{ category.CurrentValue }}
                    </code>
                    <span v-else class="text-[13px] text-red-500 font-semibold">Пусто</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[13px] font-normal text-gray-300 dark:text-gray-600">АРМИТС</span>
                    <code v-if="category.ArmitsValue"
                            class="bg-gray-100 w-min dark:bg-gray-800 rounded-[10px] p-2 text-[14px] font-semibold">
                        {{ category.ArmitsValue }}
                    </code>
                    <span v-else class="text-[13px] text-red-500 font-semibold">Пусто</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';

const props = defineProps(['well']);

const categories = ref([]);
const categoriesLoading = ref(false);

function fetchCategories() {
    categoriesLoading.value = true;

    axios.get(`/api/control/${props.well.public_id}/categories/fact`)
    .then((response) => {
        categories.value = response.data;

        categoriesLoading.value = false;
    })
    .catch((error) => {
        console.error('Ошибка', error);

        categoriesLoading.value = false;
    })
};

onMounted(() => {
    fetchCategories();
})
</script>
