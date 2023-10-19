<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Array,
        required: true,
    }
});

function getColorClass(value) {
  let colorClass = '';

  switch (true) {
    case value < 5:
      colorClass = 'bg-green-500';
      break;

    case value >= 5 && value < 10:
      colorClass = 'bg-orange-400';
      break;

    case value >= 10 && value < 100:
      colorClass = 'bg-red-500';
      break;

    case value >= 100:
      colorClass = 'bg-red-600';
      break;

    default:
      colorClass = 'bg-gray-500'; // Default to gray if none of the conditions are met
      break;
  }

  return colorClass;
}

</script>

<template>
    <div class="grid grid-cols-5 gap-5">
        <Link v-for="(row, index) in data" :key="index" :href="route('operations.detail', row.public_id)">
            <div class="group p-4 flex justify-between bg-white rounded-lg shadow border border-gray-200 min-h-[160px] hover:bg-gray-100 cursor-pointer">
                <div class="flex flex-col">
                    <span :class="row.Connect ? 'text-gray-800' : 'text-gray-300'" class="text-lg font-semibold">{{ row.Name }}</span>
                    <div class="flex gap-2 items-center mt-5">
                        <span :class="row.Connect ? 'text-gray-800' : 'text-gray-300'" class="text-sm">{{ row.NgduName }}</span>
                        <span :class="row.Connect ? 'text-gray-400' : 'text-gray-300'" class="text-sm">{{ row.ShopName }}</span>
                    </div>
                    <div class="flex gap-2 items-center mt-2">
                        <span :class="row.Connect ? 'text-gray-800' : 'text-gray-300'" class="text-sm">{{ row.HdName }}</span>
                        <span :class="row.Connect ? 'text-gray-400' : 'text-gray-300'" class="text-sm">{{ row.PlcName }}</span>
                    </div>
                </div>
                <div class="flex gap-3 h-auto">
                    <div v-for="(item, index) in [row.Dif1, row.Dif2, row.Dif3,]"  :key="index" class="group-hover:bg-gray-50  flex flex-col flex-nowrap justify-end w-2 h-28 bg-gray-100 rounded-full overflow-hidden dark:bg-gray-700">
                        <div :class="row.Connect ? getColorClass(item) : 'bg-gray-300'" :style="item ? { height: `${item}%` } : { height: '0%' }" class="overflow-hidden" role="progressbar"></div>
                    </div>
                </div>
            </div>
        </Link>
    </div>
</template>