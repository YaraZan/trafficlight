<script setup>
import { ref } from 'vue';
import { Dropdown, Input, Button, Checkbox, ListGroup, ListGroupItem } from 'flowbite-vue';
import TrafficLightLayout from '@/Layouts/TrafficLightLayout.vue';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import Table from '@/Pages/Matrix/Partials/Table.vue'
import Filtericon from '@/Components/Icons/FilterIcon.vue';
import SearchIcon from '@/Components/Icons/SearchIcon.vue';
import ActionsIcon from '@/Components/Icons/ActionsIcon.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Array
    },
});

const search = ref('');
const chAll = ref(true);
</script>

<template>
    <Head title="Матрица" />

    <TrafficLightLayout>
        <template #nav>
            <BreadCrumb
            :to="'matrix'"
            :name="'Матрица'"
            ></BreadCrumb>
        </template>

    <div class="bg-white dark:bg-gray-800 relative overflow-hidden w-full">
        <div class="flex items-center gap-3 p-4 w-full">
            <Input size="sm" class="bg-transparent focus:ring-green-500 focus:border-green-500" v-model="search" type="text"  placeholder="Поиск" required="">
                    <template #prefix>
                        <SearchIcon />
                    </template>
            </Input>
            <Dropdown placement="bottom">
                <template #trigger="{ toggle }">
                <Button class="" size="md" color="light" @click="toggle">
                    <template #prefix>
                        <Filtericon></Filtericon>
                    </template>
                    Фильтры
                    </Button>
                </template>

                <list-group class="w-[300px]">
                    <list-group-item><span class="text-gray-400">Выберите НГДУ</span></list-group-item>
                    <list-group-item><Checkbox class="accent-green-400" v-model="chAll" label="Все" /></list-group-item>
                    <list-group-item v-for="ngdu in data.ngdu_data" :key="ngdu.id">
                        <Checkbox :label="ngdu.NgduName" />
                    </list-group-item>
                </list-group>
                
            </Dropdown>
            <Button class="bg-green-600" size="md" color="green">
                    Действия
                    <template #suffix>
                        <ActionsIcon class="stroke-white"></ActionsIcon>
                    </template>
            </Button>
        </div>
        <div class="overflow-x-auto">
            <Table :data="data.matrix_data"></Table>
        </div>

    </div>

    </TrafficLightLayout>
</template>
