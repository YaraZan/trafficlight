<script setup>
import { Button } from 'flowbite-vue';
import ActionsIcon from '@/Components/Icons/ActionsIcon.vue';
import { ref } from 'vue';

const props = defineProps({
    data: {
        type: Array,
        required: true
    }
});

const show = ref(false);
</script>

<template>
    <div class="relative flex items-center flex-col">
        <Button :class="show ? 'border-green-600 text-green-600' : ''" class="bg-green-600 ml-auto focus:ring-green-200" size="md" color="green" @click="show = !show;">
            Действия
            <template #suffix>
                <ActionsIcon class="stroke-white"></ActionsIcon>
            </template>
        </Button>

        <div :class="show ? 'visible' : 'invisible'" class="absolute top-12 p-3 right-0 z-10 bg-white rounded-lg shadow min-w-[300px]">
            <h6 class="font-medium text-sm text-gray-400">Выберите действие</h6>
            <ul class="mt-[10px] gap-2 w-full flex flex-col">
                <li class="flex flex-col cursor-pointer p-4 hover:bg-gray-100 rounded-lg">
                    <span class="font-semibold text-gray-800 text-sm">Экспорт в Excel</span>
                    <span class="text-gray-400 text-sm">Экспортируйте данные матрицы в удобном формате excel</span>  
                </li>
            </ul>
        </div>
    </div>
</template>