<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import SubAsideLink from '@/Components/SubAsideLink.vue';
import UserDefaultIcon from '@/Components/Icons/UserDefaultIcon.vue';
import {encryptStorage} from "@/utils/storage.js";


const props = defineProps({
    profile_data: {
        type: Object
    },
});

const DINAMOGRAPH_API_URL = import.meta.env.VITE_DINAMOGRAPH_API_URL;
const API_KEY =import.meta.env.VITE_DINAMOGRAPH_API_KEY;

const aiModels = ref([])

const processingLoadData = ref(false)

const getAiModels = () => {
    processingLoadData.value = true

    return axios.get(`${DINAMOGRAPH_API_URL}/v1/ai/models`, {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Basic ${API_KEY}`
        },
    })
    .then(response => {
        aiModels.value = response.data.models;
    })
    .catch(error => {
        processingLoadData.value = false;
    })
    .finally(() => {
        processingLoadData.value = false;
    })
}

const handleChangeAiModelVersion = (version) => {
    encryptStorage.setItem('aiv', version)
}

onMounted(() => {
    getAiModels()
})

</script>

<template>
    <Head title="Профиль" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('settings.profile')">
                <BreadCrumb
                :name="'Настройки'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="flex w-2/3 p-[50px] items-center">

            <div class="flex flex-col gap-[80px]">

                <div class="flex flex-col gap-[40px] max-w-[800px]">
                    <div class="flex items-center gap-[20px]">
                        <span class="text-gray-800 dark:text-white font-semibold text-[24px]">Пользователь</span>
                        <Link
                            :href="route('logout')"
                            :method="'post'"
                            as="button"
                            type="submit"
                            class="border border-gray-200 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-opacity-80 dark:bg-gray-700 px-3 py-2 w-18 rounded-lg font-medium flex items-center justify-center hover:bg-gray-50"
                        >
                            Выход
                        </Link>
                    </div>

                    <div class="flex flex-col gap-[20px]">
                        <div class="flex items-center gap-[40px]">
                            <span class="text-gray-400 text-[13px]">ФИО</span>
                            <span class="font-semibold">{{ profile_data.name }}</span>
                        </div>
                        <div class="flex items-center gap-[40px]">
                            <span class="text-gray-400 text-[13px]">Почта</span>
                            <span>{{ profile_data.email }}</span>
                        </div>
                        <div class="flex items-center gap-[40px]">
                            <span class="text-gray-400 text-[13px]">Роль</span>
                            <span class="px-2 py-1 border border-green-600 rounded-full font-semibold text-green-600 text-xs ">{{ profile_data.role.name }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-[40px] max-w-[800px]">
                    <div class="flex items-center gap-[20px]">
                        <span class="text-gray-800 dark:text-white font-semibold text-[24px]">Версия AI</span>
                        <div class="flex items-center bg-purple-200 justify-center p-1 rounded-[5px]">
                            <span class="text-[11px] uppercase font-bold text-purple-800">бета</span>
                        </div>
                    </div>

                    <select @change="handleChangeAiModelVersion($event.target.value)" class="block p-2 text-sm font-semibold dark:hover:bg-opacity-80 text-gray-900 border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 border-gray-300 rounded-lg bg-gray-50 focus:ring-green-600 focus:border-green-600 cursor-pointer">
                        <option v-for="(aiModel, index) in aiModels"
                                :selected="encryptStorage.getItem('aiv') === aiModel.public_id"
                                :key="index"
                                :value="aiModel.public_id">
                            {{ aiModel.name }}
                        </option>
                    </select>

                </div>

            </div>

        </div>

    </AuthorizedLayout>
</template>
