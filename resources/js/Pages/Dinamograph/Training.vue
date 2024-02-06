<script setup>
import {Head, Link} from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import {computed, onMounted, ref} from 'vue';
import SubAsideLink from '@/Components/SubAsideLink.vue';
import {Img, Spinner} from "flowbite-vue";
import TrainInputList from "@/Components/TrainInputList.vue";
import ClearIcon from "@/Components/Icons/ClearIcon.vue";


const props = defineProps({
    profile_data: {
        type: Object
    },
});

const API_URL = import.meta.env.VITE_DINAMOGRAPH_API_URL;
const API_KEY =import.meta.env.VITE_DINAMOGRAPH_API_KEY;

const dnmObject = ref(null);
const markers = ref(null);
const viewingList = ref(false);
const selectedMarkers = ref([]);
const markerSearchFilter = ref('');
const processing = ref(false);

const fetchRandomDinamogram = (public_id) => {
    return axios.get(API_URL + `/v1/dnm/random/${public_id}`, {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Basic ${API_KEY}`
        },
    })
    .then((response) => {
        dnmObject.value = response.data;
    })
    .catch((error) => {
        console.error('Ошибка при получении динамограммы', error);
    });
}

const fetchMarkers = () => {
    return axios.get(API_URL + '/v1/marker/all', {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Basic ${API_KEY}`
        },
    })
        .then((response) => {
            markers.value = response.data;
        })
        .catch((error) => {
            console.error('Ошибка при получении маркеров', error);
        });
}

const selectMarker = (markerObj) => {
    viewingList.value = false;
    markerSearchFilter.value = '';

    if (selectedMarkers.value.find(item => item.id === markerObj.id) || selectedMarkers.value.length >= 3) return

    selectedMarkers.value.push(markerObj);
}

const validateInput = () => {
    return selectedMarkers.value && dnmObject.value;
}

const markDinamogram = () => {
    if (!validateInput()) return

    processing.value = true;

    const mDataArr = []

    selectedMarkers.value.forEach(item => {
        mDataArr.push({
            id: dnmObject.value.id,
            marker_id: item.id,
        })
    })

    axios.post(API_URL + '/v1/dnm/mark', mDataArr, {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Basic ${API_KEY}`
        },
    })
    .then(() => {
        fetchRandomDinamogram(props.profile_data.public_id);
        fetchMarkers();
    })
    .catch(() => {
        processing.value = false;
        selectedMarkers.value = null
    })
    .finally(() => {
        processing.value = false;
        selectedMarkers.value = null
    });
}

onMounted(() => {
    fetchRandomDinamogram(props.profile_data.public_id);
    fetchMarkers();


})

const filtredData = computed(() => {
    let data = markers.value;

    if (markerSearchFilter.value !== '') {
        data = data.filter(marker => marker.name.toLowerCase().includes(markerSearchFilter.value.toLowerCase()))
    }

    return data
})

</script>

<template>
    <Head title="Динамограф / Тренировка" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('dinamograph.training')">
                <BreadCrumb
                    :name="'Разметка данных'"
                ></BreadCrumb>
            </Link>
        </template>

        <template #subAside>
            <div class="w-full h-full flex flex-col">
                <div class="flex items-center text-gray-800 h-[51px] font-semibold dark:text-gray-300 text-sm px-4 border-b border-gray-200 dark:border-gray-700">Динамограф</div>
                <div class="flex flex-col p-2 gap-1">
                    <Link :href="route('settings.profile')">
                        <SubAsideLink
                            :text="'Разметка данных'"
                            :active="$page.component.includes('Dinamograph/Training')"
                        />
                    </link>
                </div>
            </div>
        </template>

        <div class="flex w-full p-4 items-center justify-center">

            <div v-if="dnmObject && !processing" class="flex flex-col w-2/3 items-center justify-center">
                <img
                    :src="API_URL + '/' + dnmObject.url"
                    class="w-2/3 rounded-2xl shadow-xl" />
                <div class="flex relative w-full gap-[10px] items-center mt-[200px]">
                    <Transition
                        enter-active-class="transition ease-out duration-200"
                        enter-from-class="opacity-0 translateX-95"
                        enter-to-class="opacity-100 translateX-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="opacity-100 translateX-100"
                        leave-to-class="opacity-0 translateX-95"
                    >
                        <TrainInputList :url="API_URL" @select="selectMarker" v-if="filtredData && viewingList" :markers="filtredData" />
                    </Transition>
                    <div class="absolute left-[5px] flex items-center gap-[5px] overflow-x-auto">
                        <div v-if="selectedMarkers" v-for="(marker, index) in selectedMarkers"
                             :key="index"
                             class="cursor-pointer flex items-center justify-center
                                p-2 rounded-[5px] bg-gray-50 dark:bg-gray-700 gap-[10px]" >
                            <span class="text-green-500">{{ marker.name }}</span>
                            <ClearIcon @click="selectedMarkers = selectedMarkers.filter(item => item.id !== marker.id)" />
                        </div>
                    </div>
                    <input @click="viewingList = !viewingList"
                           @input="viewingList = true"
                           v-model="markerSearchFilter"
                           class="w-full border rounded-xl focus:ring-0 focus:ring-offset-0
                           focus:border-green-500 h-[52px] placeholder-gray-400
                           hover:border-green-500 dark:focus:border-green-500
                           dark:hover:border-green-500
                           text-green-500 text-md font-medium
                           border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800"
                           type="text"
                           placeholder="Категория"
                           required="" />
                    <button @click="markDinamogram"
                            class="flex gap-2 bg-green-600 px-4 py-2
                        h-[52px] w-[150px] items-center justify-center
                        border border-green-500 rounded-lg text-white text-sm
                        font-semibold hover:bg-opacity-80 dark:hover:bg-opacity-80">
                        <Spinner color="green" v-if="processing" />
                        <span v-else>Отправить</span>
                    </button>
                </div>

            </div>

            <div v-else class="w-2/3 flex flex-col items-center">
                <div class="animate-pulse w-2/3 bg-gray-100 dark:bg-gray-700 rounded-2xl h-[400px]" />

                <div class="flex relative w-full gap-[20px] items-center mt-[200px]">
                    <div class="animate-pulse bg-gray-100 dark:bg-gray-700 h-[52px] w-full rounded-lg"></div>
                    <div class="animate-pulse bg-gray-100 dark:bg-gray-700 h-[52px] w-[150px] rounded-lg"></div>
                </div>
            </div>

        </div>

    </AuthorizedLayout>
</template>
