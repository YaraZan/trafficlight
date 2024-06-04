<template>
    <div class="relative flex flex-col gap-2">
        <Button
            text="Статус"
            @click="showFilterWindow = !showFilterWindow"
            :is-active="showFilterWindow">
            <template v-if="getSelectedNgdusLenght" v-slot:suffix>
                <span
                class="text-sm font-semibold text-gray-300 dark:text-gray-400"
                >{{ `Выбрано: ${getSelectedNgdusLenght}` }}</span>
            </template>
            <template v-slot:prefix>
                <svg width="32" height="32" viewBox="0 0 32 32" class="fill-gray-400" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.19512 5.46341C6.68644 5.46341 5.46341 6.68644 5.46341 8.19512V23.8049C5.46341 25.3136 6.68644 26.5366 8.19512 26.5366H23.8049C25.3136 26.5366 26.5366 25.3136 26.5366 23.8049V8.19512C26.5366 6.68644 25.3136 5.46341 23.8049 5.46341H8.19512ZM3.12195 8.19512C3.12195 5.39329 5.39328 3.12195 8.19512 3.12195H23.8049C26.6067 3.12195 28.878 5.39328 28.878 8.19512V23.8049C28.878 26.6067 26.6067 28.878 23.8049 28.878H8.19512C5.39329 28.878 3.12195 26.6067 3.12195 23.8049V8.19512ZM12.4878 23.0244C12.4878 22.3779 13.0119 21.8537 13.6585 21.8537H23.8049C24.4514 21.8537 24.9756 22.3779 24.9756 23.0244C24.9756 23.671 24.4514 24.1952 23.8049 24.1952H13.6585C13.0119 24.1952 12.4878 23.671 12.4878 23.0244ZM8.58528 7.80487C7.9387 7.80487 7.41455 8.32902 7.41455 8.9756C7.41455 9.62218 7.9387 10.1463 8.58528 10.1463H18.7316C19.3782 10.1463 19.9024 9.62218 19.9024 8.9756C19.9024 8.32902 19.3782 7.80487 18.7316 7.80487H8.58528ZM7.41455 13.2683C7.41455 12.6217 7.9387 12.0976 8.58528 12.0976H14.4389C15.0855 12.0976 15.6097 12.6217 15.6097 13.2683C15.6097 13.9149 15.0855 14.4391 14.4389 14.4391H8.58528C7.9387 14.4391 7.41455 13.9149 7.41455 13.2683ZM8.97562 24.1951C9.6222 24.1951 10.1463 23.671 10.1463 23.0244C10.1463 22.3778 9.6222 21.8537 8.97562 21.8537C8.32904 21.8537 7.80489 22.3778 7.80489 23.0244C7.80489 23.671 8.32904 24.1951 8.97562 24.1951Z"/>
                </svg>
            </template>
        </Button>

        <div v-show="showFilterWindow" class="z-[50] p-4 top-[105%] absolute flex flex-col gap-2 w-auto shadow-lg dark:shadow-2xl bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg select-none">
            <!-- Drop all button -->
            <DropAll v-if="selectedStatuses.length > 0" @click="dropAllStatuses" />
            <!-- Status cards -->
            <div v-if="!dataLoading && data.length > 0" class="w-full flex flex-col gap-1">
                <div v-for="(status, index) in data"
                @click="selectStatus(status)"
                :key="index"
                class="flex items-center gap-2 p-2 w-full border border-gray-200
                 dark:border-gray-800 rounded-lg cursor-pointer hover:border-gray-300 dark:hover:border-gray-700">
                    <!-- Checkbox -->
                    <div
                    :class="{ 'border-green-400 bg-green-400' : isSelected(status) }"
                    class="flex items-center justify-center w-4 h-4 rounded-md border border-gray-200 dark:border-gray-800">
                        <span v-if="isSelected(status)" class="text-[13px] text-white font-semibold">{{ getNumber(status) }}</span>
                    </div>
                    <span :class="`text-${status.color}-500`" class="text-[12px] font-semibold whitespace-nowrap">{{ status.name }}</span>
                </div>
            </div>
            <!-- No data -->
            <div v-else-if="!dataLoading && data.length === 0" class="w-full py-10 flex items-center justify-center">
                <span class="text-[13px] text-gray-300 dark:text-gray-600 font-semibold">Нет данных</span>
            </div>
            <!-- Loading -->
            <div v-else class="w-full py-10 flex items-center justify-center">
                <Spinner class="fill-gray-400" />
            </div>
        </div>
    </div>

</template>

<script setup>
import axios from 'axios';
import { computed, onMounted, ref, watch } from 'vue';
import { Spinner } from 'flowbite-vue';
import Button from '@/Components/Button.vue';
import DropAll from './DropAll.vue'

const showFilterWindow = ref(false);
const dataLoading = ref(false);
const data = ref([]);
const selectedStatuses = ref([]);

function fetchNgdu() {
    dataLoading.value = true;

    axios.get('/api/claim_statuses/all')
    .catch(err => {
        dataLoading.value = false;
    }).then(res => {
        data.value = res.data;
        dataLoading.value = false;
    })
};

function isSelected(status) {
    return selectedStatuses.value.includes(status)
}

function getNumber(status) {
    return selectedStatuses.value.indexOf(status) + 1;
}

function selectStatus(status) {
    if (isSelected(status)) {
        selectedStatuses.value.splice(selectedStatuses.value.indexOf(status), 1);
        return;
    }
    selectedStatuses.value.push(status);

}

const selectedStatusIds = computed(() => {
    return selectedStatuses.value.map(item => {return item.id});
})

function dropAllStatuses() {
    selectedStatuses.value = []
}

const getSelectedNgdusLenght = computed(() => {
    return selectedStatuses.value.length;
})

onMounted(() => {
    fetchNgdu();
})

watch(selectedStatusIds, (newValue) => {
    emit('change', newValue);
}, { deep: true });

const emit = defineEmits(['change']);
</script>
