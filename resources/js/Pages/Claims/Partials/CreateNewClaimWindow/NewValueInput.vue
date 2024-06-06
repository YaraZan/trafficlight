<template>
    <div :class="['w-full flex items-center border border-gray-200 dark:border-gray-700 bg-transparent rounded-lg justify-between', { 'border-green-400 dark:border-green-400': isFocused }]">
        <input
            v-model="inputValue"
            type="number"
            class="appearance-none h-full w-full focus:ring-0 ring-0 outline-none border-none bg-transparent"
            @focus="handleFocus"
            @blur="handleBlur"
            @input="onInput"
        >

        <div class="w-1/3 h-full flex items-center">
            <div @click="decrement" class="w-1/2 p-4 h-full flex items-center justify-center select-none border-gray-200 dark:border-gray-700 border-x text-xl font-semibold text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">-</div>
            <div @click="increment" class="w-1/2 p-4 h-full flex items-center justify-center select-none border-gray-200 dark:border-gray-700 text-xl font-semibold text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">+</div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const inputValue = defineModel({ default: 1 })
const isFocused = ref(false);

const validateValue = (value) => {
    if (isNaN(value) || value < 1 || value > 10 || !/^\d+(\.\d)?$/.test(value.toString())) {
        return false;
    }
    return true;
};

const onInput = (event) => {
    let value = parseFloat(event.target.value);
    if (!validateValue(value)) {
        event.target.value = inputValue.value;
    } else {
        inputValue.value = value;
    }
};

const increment = () => {
    let newValue = (parseFloat(inputValue.value) + 0.1).toFixed(1);
    if (validateValue(newValue)) {
        inputValue.value = parseFloat(newValue);
    }
};

const decrement = () => {
    let newValue = (parseFloat(inputValue.value) - 0.1).toFixed(1);
    if (validateValue(newValue)) {
        inputValue.value = parseFloat(newValue);
    }
};

const handleFocus = () => {
    isFocused.value = true;
};

const handleBlur = () => {
    isFocused.value = false;
};

watch(inputValue, (newValue, oldValue) => {
    if (!validateValue(newValue)) {
        inputValue.value = oldValue;
    }
}, { deep: true });
</script>

<style scoped>
input[type=number]::-webkit-outer-spin-button,
input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance: textfield;
}
</style>
