<template>
    <div class="relative w-full h-[47px] flex items-center">
        <input
        v-model="model"
        :type="inputType"
        placeholder="Пароль"
        class="w-full h-full px-5 py-3 border border-gray-300 dark:border-gray-700 bg-transparent
         placeholder:text-gray-300 dark:placeholder:text-gray-700 rounded-[10px] placeholder:text-sm
         text-sm text-gray-800 dark:text-white font-semibold placeholder:font-medium focus:border-green-400
         dark:focus:border-green-400 focus:ring-0 ring-0" />

        <div @click="toggleShowPassword" class="group absolute right-3 flex items-center justify-center cursor-pointer">
            <svg v-if="inputType === 'password'" class="stroke-gray-300 dark:stroke-gray-400 group-hover:stroke-gray-400 dark:group-hover:stroke-gray-500" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.6818 9.01701C8.24616 9.17866 4.0096 14.139 2.75232 15.8738C2.49328 16.2313 2.49962 16.6976 2.76881 17.0474C4.04633 18.7079 8.27834 23.3617 15.6818 23.5227C23.0177 23.6822 28.0182 18.9114 29.6278 17.127C29.9731 16.7441 29.9815 16.1837 29.647 15.7914C28.0581 13.928 23.047 8.8569 15.6818 9.01701Z" stroke-width="2.35227"/>
            <circle cx="16.0739" cy="16.0738" r="3.65909" stroke-width="1.82955"/>
            </svg>
            <svg v-if="inputType === 'text'" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path class="fill-gray-300 dark:fill-gray-400 group-hover:fill-gray-400 dark:group-hover:fill-gray-500" fill-rule="evenodd" clip-rule="evenodd" d="M23.8687 22.8847C27.2168 21.2772 29.5034 19.0209 30.5012 17.9147C31.2411 17.0944 31.2601 15.8705 30.5419 15.0283C28.8992 13.1017 23.5769 7.66897 15.6563 7.84116C13.8541 7.88034 12.2279 8.18178 10.7745 8.64631L12.563 10.5911C13.5328 10.3609 14.5807 10.2174 15.7074 10.1929C22.3834 10.0477 27.0317 14.5714 28.658 16.4452C27.6228 17.5724 25.3855 19.6926 22.1926 21.0621L23.8687 22.8847ZM19.9044 18.574C20.3744 17.8554 20.6477 16.9965 20.6477 16.0738C20.6477 13.5477 18.5999 11.5 16.0738 11.5C15.2879 11.5 14.5483 11.6982 13.9022 12.0473L15.2092 13.4685C15.481 13.3783 15.7717 13.3295 16.0738 13.3295C17.5894 13.3295 18.8181 14.5582 18.8181 16.0738C18.8181 16.457 18.7396 16.8218 18.5977 17.1531L19.9044 18.574ZM16.8349 18.7112L18.1557 20.1475C17.5312 20.4673 16.8236 20.6477 16.0738 20.6477C13.5477 20.6477 11.4999 18.5999 11.4999 16.0738C11.4999 15.1874 11.7521 14.3598 12.1886 13.659L13.5092 15.095C13.3931 15.399 13.3295 15.729 13.3295 16.0738C13.3295 17.5895 14.5581 18.8181 16.0738 18.8181C16.3379 18.8181 16.5932 18.7808 16.8349 18.7112ZM10.1171 11.4064C6.7511 12.8701 4.66038 15.2754 3.79119 16.4461C5.07847 18.0779 8.99058 22.2008 15.7074 22.3468C17.1561 22.3783 18.5092 22.2019 19.7565 21.8882L21.5358 23.8229C19.7838 24.3948 17.8165 24.7455 15.6563 24.6986C7.7313 24.5263 3.20493 19.543 1.83663 17.7646C1.24928 17.0013 1.23569 15.9623 1.79996 15.1837C2.66115 13.9954 4.85297 11.3573 8.44436 9.58756L10.1171 11.4064Z" />
            <path class="stroke-gray-300 dark:stroke-gray-400 group-hover:stroke-gray-400 dark:group-hover:stroke-gray-500" d="M7.05676 4.70453L27.2471 26.6591" stroke-width="2.35227"/>
            </svg>
        </div>
    </div>

</template>

<script setup>
import { ref } from 'vue';

const model = defineModel();

const inputType = ref('password');

function toggleShowPassword() {
    if (inputType.value === 'password') {
        inputType.value = 'text'
    } else {
        inputType.value = 'password'
    }
}
</script>
