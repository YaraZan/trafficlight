<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Array,
        required: true,
    }
});

</script>

<template>
    <div class="grid grid-cols-4 gap-5">
        <Link v-for="(row, index) in data" :key="index" :href="route('operations.general', row.public_id)">
            <div class="p-4 flex flex-col bg-white rounded-lg shadow border border-gray-200 min-h-[160px] hover:bg-gray-100 cursor-pointer">
                <span class="text-lg font-semibold text-gray-800">{{ row.Name }}</span>
                <div class="flex gap-1 items-center mt-5">
                    <span class="text-sm text-gray-800">{{ row.NgduName }}</span>
                    <span class="text-sm text-gray-400">{{ row.PlcName }}</span>
                </div>
                <div class="flex gap-1 items-center mt-2">
                    <span class="text-sm text-gray-800">{{ row.ShopName }}</span>
                    <span class="text-sm text-gray-400">{{ row.HdName }}</span>
                </div>
            </div>
        </Link>
    </div>
</template>