<script setup>
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Link, Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import DnmChart from './Partials/DnmChart.vue';
import { watch } from 'vue';
import Dinamogram from '@/Components/Icons/Dinamogram.vue';
import DinamographLogo from "@/Components/Icons/DinamographLogo.vue";
import {Spinner} from "flowbite-vue";
import ClearIcon from "@/Components/Icons/ClearIcon.vue";
import {encryptStorage} from "@/utils/storage.js";
import DatePicker from "vue-datepicker-next";
import 'vue-datepicker-next/index.css';
import 'vue-datepicker-next/locale/ru.es';
import CalendarIcon from "@/Components/Icons/CalendarIcon.vue";
import OilWellAnimatedIcon from "@/Components/Icons/OilWellAnimatedIcon.vue";
import UserClaims from "@/Pages/Matrix/Partials/Detail/UserClaims.vue";
import WellClaims from "@/Pages/Matrix/Partials/Detail/WellClaims.vue";
import CategoriesGrid from "@/Pages/Matrix/Partials/Detail/CategoriesGrid.vue";

const props = defineProps({
    item: {
        type: Object,
        required: true,
    }
});

const dnmhData = ref([]);
const dnmData = ref([]);
const categoriesLoading = ref(false);
const categories = ref([]);
const paginatedData = ref([]);
const aiError = ref('');
const paginationSource = ref('Параметры')
const paginationSourceTypes = ['Параметры', 'Динамограммы']
const paginationClaimsSource = ref('История')
const paginationClaimsTypes = ['История', 'Отправленные']
const dateFilters = ref([]);

const predictionsData = ref([]);

const API_KEY = import.meta.env.VITE_API_KEY
const DINAMOGRAPH_API_URL = import.meta.env.VITE_DINAMOGRAPH_API_URL

const processingAiAnalysis = ref(false);
const showAiReportWindow = ref(false);

const claims = ref([]);
const wellClaims = ref([]);

const claimsLoading = ref(false);
const wellClaimsLoading = ref(false);

const fetchUserClaims = () => {

    claimsLoading.value = true;

    return axios.get(`/api/control/${props.item.public_id}/claims`)
        .then((response) => {
            claims.value = response.data;
        })
        .catch((error) => {
            console.error('Ошибка', error);
        })
        .finally(() => {
            claimsLoading.value = false;
        });
};
const fetchWellClaims = () => {

    wellClaimsLoading.value = true;

    return axios.get(`/api/control/${props.item.public_id}/well-claims`)
        .then((response) => {
            wellClaims.value = response.data;
        })
        .catch((error) => {
            console.error('Ошибка', error);
        })
        .finally(() => {
            wellClaimsLoading.value = false;
        });
};

onMounted(() => {
    fetchUserClaims()
    fetchWellCategories()
    fetchWellClaims()
})

const handleChangedCategory = () => {
    fetchUserClaims()
    fetchWellCategories()
    fetchWellClaims()
}

const countConfirmedClaims = (claims) => {
    let count = 0;

    claims.forEach(claim => claim.StatusName === 'Выполнено' && count++)

    return count
}

const countDeniedClaims = (claims) => {
    let count = 0;

    claims.forEach(claim => claim.StatusName === 'Отклонено' && count++)

    return count
}

const getAiModelVersion = () => {

    return axios.get(`${DINAMOGRAPH_API_URL}/v1/ai/models/`, {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Basic ${API_KEY}`
        },
    }).then(res => {
        const aiModels = res.data.models

        if (!aiModels.find(item => item.public_id === encryptStorage.getItem('aiv'))) {
            encryptStorage.setItem('aiv', aiModels[0].public_id)
        }

        return axios.get(`${DINAMOGRAPH_API_URL}/v1/ai/models/${encryptStorage.getItem('aiv')}`, {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Basic ${API_KEY}`
            },
        }).then(res => {
            return res.data.name
        })
    })

}

const fetchDnmhData = () => {
    return axios.get(`/api/dnmh/${props.item.public_id}`)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            console.error('Error fetching Dnmh data', error);
        });
};

const fetchDnmData = (publicId) => {
    return axios.get(`/api/dnm/${publicId}`)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            console.error('Error fetching Dnm data', error);
        });
};

