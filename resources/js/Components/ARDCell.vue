<script setup>
import WarningIcon from './Toasts/WarningIcon.vue';
import ErrorIcon from './Toasts/ErrorIcon.vue';

const props = defineProps({
    alarm: {
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
    <td :class="getFontColor(stat)" class="h-[30px] rounded-lg p-2 font-semibold text-center border-gray-200 dark:border-gray-700 border-l">
        {{ alarm }}
    </td>
    <td :class="getFontColor(stat)" class="h-[30px] rounded-lg p-2 font-semibold text-center border-gray-200 dark:border-gray-700 border-l">
        {{ setting }}
    </td>
    <td :class="getFontColor(stat)" class="h-[30px] rounded-lg p-2 font-semibold text-center border-gray-200 dark:border-gray-700 border-l">
        {{ diff }}
    </td>
</template>
