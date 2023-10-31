<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    data: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(['select']);

const select = (e) => { emit('select', e.target.value) };


</script>

<template>
  
</template>