const fetchRawPrediction = async (data) => {
    processingAiAnalysis.value = true;

    return axios.post(`${DINAMOGRAPH_API_URL}/v1/ai/predict/raw`, {
        raw_data: data,
        model_name: await getAiModelVersion()
    }, {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Basic ${API_KEY}`
        },
    })
        .then(response => {
            const res = response.data

            return `${res.split('_').join(' ')}`
        })
        .catch(error => {
            aiError.value = 'Ошибка при составлении отчёта. Повторите попытку позже.'

            setTimeout(() => {
                aiError.value = ''

                showAiReportWindow.value = false
            }, 5000)
        })
        .finally(() => {
            processingAiAnalysis.value = false;
        })
}

const make_ai_analysis = async () => {
    showAiReportWindow.value = true
    const predictionsArr = []

    for (const dnm of dnmData.value) {
        await fetchRawPrediction(dnm.data)
            .then(res => {
                predictionsArr.push({
                    public_id: dnm.public_id,
                    color: dnm.color,
                    prediction: res
                })
            })
    }
    predictionsData.value = predictionsArr
}

const fetchWellCategories = () => {

    categoriesLoading.value = true;

    return axios.get(`/api/control/${props.item.public_id}/categories/fact`)
        .then((response) => {
            categories.value = response.data;
        })
        .catch((error) => {
            console.error('Ошибка', error);
        })
        .finally(() => {
            categoriesLoading.value = false;
        });
};


onMounted(() => {
    fetchDnmhData()
        .then((data) => {
            if (data.length > 0) {
                dnmhData.value = data;
                paginateData();
                selectDinamogram(dnmhData.value[0].public_id);
            }
        });
    fetchWellCategories();
});

const extractWellNumber = (string) => {
    const elements = string.split('-');
    return elements[elements.length - 1];
};

const selectDinamogram = (publicId) => {
    const existingDinamogramIndex = dnmData.value.findIndex((item) => item.public_id === publicId);

    if (existingDinamogramIndex !== -1) {
        // If the dinamogram already exists, remove it
        dnmData.value.splice(existingDinamogramIndex, 1);

        // Reassign colors based on their order for the first five dinamograms
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
            // If there are already 5 dinamograms, remove the oldest one
            dnmData.value.shift();
        }

        fetchDnmData(publicId)
            .then((data) => {
                const colorOptions = ['green', 'orange', 'red', 'blue', 'purple'];
                const selectedColor = colorOptions[dnmData.value.length]; // Use the next available color

                const dinamogram = {
                    public_id: publicId,
                    color: selectedColor,
                    data: data,
                };

                dnmData.value.push(dinamogram);

                // Reassign colors based on their order for the first five dinamograms
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

// Pagination

const currentPage = ref(1);
const perPage = ref(4);

const totalPages = computed(() => {

    if (paginatedData.value.length > 0) {
        return Math.ceil(filteredDnmData.value.length / perPage.value);
    }

});

const filteredDnmData = computed(() => {
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

const paginateData = () => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    paginatedData.value = filteredDnmData.value.slice(start, end);
};

const setCurrentPage = (page) => {
    currentPage.value = page;
    paginateData();
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        paginateData();
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
        paginateData();
    }
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

const page = usePage();
const controlWells = computed(() => page.props.auth.controlWells);
</script>

<template>
    <Head :title="item.Name" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('matrix')">
                <BreadCrumb
                    :name="'Матрица'"
                ></BreadCrumb>
            </Link>
            <Link :href="route('matrix.detail', item.public_id)">
                <BreadCrumb
                    :name="item.Name"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="flex flex-col w-full p-4">

            <div class="w-full flex gap-4">

                <div class="min-w-[35%] flex flex-col gap-2">

                    <div class="w-full flex flex-col gap-5 rounded-lg bg-gray-100 dark:bg-gray-700 p-5">

                        <div class="flex items-center gap-10">
                            <OilWellAnimatedIcon class="w-10 h-10"/>

                            <h3 class="text-[14px] font-semibold text-gray-800">{{ item.Name }}</h3>
                        </div>

                        <div class="flex flex-col border border-gray-200 dark:border-gray-600 rounded-xl mt-2">
                            <div class="flex gap-2 p-3 items-center border-b border-gray-200 dark:border-gray-600">
                                <span class="text-[13px] text-gray-500 w-1/4">Номер</span>
                                <span class="text-[14px] font-medium text-gray-800 dark:text-gray-400">{{ extractWellNumber(item.Name) }}</span>
                            </div>
                            <div class="flex gap-2 p-3 items-center border-b border-gray-200 dark:border-gray-600">
                                <span class="text-[13px] text-gray-500 w-1/4">ПЛК</span>
                                <span class="text-[14px] font-medium text-gray-800 dark:text-gray-400">{{ item.PlcName }}</span>
                            </div>
                            <div class="flex gap-2 p-3 items-center border-b border-gray-200 dark:border-gray-600">
                                <span class="text-[13px] text-gray-500 w-1/4">НГДУ</span>
                                <span class="text-[14px] font-medium text-gray-800 dark:text-gray-400">{{ item.NgduName }}</span>
                            </div>
                            <div class="flex gap-2 p-3 items-center">
                                <span class="text-[13px] text-gray-500 w-1/4">Цех</span>
                                <span class="text-[14px] font-medium text-gray-800 dark:text-gray-400">{{ item.ShopName }}</span>
                            </div>
                        </div>

                        <div></div>
                    </div>

                    <div class="w-full flex flex-col gap-5 rounded-lg bg-gray-100 dark:bg-gray-700 p-5">

                        <div class="self-center flex items-center gap-1">
                            <div v-for="(source, index) in paginationClaimsTypes"
                                 :key="index"
                                 @click="paginationClaimsSource = source"
                                 class="p-2 rounded-lg"
                                 :class="paginationClaimsSource === source ?
                                 'bg-white shadow-sm text-gray-800 font-semibold' :
                                  'text-gray-300 hover:bg-gray-50 cursor-pointer font-medium'"
                            >
                                <span class="text-[13px]">{{ source }}</span>
                            </div>
                        </div>

                        <UserClaims v-if="!claimsLoading && paginationClaimsSource === 'Отправленные'" :claims="claims" />

                        <WellClaims v-if="!wellClaimsLoading && paginationClaimsSource === 'История'" :claims="wellClaims" />

                    </div>
                </div>

                <div class="w-full flex flex-col gap-2">

                    <div v-if="dnmData.length > 0"
                         class="w-full h-[400px] flex flex-col items-start border border-gray-200 dark:border-gray-700 rounded-xl">
                        <DnmChart :data="dnmData"/>
                        <div class="relative w-full mt-[20px]">

                            <div v-if="showAiReportWindow" class="absolute top-[110%] w-full">
                                <div class="relative w-full bg-white rounded-lg shadow-lg dark:border-gray-700 dark:bg-gray-900 p-4 gap-[20px]
                           flex flex-col border border-gray-200">
                                    <ClearIcon @click="showAiReportWindow = false" class="absolute top-[10px] right-[10px] cursor-pointer"/>
                                    <div class="flex items-center gap-[10px]">
                                        <DinamographLogo />
                                        <code class="text-gray-800 dark:text-white text-[14px]">Отчёт Динамографа</code>
                                    </div>
                                    <div v-if="!processingAiAnalysis && !aiError" class="flex flex-col gap-[15px] pl-2">
                                        <div v-for="(dnm, index) in predictionsData"
                                             :key="index"
                                             class="flex items-center gap-[10px]">
                                            <div :style="{ 'background-color': dnm.color }" class="rounded-full w-[10px] h-[10px]"></div>
                                            <code>{{ dnm.prediction }}</code>
                                            <span class="text-[13px] text-gray-400">{{ dnmhData.find(item => item.public_id === dnm.public_id).DnmAdress }}</span>
                                        </div>
                                    </div>
                                    <div v-else-if="aiError">
                                        <code class="text-red-500">{{ aiError }}</code>
                                    </div>
                                    <Spinner class="fill-white" v-else />
                                </div>
                            </div>

                        </div>
                    </div>
                    <div v-else class="flex flex-col gap-10 w-3/4 min-h-full items-center justify-center border border-gray-200 dark:border-gray-700 rounded-xl">
                        <Dinamogram />
                        <span class="text-gray-300 font-regular max-w-[400px] text-center">Выберите динамограмму для отображения в таблице ниже</span>
                    </div>

                    <div class="w-full flex flex-col gap-5 rounded-lg bg-gray-100 dark:bg-gray-700 p-5">
                        <div class="self-center flex items-center gap-1">
                            <div v-for="(source, index) in paginationSourceTypes"
                                 :key="index"
                                 @click="paginationSource = source"
                                 class="p-2 rounded-lg"
                                 :class="paginationSource === source ?
                                 'bg-white shadow-sm text-gray-800 font-semibold' :
                                  'text-gray-300 hover:bg-gray-50 cursor-pointer font-medium'"
                            >
                                <span class="text-[13px]">{{ source }}</span>
                            </div>
                        </div>

                        <CategoriesGrid v-if="!categoriesLoading && paginationSource === 'Параметры'" :categories="categories"/>
                    </div>

                </div>
            </div>


        </div>
    </AuthorizedLayout>
</template>
