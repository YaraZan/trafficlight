<script setup>
import WarningIcon from './Toasts/WarningIcon.vue';
import ErrorIcon from './Toasts/ErrorIcon.vue';

const props = defineProps({
    alarm: {
        type: String
    },
    arm: {
        type: String
    },
    setting : {
        type: String
    },
    diff: {
        type: String
    },
    stat: {
        type: Number
    },
    withArmits: {
        type: Boolean,
        default: false
    }
});

const getBgColor = (val) => {
    let colorClass = '';

    switch (val) {
        case 0:
            colorClass= 'bg-gray-100 dark:bg-gray-900 dark:bg-opacity-40';
            break;

        case 2:
            colorClass= 'bg-orange-400';
            break;

        case 3:
            colorClass= 'bg-red-500';
            break;

        default:
            break;
    }

    return colorClass;
};

const getFontColor = (val) => {
    let colorClass = 'text-gray-300 dark:text-gray-600';

    switch (val) {
        case 1:
            colorClass= 'text-gray-400';
            break;

        case 2:
            colorClass= 'text-orange-400';
            break;

        case 3:
            colorClass= 'text-red-500';
            break;
    }

    return colorClass;
};

</script>

<template>
    <td v-if="withArmits" class="text-gray-400 p-2 font-semibold text-center border-gray-200 dark:border-gray-700 border-l">
        <div class="flex items-center justify-center gap-2">
            <div v-if="arm && arm !== setting && arm !== '0.00'" class="bg-red-500 rounded-full w-4 h-4 flex items-center justify-center font-semibold text-white text-[13px]">
                !
            </div>

            <span v-if="arm" :class="{ 'text-gray-300 dark:text-gray-600' : arm === '0.00' }">{{ arm }}</span>
            <span v-else class="text-red-500">Пусто</span>
        </div>
    </td>
    <td :class="getFontColor(stat)" class="p-2 font-semibold text-center border-gray-200 dark:border-gray-700 border-l">
        <span v-if="setting">{{ setting }}</span>
        <span v-else class="text-red-500">Пусто</span>
    </td>
    <td :class="getFontColor(stat)" class="p-2 font-semibold text-center border-gray-200 dark:border-gray-700 border-l">
        <span v-if="alarm">{{ alarm }}</span>
        <span v-else class="text-red-500">Пусто</span>
    </td>
    <td :class="getFontColor(stat)" class="p-2 font-semibold text-center border-gray-200 dark:border-gray-700 border-l">
        <span v-if="diff">{{ diff }}</span>
        <span v-else class="text-red-500">Пусто</span>
    </td>
</template>
