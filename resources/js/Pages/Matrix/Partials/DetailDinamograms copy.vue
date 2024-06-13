<script setup>
import {computed, onBeforeUnmount, onMounted, onUnmounted, ref, watch} from "vue";
import OilWellAnimatedIcon from "@/Components/Icons/OilWellAnimatedIcon.vue";
import axios from "axios";
import NoDataIcon from "@/Components/Icons/NoDataIcon.vue";
import DatePicker from "vue-datepicker-next";
import 'vue-datepicker-next/index.css';
import 'vue-datepicker-next/locale/ru.es';
import ClearIcon from "@/Components/Icons/ClearIcon.vue";
import CalendarIcon from "@/Components/Icons/CalendarIcon.vue";

const props = defineProps({
    item: {
        type: Object,
        required: true,
    }
});

const dnmhData = ref([]);
const dnmData = ref([]);

const dnmhDataLoading = ref(false);
const dnmDataLoading = ref(false);

const dateFilters = ref([]);

const emit = defineEmits(['selectDnm', 'selectDnmh'])

const fetchDnmhData = (publicId) => {
    dnmhDataLoading.value = true;

    return axios.get(`/api/dnmh/${publicId}`)
        .then((response) => {
            dnmhData.value = response.data;
        })
        .catch((error) => {
            console.error('Error fetching Dnmh data', error);
        })
        .finally(() => {
            dnmhDataLoading.value = false;
        });
};

const fetchDnmData = (publicId) => {
    dnmDataLoading.value = true;

    return axios.get(`/api/dnm/${publicId}`)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            console.error('Error fetching Dnm data', error);
        })
        .finally(() => {
            dnmDataLoading.value = false;
        });
};

const selectDinamogram = (publicId) => {
    const existingIndex = dnmData.value.findIndex((item) => item.public_id === publicId);

    if (existingIndex !== -1) {
        dnmData.value.splice(existingIndex, 1);

        for (let i = 0; i < dnmData.value.length; i++) {
            if (i === 0) {
                dnmData.value[i].color = 'green';
            } else if (i === 1) {
                dnmData.value[i].color = 'orange';
            } else if (i === 2) {
                dnmData.value[i].color = 'red';
            } else if (i === 3) {
                dnmData.value[i].color = 'blue';
            } else {
                dnmData.value[i].color = 'purple';
            }
        }
    } else {
        if (dnmData.value.length >= 5) {
            dnmData.value.shift();
        }

        fetchDnmData(publicId)
            .then((data) => {
                const colorOptions = ['green', 'orange', 'red', 'blue', 'purple'];
                const selectedColor = colorOptions[dnmData.value.length];

                const dinamogram = {
                    public_id: publicId,
                    color: selectedColor,
                    data: data,
                };

                dnmData.value.push(dinamogram);

                for (let i = 0; i < dnmData.value.length; i++) {
                    if (i === 0) {
                        dnmData.value[i].color = 'green';
                    } else if (i === 1) {
                        dnmData.value[i].color = 'orange';
                    } else if (i === 2) {
                        dnmData.value[i].color = 'red';
                    } else if (i === 3) {
                        dnmData.value[i].color = 'blue';
                    } else {
                        dnmData.value[i].color = 'purple';
                    }
                }
            });
    }
};


onMounted(() => {
    fetchDnmhData(props.item.public_id)
        .then(() => {
            if (dnmhData.value.length > 0) {
                selectDinamogram(dnmhData.value[0].public_id);
            }
        });
});

onUnmounted(() => {
    emit('selectDnm', [])
})

const currentPage = ref(1);
const perPage = ref(6);

const totalPages = computed(() => {

    if (paginatedData.value.length > 0) {
        return Math.ceil(filteredData.value.length / perPage.value);
    }

});

const filteredData = computed(() => {
    let data = dnmhData.value;

    if (dateFilters.value && dateFilters.value.length === 2) {
        const [startDate, endDate] = dateFilters.value;

        data = data.filter(dataItem => {
            const itemDate = new Date(dataItem.Dat);

            const itemDateString = itemDate.toLocaleDateString();
            const startDateString = startDate.toLocaleDateString();
            const endDateString = endDate.toLocaleDateString();

            return (
                (itemDate >= startDate && itemDate <= endDate) ||
                (itemDateString === startDateString) ||
                (itemDateString === endDateString)
            );
        });
    }

    return data;
})

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return filteredData.value.slice(start, end);
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

const clearDate = () => {
    dateFilters.value = [];
};

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

watch(() => [dnmhData.value, dateFilters.value], () => {
    currentPage.value = 1
}, { deep: true });


watch(() => [dnmData.value, dnmhData.value], () => {
    emit('selectDnm', dnmData.value)
    emit('selectDnmh', dnmhData.value)
}, { deep: true });

const findDnmItem = (dnmItem) => {
    return dnmData.value.find(src => src.public_id === dnmItem.public_id);
};
</script>

<template>
    <div class="flex w-full flex-col gap-5">

        <div class="flex w-full items-center gap-4">

            <slot />

            <div class="flex items-center gap-2 ml-auto">
                <date-picker class="flex relative h-9 w-56"
                             :editable="false"
                             placeholder="Дата"
                             input-class="w-full h-full dark:text-green-400 dark:bg-gray-700 bg-gray-50 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 w-56 ring-green-600"
                             popup-class="rounded-lg p-2 relative dark:bg-gray-900 dark:border-gray-600"
                             v-model:value="dateFilters"
                             range
                             separator="-"
                             :onClear="clearDate"
                >
                    <template #icon-calendar>
                        <CalendarIcon />
                    </template>

                    <template #icon-clear>
                        <ClearIcon />
                    </template>
                </date-picker>

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

        <div v-if="!dnmhDataLoading && paginatedData.length > 0" class="w-full grid grid-cols-6 grid-rows-1 gap-[5px]">
            <div v-for="(dnm, index) in paginatedData" :key="index"
                @click="() => selectDinamogram(dnm.public_id)"
                :style="{ 'border-color': findDnmItem(dnm)?.color }"
                :class="{ 'border-[3px]' : findDnmItem(dnm) }"
                class="relative min-h-[200px] flex flex-col bg-white dark:bg-gray-900 shadow-sm p-4 rounded-2xl gap-8 border border-gray-200
                dark:border-gray-700 hover:border-gray-400 dark:hover:border-gray-500 select-none">

                <span v-if="findDnmItem(dnm)"
                    :style="{ 'background-color': findDnmItem(dnm)?.color }"
                    class="absolute top-2 right-2 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold text-white">
                    {{ dnmData.indexOf(findDnmItem(dnm)) + 1 }}
                </span>
                <span class="text-sm text-gray-800 dark:text-white font-semibold">{{ dnm.DnmAdress }}</span>

                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-400 font-normal">Опрос:</span>
                    <span class="text-sm text-gray-800 dark:text-white font-semibold">{{ dnm.AskLong }}</span>
                </div>

                <span class="text-sm text-gray-400 dark:text-gray-600 font-normal mt-auto">{{ dnm.Dat }}</span>
            </div>
        </div>

        <div v-else-if="!dnmhDataLoading">
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

    </div>
</template>

