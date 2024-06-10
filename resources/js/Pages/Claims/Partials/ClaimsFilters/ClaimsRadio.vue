<template>
    <div class="flex w-full items-center gap-4">

        <div @click="selectRadioType(radioType)" v-for="(radioType, index) in radioTypes" :key="index"
        class="flex items-center gap-2 cursor-pointer">
            <div class="w-4 h-4 flex items-center justify-center rounded-full border border-gray-300 dark:border-gray-700">
                <div v-if="isSelected(radioType)" class="w-2 h-2 rounded-full bg-green-400" />
            </div>
            <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ radioType.name }}</span>
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { RADIO_TYPES } from "./constraints.js";

const radioTypes = ref(RADIO_TYPES);
const selectedRadioType = ref(radioTypes.value[0]);

function isSelected(radioType) {
    return selectedRadioType.value === radioType;
}

function selectRadioType(radioType) {
    selectedRadioType.value = radioType;
    emit('change', radioType);
}

onMounted(() => {
    emit('change', radioTypes.value[0])
});

const emit = defineEmits(['change']);
</script>
