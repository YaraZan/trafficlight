<template>
    <div class="flex items-center justify-center gap-4 p-5 bg-gray-100 dark:bg-gray-900 rounded-md text-sm text-normal text-gray-400">
        <template v-if="currentValues && !currentValuesLoading">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-400 font-medium">Факт:</span>
                <span v-if="currentValues.FactValue" class="text-sm text-gray-800 dark:text-white font-medium">{{ currentValues.FactValue }}</span>
                <span v-else class="text-sm text-red-500 font-medium">Пусто</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-400 font-medium">Уставка:</span>
                <span v-if="currentValues.CurrentValue" class="text-sm text-gray-800 dark:text-white font-medium">{{ currentValues.CurrentValue }}</span>
                <span v-else class="text-sm text-red-500 font-medium">Пусто</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-400 font-medium">АРМИТС:</span>
                <span v-if="currentValues.ArmitsValue" class="text-sm text-gray-800 dark:text-white font-medium">{{ currentValues.ArmitsValue }}</span>
                <span v-else class="text-sm text-red-500 font-medium">Пусто</span>
            </div>
        </template>
        <Spinner v-if="currentValuesLoading" color="gray" />
        <span v-if="!well && !category" class="text-sm text-gray-400 font-medium">Выберите скважину и категорию</span>
        <span v-if="!well && category" class="text-sm text-gray-400 font-medium">Выберите скважину</span>
        <span v-if="well && !category" class="text-sm text-gray-400 font-medium">Выберите категорию</span>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, watch } from 'vue';
import { Spinner } from 'flowbite-vue';

const well = defineModel('well');
const category = defineModel('category');
const emit = defineEmits(['load']);

const currentValues = ref(null);
const currentValuesLoading = ref(false);

async function fetchCurrentValues() {
    currentValuesLoading.value = true;

    await axios.get('/api/claims/getCurrentValues', {
        params: {
            well_id: well.value,
            category_id: category.value
        }
    })
    .then(res => {
        currentValues.value = res.data;

        currentValuesLoading.value = false;
    })
    .catch(err => {
        // handle
        currentValuesLoading.value = false;
    })
}

watch([well, category], async ()=>{
    if (well.value && category.value) {
        await fetchCurrentValues();
        emit('load', currentValues.value);
    }
})
</script>
