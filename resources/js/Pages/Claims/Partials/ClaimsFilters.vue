<template>
    <button @click="showFiltersWindow = !showFiltersWindow"
        :class="{ 'border-green-400' : showFiltersWindow }"
        class="px-8 py-2 flex items-center bg-white shadow border-gray-200 dark:bg-gray-700 dark:border-gray-600
        border rounded-md hover:bg-gray-50 dark:hover:bg-gray-900 gap-4">
        <svg class="w-6 h-6 stroke-gray-400 fill-none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22 3H2L10 12.46V19L14 21V12.46L22 3Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>

        <span class="text-sm font-semibold text-gray-800 dark:text-white">Фильтры</span>
    </button>

    <div v-if="showFiltersWindow" @click="showFiltersWindow = !showFiltersWindow" class="fixed z-50 inset-0 w-screen h-screen flex justify-end">
        <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75" />
        </Transition>

        <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
            <div @click="preventClose" class="z-[51] w-[500px] h-full bg-white opacity-100 border-l-2 border-gray-400">
                <div class="p-4 pb-16 flex items-center justify-between gap-20 border-b border-gray-200">
                    <span class="font-semibold text-gray-800 text-md">Фильтрация заявок</span>
                    <svg @click="showFiltersWindow = false" class="w-6 h-6 fill-none stroke-gray-300 hover:stroke-gray-800 cursor-pointer" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6 6L18 18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <WellFilter />
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import WellFilter from './WellFilter.vue';

const showFiltersWindow = ref(false);

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && showFiltersWindow.value) {
        close();
    }
};

const preventClose = (e) => {
    e.stopPropagation()
}

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});
</script>
