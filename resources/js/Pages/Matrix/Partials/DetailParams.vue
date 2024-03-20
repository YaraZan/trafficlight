<script setup>
import {computed, onMounted, ref, watch} from "vue";
import OilWellAnimatedIcon from "@/Components/Icons/OilWellAnimatedIcon.vue";
import axios from "axios";
import NoDataIcon from "@/Components/Icons/NoDataIcon.vue";
import {useForm} from "@inertiajs/vue3";
import {Input, P, Spinner} from "flowbite-vue";
import Modal from "@/Components/Modal.vue";

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
    isControl: {
        type: Boolean,
        default: true
    }
});

const emit = defineEmits(['created'])

const categories = ref([]);

const categoriesLoading = ref(false);
const showCreatingClaimWindow = ref(false);

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
            emit('created')
        },
    });
};

const fetchWellCategories = (publicId) => {
    categoriesLoading.value = true;

    return axios.get(`/api/control/${publicId}/categories/fact`)
        .then((response) => {
            categories.value = response.data;
        })
        .catch((error) => {
            console.error('Ошибка', error);
        })
        .finally(() => {
            categoriesLoading.value = false;
        })
};

onMounted(() => {
    fetchWellCategories(props.item.public_id)
});

const currentPage = ref(1);
const perPage = ref(10);

const totalPages = computed(() => {

    if (paginatedData.value.length > 0) {
        return Math.ceil(filteredData.value.length / perPage.value);
    }

});

const filteredData = computed(() => {
    return categories.value;
})

const paginatedData = computed(() => {
    const data = filteredData.value;

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

const openChangingWindow = (val, id) => {
    form.old_value = val;
    form.new_value = val;
    form.category_id = id;

    showCreatingClaimWindow.value = true;
}

const closeModal = () => {
    showCreatingClaimWindow.value = false;
};
</script>

<template>
    <div class="flex w-full flex-col gap-5">

        <div class="flex w-full items-center gap-4">

            <slot/>

            <div class="flex items-center gap-2 ml-auto">
                <ul
                    class="flex items-center -space-x-px h-9 text-sm ml-auto">
                    <li>
                        <button @click="prevPage" :disabled="currentPage === 1" href="#"
                                class="flex items-center justify-center px-3 h-9 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Пред.</span>
                            <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="M5 1 1 5l4 4"/>
                            </svg>
                        </button>
                    </li>
                    <li v-for="page in visiblePages" :key="page">
                        <button
                            @click="setCurrentPage(page)"
                            :class="{ 'font-bold text-green-600': currentPage === page }"
                            class="flex items-center justify-center px-3 h-9 leading-tight text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        >
                            {{ page }}
                        </button>
                    </li>
                    <li>
                        <button @click="nextPage"
                                :disabled="currentPage === totalPages" href="#"
                                class="flex items-center justify-center px-3 h-9 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">След.</span>
                            <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                        </button>
                    </li>
                </ul>
            </div>

        </div>

        <div v-if="!categoriesLoading && paginatedData.length > 0" class="w-full grid grid-cols-5 gap-[5px]">
            <div
                v-for="(category, index) in paginatedData"
                :key="index"
                @click="category.IsWritable && isControl ? openChangingWindow(category.CurrentValue, category.CategoryId) : {}"
                :class="{ 'hover:outline hover:outline-1 hover:outline-green-400' : category.IsWritable && isControl }"
                class="flex h-[150px] items-center justify-between bg-white border border-gray-100 dark:bg-gray-900
                         shadow-md p-4 rounded-lg dark:border-gray-700">
                <div class="flex flex-col h-full justify-between">
                    <span class="text-[18px] font-black text-gray-800 dark:text-white">{{
                        category.CatNameShorted
                    }}</span>
                    <span class="text-[14px] font-normal text-gray-800 dark:text-gray-400 max-w-[150px]">{{
                        category.CatName
                    }}</span>
                </div>

                <div class="flex flex-col items-end h-full justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-[13px] font-normal text-gray-300 dark:text-gray-600">Факт</span>
                        <code v-if="category.ArmitsValue"
                              class="bg-gray-100 w-min dark:bg-gray-800 rounded-[10px] p-2 text-[14px] font-semibold">
                            {{ category.FactValue }}
                        </code>
                        <span v-else class="text-[13px] text-red-500 font-semibold">Пусто</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[13px] font-normal text-gray-300 dark:text-gray-600">Уставка</span>
                        <code v-if="category.CurrentValue"
                              class="bg-gray-100 w-min dark:bg-gray-800 rounded-[10px] p-2 text-[14px] font-semibold">
                            {{ category.CurrentValue }}
                        </code>
                        <span v-else class="text-[13px] text-red-500 font-semibold">Пусто</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[13px] font-normal text-gray-300 dark:text-gray-600">АРМИТС</span>
                        <code v-if="category.ArmitsValue"
                              class="bg-gray-100 w-min dark:bg-gray-800 rounded-[10px] p-2 text-[14px] font-semibold">
                            {{ category.ArmitsValue }}
                        </code>
                        <span v-else class="text-[13px] text-red-500 font-semibold">Пусто</span>
                    </div>
                </div>
            </div>
        </div>

        <div v-else-if="!categoriesLoading">
            <div class="w-full flex flex-col gap-4 items-center justify-center mt-20">
                <NoDataIcon/>
                <span class="text-[18px] text-gray-400 font-semibold">Данных нет</span>
            </div>
        </div>

        <div v-else>
            <div class="w-full flex flex-col gap-4 items-center justify-center mt-20">
                <OilWellAnimatedIcon class="w-[100px] h-[100px]"/>
            </div>
        </div>

        <Modal :show="showCreatingClaimWindow" @close="closeModal">
            <div class="select-none flex flex-col p-5 w-[400px] items-center gap-4">
                <span class="text-[18px] text-gray-800 dark:text-white font-semibold">Изменение параметров</span>
                <p class="p-4 bg-gray-100 dark:bg-gray-900 rounded-md text-[14px] text-normal text-gray-400">
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
    </div>
</template>
