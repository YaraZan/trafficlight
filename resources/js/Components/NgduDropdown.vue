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

const emit = defineEmits(['filter']);

const filter = (e) => {
    emit('filter', e.target.value);
};

const show = ref(false);

</script>

<template>
    <div class="relative flex items-center flex-col">
        <Button :class="show ? 'border-green-600 text-green-600' : ''" size="md" color="light" @click="show = !show;">
            <span class="font-semibold">НГДУ</span>
        </Button>

        <div :class="show ? 'visible' : 'invisible'" class="absolute top-12 p-5 right-0 z-10 bg-white rounded-lg shadow min-w-[300px]">
            <h6 class="font-medium text-sm text-gray-400">Выберите НГДУ</h6>
            <ul class="mt-[10px] gap-2 w-full flex flex-col">
                <li v-for="(ngdu, index) in ngdus" :key="index" class="flex items-center gap-2">
                    <input class="text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 cursor-pointer" :id="`filter_option_${index}`" @change="filter" type="checkbox" :value="ngdu.Id">
                    <label class="cursor-pointer" :for="`filter_option_${index}`">{{ ngdu.NgduName }}</label>
                </li>
            </ul>
        </div>
    </div>
</template>