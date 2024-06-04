<template>
        <Button
            text="Сортировка"
            @click="showFilterWindow = !showFilterWindow"
            :is-active="showFilterWindow">
            <template v-if="getSelectedNgdusLenght" v-slot:suffix>
                <span
                class="text-sm font-semibold text-gray-300 dark:text-gray-400"
                >{{ `Выбрано: ${getSelectedNgdusLenght}` }}</span>
            </template>
            <template v-slot:prefix>
                <svg width="32" height="32" viewBox="0 0 32 32" class="stroke-gray-400" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.36585 4.40405L9.33391 23.4186M6.2439 23.8804L8.18242 26.5575C8.78233 27.3859 10.0166 27.3859 10.6166 26.5575L12.5551 23.8804" stroke-width="1.8032" stroke-linecap="round"/>
                <path d="M22.6342 27.0674L22.6022 8.05289M19.5122 7.59101L21.4507 4.914C22.0506 4.08555 23.285 4.08555 23.8849 4.914L25.8234 7.59101" stroke-width="1.8032" stroke-linecap="round"/>
                </svg>

            </template>
        </Button>

</template>
