<script setup>
import { Table, TableHead, TableBody, TableHeadCell, TableRow, TableCell } from 'flowbite-vue';
import SortIcon from '@/Components/Icons/SortIcon.vue';
import ARDCell from '@/Components/Matrix/ARDCell.vue';


const props = defineProps({
    data: {
        type: Array
    }
});

const params = ['Скважина', 'Состояние', 'Дата', 'Штраф', 'Опрос', 'Связь',
 'Число качаний, об/мин', 'Нагрузка максимальная, кг',
 'Нагрузка минимальная, кг', 'Температура масла в ГБ, °С', 'Давление в ГН , МПа',
 'Давление в ГЦ , МПа', 'Давление в ПГА, МПа', 'Ток, А', 'Напряжение, В'];
</script>

<template>
 <Table striped>
    <table-head class="border-b border-t border-gray-200">
        <table-head-cell v-for="param in params">
            <div class="flex items-center">
                {{ param }}
                <SortIcon />
            </div>
        </table-head-cell>
    </table-head>
    <table-body>
        <table-row v-for="row in data" :key="row.id" class="border-b border-gray-200">
            <table-cell class="font-bold">{{ row.WellName }}</table-cell>
            <table-cell>{{ row.WellState }}</table-cell>
            <table-cell>{{ row.Date }}</table-cell>
            <table-cell>{{ row.SumErr }}</table-cell>
            <table-cell>
                <span v-if="row.Ask" class="p-2 bg-green-100 text-green-400 rounded-md">Выполнен</span>
                <span v-else class="p-2 bg-red-100 text-red-400 rounded-md">Нет</span>
            </table-cell>
            <table-cell>
                <span v-if="row.Connect" class="p-2 bg-green-100 text-green-400 rounded-md">Установлена</span>
                <span v-else class="p-2 bg-red-100 text-red-400 rounded-md">Потеряна</span>
            </table-cell>
            <ARDCell :alarm="row.Alarm1" :setting="row.Ref1" :diff="row.Dif1" :stat="row.Stat1"></ARDCell>
            <ARDCell :alarm="row.Alarm2" :setting="row.Ref2" :diff="row.Dif2" :stat="row.Stat2"></ARDCell>
            <ARDCell :alarm="row.Alarm3" :setting="row.Ref3" :diff="row.Dif3" :stat="row.Stat3"></ARDCell>
            <ARDCell :alarm="row.Alarm4" :setting="row.Ref4" :diff="row.Dif4" :stat="row.Stat4"></ARDCell>
            <ARDCell :alarm="row.Alarm6" :setting="row.Ref6" :diff="row.Dif6" :stat="row.Stat6"></ARDCell>
            <ARDCell :alarm="row.Alarm7" :setting="row.Ref7" :diff="row.Dif7" :stat="row.Stat7"></ARDCell>
            <ARDCell :alarm="row.Alarm8" :setting="row.Ref8" :diff="row.Dif8" :stat="row.Stat8"></ARDCell>
            <ARDCell :alarm="row.Alarm11" :setting="row.Ref11" :diff="row.Dif11" :stat="row.Stat11"></ARDCell>
            <ARDCell :alarm="row.Alarm12" :setting="row.Ref12" :diff="row.Dif12" :stat="row.Stat12"></ARDCell>
        </table-row>
    </table-body>
</Table>   
</template>

