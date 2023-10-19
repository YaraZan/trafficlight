<script setup>
import { Button } from 'flowbite-vue';
import { computed } from 'vue';
import { ref } from 'vue';

const props = defineProps({
    data: {
        type: Array,
        required: true
    }
});

const ngdus = computed(() => {
    return props.data;
})

const emit = defineEmits(['viewType']);

const viewType = (e) => {
    emit('viewType', e.target.value);
};

const show = ref(false);

</script>

<template>

</template>