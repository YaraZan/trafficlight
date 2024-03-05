<script setup>
import {computed, onMounted, ref} from "vue";
import axios from "axios";
import Modal from "@/Components/Modal.vue";
import {Input, P, Spinner} from "flowbite-vue";
import {useForm} from "@inertiajs/vue3";
import LockedIcon from "@/Components/Icons/LockedIcon.vue";

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
    categories: {
        type: Object,
        required: true,
    },
});

const currentPage = ref(1);
const perPage = ref(6);
const showCreatingClaimWindow = ref(false);

const totalPages = computed(() => {
    return Math.ceil(props.categories.length / perPage.value);
});

const paginatedData = computed(() => {
    const data = props.categories || []

    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;


    return data.slice(start, end);
});

const visiblePages = computed(() => {
    const totalVisiblePages = 5;
    const pages = [];
    let startPage;

    if (totalPages.value <= totalVisiblePages) {
        startPage = 1;
    } else if (currentPage.value <= 2) {
        startPage = 1;
    } else if (currentPage.value >= totalPages.value - 2) {
        startPage = totalPages.value - totalVisiblePages + 1;
    } else {
        startPage = currentPage.value - Math.floor(totalVisiblePages / 2);
    }

    for (let i = 0; i < totalVisiblePages && startPage <= totalPages.value; i++) {
        pages.push(startPage);
        startPage++;
    }

    return pages;
});

const setCurrentPage = (page) => {
    currentPage.value = page;
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const emit = defineEmits(['created', 'cancelled']);

const form = useForm({
    well_uuid: props.item.public_id,
    new_value: '',
    old_value: '',
    category_id: '',
});

const creteNewClaim = () => {
    form.post(route('claim.create'), {
        onSuccess: () => {
            form.reset();
            showCreatingClaimWindow.value = false
            emit('created');
        },
    });
};
const getFontColor = (val) => {
    let colorClass = 'text-gray-800 dark:text-gray-300';

    switch (val) {
        case 2:
            colorClass= 'text-orange-400';
            break;

        case 3:
            colorClass= 'text-red-500';
            break;
    }

    return colorClass;
};

const closeModal = () => {
    showCreatingClaimWindow.value = false;
};

const openChangingWindow = (val, id) => {
    form.old_value = val;
    form.new_value = val;
    form.category_id = id;

    showCreatingClaimWindow.value = true;
}
</script>

<template>
    <div
        class="w-2/3 grid grid-cols-3 gap-[5px] p-4 max-h-[350px] overflow-y-auto">
        <div v-for="(category, index) in categories"
             @click="category.IsWritable ? openChangingWindow(category.CurrentValue, category.CategoryId) : {}"
             :key="index"
             class="relative h-[150px] flex items-end justify-between shadow-lg bg-white dark:bg-gray-800 p-4 rounded-[10px]"
             :class="{ 'hover:outline hover:outline-1 hover:outline-green-400' : category.IsWritable }"
        >
            <LockedIcon v-if="!category.IsWritable" class="absolute top-4 right-4"/>

            <div class="flex flex-col h-full justify-between">
                <span class="text-[18px] font-black text-gray-800 dark:text-white">{{ category.CatNameShorted }}</span>
                <span class="text-[14px] font-normal text-gray-800 dark:text-gray-400 max-w-[150px]">{{ category.CatName }}</span>
            </div>

            <div class="flex flex-col items-end gap-4">
                <code class="bg-gray-100 w-min dark:bg-gray-900 rounded-[10px] p-2 text-[20px] font-semibold">
                    {{ category.CurrentValue }}
                </code>
                <div class="flex items-center gap-2">
                    <span class="text-[14px] text-gray-400">АРМИТС</span>
                    <span v-if="category.ArmitsValue" class="text-[16px] text-gray-800 dark:text-white">{{  category.ArmitsValue }}</span>
                    <span v-else class="text-[14px] text-red-500">Пусто</span>
                </div>
            </div>
        </div>
        <div v-if="paginatedData.length < perPage"
             v-for="(_, index) in Array.from({ length: perPage - paginatedData.length })"
             :key="index"
             class="group border border-dashed border-gray-300 dark:border-gray-700 rounded-lg flex flex-col justify-between p-5
             bg-opacity-60 h-[150px] relative">
        </div>
    </div>

<Modal :show="showCreatingClaimWindow" @close="closeModal">
    <div class="select-none flex flex-col p-5 w-[400px] items-center gap-4">
        <span class="text-[18px] text-gray-800 dark:text-white font-semibold">Изменение параметров</span>
        <p class="p-4 bg-gray-50 dark:bg-gray-700 rounded-md text-[14px] text-normal text-gray-400">
            * Примечание: Отправленные вами данные будут сформированы в заявку, и, по возможности
            приняты или отклонены оператором.
        </p>
        <Input v-model="form.new_value" size="sm"
               class="w-full focus:ring-green-600 focus:border-green-500 ring-green-600 h-9" type="number" placeholder="Значение">
        </Input>

        <button
            @click="creteNewClaim"
            :disabled="form.processing"
            class="w-full flex justify-center items-center h-[32px] gap-2 bg-green-600 px-4 py-2 border border-green-500 rounded-lg hover:bg-opacity-80">
            <Spinner v-if="form.processing"/>
            <span v-else class="text-white text-sm font-semibold">Отправить</span>
        </button>
    </div>
</Modal>
</template>
