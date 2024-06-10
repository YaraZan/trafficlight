<script setup>
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import HourArchIcon from '@/Components/Icons/HourArchIcon.vue';
import AskStatsIcon from '@/Components/Icons/AskStatsIcon.vue';
import AlarmIcon from '@/Components/Icons/AlarmIcon.vue';
import DiagramsIcon from '@/Components/Icons/DiagramsIcon.vue';
import {Link, Head, usePage} from '@inertiajs/vue3';
import {ref, onMounted, computed} from 'vue';
import axios from 'axios';
import DnmChart from './Partials/DnmChart.vue';
import Dinamogram from '@/Components/Icons/Dinamogram.vue';
import DinamographLogo from "@/Components/Icons/DinamographLogo.vue";
import {Spinner} from "flowbite-vue";
import ClearIcon from "@/Components/Icons/ClearIcon.vue";
import DetailParams from "@/Pages/Matrix/Partials/DetailParams.vue";
import DetailDinamograms from "@/Pages/Matrix/Partials/DetailDinamograms.vue";
import DetailUserClaims from "@/Pages/Matrix/Partials/DetailUserClaims.vue";
import DetailWellClaims from "@/Pages/Matrix/Partials/DetailWellClaims.vue";
import DetailClaimsUntracked from "@/Pages/Matrix/Partials/DetailClaimsUntracked.vue";
import DetailMoveWell from "@/Pages/Matrix/Partials/DetailMoveWell.vue";
import DetailMoveWellUser from "@/Pages/Matrix/Partials/DetailMoveWellUser.vue";
import DetailNavigationTabMenu from './Partials/DetailNavigationTabMenu.vue';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    }
});

</script>

<template>
    <Head :title="item.Name"/>

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('matrix')">
                <BreadCrumb
                    :name="'Матрица'"
                ></BreadCrumb>
            </Link>
            <Link :href="route('matrix.detail', item.public_id)">
                <BreadCrumb
                    :name="item.Name"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="w-full flex flex-col items-center justify-center">

            <div class="h-20 bg-green-400 w-2/3 mt-10"></div>
        </div>
    </AuthorizedLayout>
</template>
