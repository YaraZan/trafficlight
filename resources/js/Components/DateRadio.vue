<script setup>
    const emit = defineEmits(['filter']);

    const filter = (e) => {
        emit('filter', e.target.value);
    };

</script>

<template>

</template>