<script setup>
import { Input } from 'flowbite-vue';

const emit = defineEmits(['search']);

const search = (e) => {
    emit('search', e.target.value)
};
</script>

<template>
    
</template>