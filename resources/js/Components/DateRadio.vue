<script setup>
    const emit = defineEmits(['filter']);

    const filter = (e) => {
        emit('filter', e.target.value);
    };

</script>

<template>
    <input id="all-radio" type="radio" name="filter" value="all" checked @change="filter" class="text-green-500 focus:ring-green-500 bg-gray-100 border-gray-300"/>
    <label for="all-radio" class="font-semibold text-sm">Все</label>

    <input id="today-radio" type="radio" name="filter" value="today" @change="filter" class="text-green-500 focus:ring-green-500 bg-gray-100 border-gray-300"/>
    <label for="today-radio" class="font-semibold text-sm">Сегодня</label>

    <input id="earlier-radio" type="radio" name="filter" value="earlier" @change="filter" class="text-green-500 focus:ring-green-500 bg-gray-100 border-gray-300"/>
    <label for="earlier-radio" class="font-semibold text-sm">Ранее</label>
</template>