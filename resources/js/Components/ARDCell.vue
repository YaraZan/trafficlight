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
    },
    withSetpoint: {
        type: Boolean,
        default: true
    },
    isConnected: {
        type: Boolean,
        required: true
    },
});

const getFontColor = (val) => {
    let colorClass = 'text-gray-400';

    switch (val) {
        case 2:
            colorClass= 'text-orange-400';
            break;

        case 3:
            colorClass= 'text-red-500';
            break;
    }

    if (!props.isConnected) colorClass = 'text-gray-300 dark:text-gray-600'

    return colorClass;
};

</script>

<template>
    <td v-if="withArmits" :class="getFontColor(arm)" class="text-gray-400 px-3 py-1 text-[13px] font-semibold text-center border-gray-200 dark:border-gray-700 border-l">
        <div class="flex items-center justify-center gap-2">
            <div v-if="arm && arm !== setting && arm !== '0.00'" class="bg-red-500 rounded-full w-3 h-3 flex items-center justify-center font-semibold text-white text-[12px]">
                !
            </div>

            <span v-if="arm" :class="{ 'text-gray-300 dark:text-gray-600' : arm === '0.00' }">{{ arm }}</span>
            <span v-else class="text-red-500">Пусто</span>
        </div>
    </td>
    <td v-if="withSetpoint" :class="getFontColor(stat)" class="px-3 py-1 text-[13px] font-semibold text-center border-gray-200 dark:border-gray-700 border-l">
        <span v-if="setting">{{ setting }}</span>
        <span v-else class="text-red-500">Пусто</span>
    </td>
    <td :class="getFontColor(stat)" class="px-3 py-1 text-[13px] font-semibold text-center border-gray-200 dark:border-gray-700 border-l">
        <span v-if="alarm">{{ alarm }}</span>
        <span v-else class="text-red-500">Пусто</span>
    </td>
    <td :class="getFontColor(stat)" class="px-3 py-1 text-[13px] font-semibold text-center border-gray-200 dark:border-gray-700 border-l">
        <span v-if="diff">{{ diff }}</span>
        <span v-else class="text-red-500">Пусто</span>
    </td>
</template>
