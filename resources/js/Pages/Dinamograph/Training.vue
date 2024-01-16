<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import SubAsideLink from '@/Components/SubAsideLink.vue';
import UserDefaultIcon from '@/Components/Icons/UserDefaultIcon.vue';
import {Img} from "flowbite-vue";
import TrainInputList from "@/Components/TrainInputList.vue";


const props = defineProps({
    profile_data: {
        type: Object
    },
});

const dnmObject = ref(null);
const markers = ref(null);
const viewingList = ref(false);

const markerSearchFilter = ref('');

const fetchRandomDinamogram = (public_id) => {
    return axios.get(import.meta.env.VITE_DINAMOGRAPH_API_URL + `/d/${public_id}`, {
        headers: {
            'Content-Type': 'application/json',
            'x-api-key': import.meta.env.VITE_DINAMOGRAPH_API_KEY
        },
    })
    .then((response) => {
        return response.data;
    })
    .catch((error) => {
        console.error('Ошибка при получении динамограммы', error);
    });
}

const fetchMarkers = () => {
    return axios.get(import.meta.env.VITE_DINAMOGRAPH_API_URL + '/m', {
        headers: {
            'Content-Type': 'application/json',
            'x-api-key': import.meta.env.VITE_DINAMOGRAPH_API_KEY
        },
    })
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            console.error('Ошибка при получении динамограммы', error);
        });
}

onMounted(() => {
    fetchRandomDinamogram(props.profile_data.public_id)
    .then((data) => {
        dnmObject.value = data.data;
    });

    fetchMarkers()
    .then((data) => {
        markers.value = data.data;
    });
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
                    :name="'Тренировка'"
                ></BreadCrumb>
            </Link>
        </template>

        <template #subAside>
            <div class="w-full h-full flex flex-col">
                <div class="flex items-center text-gray-800 h-[51px] font-semibold dark:text-gray-300 text-sm px-4 border-b border-gray-200 dark:border-gray-700">Динамограф</div>
                <div class="flex flex-col p-2 gap-1">
                    <Link :href="route('settings.profile')">
                        <SubAsideLink
                            :text="'Тренировка'"
                            :active="$page.component.includes('Dinamograph/Training')"
                        />
                    </link>
                </div>
            </div>
        </template>

        <div class="flex w-full p-4 items-center justify-center">

            <div v-if="dnmObject" class="flex flex-col w-2/3 items-center justify-center">
                <img
                     :src="dnmObject.url"
                     class="w-2/3 rounded-2xl shadow-xl" />
                <div class="flex relative w-full gap-[20px] items-center mt-[200px]">
                    <TrainInputList v-if="filtredData && viewingList" :markers="filtredData" />
                    <input @click="viewingList = !viewingList"
                           v-model="markerSearchFilter"
                           class="w-full border rounded-xl focus:ring-green-600
                           focus:border-green-500 h-[52px]
                           focus:bg-green-100 focus:bg-opacity-10 hover:border-green-500
                           dark:focus:bg-green-100 dark:focus:bg-opacity-10 dark:hover:border-green-500
                           text-green-500 text-md font-medium
                           border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800"
                           type="text"
                           placeholder="Категория"
                           required="" />
                    <button
                        class="flex gap-2 bg-green-600 px-4 py-2
                        h-[52px] items-center
                        border border-green-500 rounded-lg text-white text-sm
                        font-semibold hover:bg-opacity-80 dark:hover:bg-opacity-80">
                        Отправить
                    </button>
                </div>

            </div>
            <div v-else>Пусто</div>

        </div>

    </AuthorizedLayout>
</template>
