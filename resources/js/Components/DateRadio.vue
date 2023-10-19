<script setup>
    const emit = defineEmits(['filter']);

    const filter = (e) => {
        emit('filter', e.target.value);
    };

</script>

<template>
    <div class="flex items-center gap-3 ml-auto px-[20px]">
        <input id="all-radio" type="radio" name="filter" value="all" checked @change="filter" class="text-green-500 focus:ring-green-500 bg-gray-100 border-gray-300"/>
        <label for="all-radio" class="font-semibold text-sm">Все</label>

        <input id="today-radio" type="radio" name="filter" value="available" @change="filter" class="text-green-500 focus:ring-green-500 bg-gray-100 border-gray-300"/>
        <label for="today-radio" class="font-semibold text-sm">Доступные</label>

        <input id="earlier-radio" type="radio" name="filter" value="lost" @change="filter" class="text-green-500 focus:ring-green-500 bg-gray-100 border-gray-300"/>
        <label for="earlier-radio" class="font-semibold text-sm">Недоступные</label>
    </div>
</template>