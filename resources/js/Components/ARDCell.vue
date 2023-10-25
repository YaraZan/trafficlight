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
            colorClass= 'bg-gray-100';
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
    let colorClass = 'text-white';

    switch (val) {
        case 1:
            colorClass= 'text-gray-400';
            break;
    }

    return colorClass;
};

</script>

<template>
    <td class="px-6 py-4 text-left border-l border-gray-200">
        <div class="flex items-center gap-2">
            <div :class="getBgColor(stat)" class="flex gap-2 h-[30px] rounded-lg p-2">
                <div class="flex items-center gap-1">
                    <span :class="getFontColor(stat)">Ф:</span>
                    <span :class="getFontColor(stat)" class="font-semibold">{{ alarm }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <span :class="getFontColor(stat)">У:</span>
                    <span :class="getFontColor(stat)" class="font-semibold">{{ setting }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <span :class="getFontColor(stat)">О:</span>
                    <span :class="getFontColor(stat)" class="font-semibold">{{ diff }}</span>
                </div>
            </div>  
            <WarningIcon v-if="stat === 2"/>
            <ErrorIcon v-if="stat === 3"/>
        </div>
    </td>
</template>