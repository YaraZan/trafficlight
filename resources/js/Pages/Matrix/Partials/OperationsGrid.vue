<script setup>
import { Link } from '@inertiajs/vue3';
import 'flowbite';

const props = defineProps({
    data: {
        type: Array,
        required: true,
    }
});

function getColorClass(value) {
  let colorClass = '';

  switch (value) {
    case 1:
      colorClass = 'bg-green-400 dark:bg-green-500';
      break;

    case 2:
      colorClass = 'bg-orange-400 dark:bg-orange-400';
      break;

    case 3:
      colorClass = 'bg-red-400 dark:bg-red-500';
      break;

    default:
      colorClass = 'bg-gray-100 dark:bg-gray-700';
      break;
  }

  return colorClass;
}

function getColorBgClass(value) {
  let colorClass = '';

  switch (value) {
    case 1:
      colorClass = 'bg-green-100 dark:bg-green-900 dark:bg-opacity-60';
      break;

    case 2:
      colorClass = 'bg-orange-100 dark:bg-orange-900 dark:bg-opacity-60';
      break;

    case 3:
      colorClass = 'bg-red-100 dark:bg-red-900 dark:bg-opacity-60';
      break;

    default:
      colorClass = 'bg-gray-100 group-hover:bg-gray-50 dark:bg-gray-700 dark:group-hover:bg-gray-700';
      break;
  }

  return colorClass;
}

</script>

<template>
    <div class="grid grid-cols-1 gap-[10px] sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
        <Link v-for="(row, index) in data" :key="index" :href="route('matrix.detail', row.public_id)">
            <div
                class="group p-4 flex justify-between bg-white rounded-lg shadow border border-gray-200 min-h-[160px]
                 dark:bg-gray-900 dark:border-gray-700 cursor-pointer hover:border-green-500 dark:hover:border-green-500
                 ">
                <div class="flex flex-col">
                    <span
                        :class="row.Connect ? 'text-gray-800 dark:text-gray-300' : 'text-gray-300 dark:text-gray-600'"
                        class="text-[15px] font-semibold"
                    >{{ row.Name }}</span>
                    <div class="flex gap-2 items-center mt-5">
                        <span
                            :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-300 dark:text-gray-600'"
                            class="text-[13px]">{{ row.NgduName }}</span>
                        <span
                            :class="row.Connect ? 'text-gray-400 dark:text-gray-500' : 'text-gray-300 dark:text-gray-600'"
                            class="text-[13px]">{{ row.ShopName }}</span>
                    </div>
                    <div class="flex gap-2 items-center mt-2">
                        <span
                            :class="row.Connect ? 'text-gray-800 dark:text-gray-400' : 'text-gray-300 dark:text-gray-600'"
                            class="text-[13px]">{{ row.HdName }}</span>
                        <span
                            :class="row.Connect ? 'text-gray-400 dark:text-gray-500' : 'text-gray-300 dark:text-gray-600'"
                            class="text-[13px]">{{ row.PlcName }}</span>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div v-for="(item, index) in [
                        {dif: row.Dif1, stat:row.Stat1, name: 'Число качаний'},
                         {dif: row.Dif2, stat:row.Stat2, name: 'Нагрузка максимальная'},
                          {dif: row.Dif3, stat:row.Stat3, name: 'Нагрузка минимальная'}
                          ]"
                    :class="row.Connect ? getColorBgClass(item.stat) : 'bg-gray-100 group-hover:bg-gray-50 dark:bg-gray-800 dark:group-hover:bg-gray-700'"
                    :key="index"
                    class="relative flex flex-col flex-nowrap justify-end w-2 h-28 rounded-full overflow-hidden">
                        <div
                        :class="row.Connect ? getColorClass(item.stat): 'bg-gray-300 dark:bg-gray-700 dark:group-hover:bg-gray-600'"
                        :style="item.dif ? { height: `${item.dif}%` } : { height: '0%' }"
                        class="overflow-hidden"
                        role="progressbar"></div>
                    </div>
                </div>


            </div>
        </Link>
    </div>
</template>
