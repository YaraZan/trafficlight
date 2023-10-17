<script setup>
const props = defineProps({
    name: {
        type: String,
    },
});

</script>

<template>
    <span class="text-gray-800 text-[12px] font-semibold p-[10px] hover:bg-gray-100 rounded-[10px] cursor-pointer before:content-['/'] before:pr-[10px] before:text-gray-400">{{ name }}</span>
</template>