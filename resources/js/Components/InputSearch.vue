<script setup>
import { Input } from 'flowbite-vue';

const emit = defineEmits(['search']);

const search = (e) => {
    emit('search', e.target.value)
};
</script>

<template>
    <Input size="sm" class="focus:ring-green-500 focus:border-green-500 w-56 ring-green-600 " @input="search" type="text"  placeholder="Поиск" required="">
    </Input>
</template>