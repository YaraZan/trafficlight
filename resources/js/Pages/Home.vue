<script setup>
import { Head, Link } from '@inertiajs/vue3';
import TrafficLightIcon from '@/Components/Icons/TrafficLightIcon.vue';
import LightHouseIcon from '@/Components/Icons/LightHouseIcon.vue';
import Logo from '@/Components/Logo.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Приветствуем!" />

    <div class="min-w-screen min-h-screen bg-white flex items-center flex-col font-montserrat">

        <Logo class="mt-[40px]"></Logo>

        <div class="flex gap-5 mt-[200px]">
            <Link
                :href="route('matrix')"
                ><div class="flex rounded-lg bg-gray-100 p-5 gap-5 hover:opacity-80">
                    <span class="flex items-center justify-center w-9 h-9 bg-gray-200 rounded-lg">
                        <TrafficLightIcon></TrafficLightIcon>
                    </span>
                    <div class="flex flex-col gap-3">
                        <span class="text-gray-800 font-semibold text-base">Светофор</span>
                        <span class="text-gray-400 text-sm max-w-[240px]">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna.</span>
                    </div>
                </div>
            </Link>
            <div class="flex rounded-lg bg-gray-100 p-5 gap-5 hover:opacity-80">
                    <span class="flex items-center justify-center w-9 h-9 bg-gray-200 rounded-lg">
                        <LightHouseIcon></LightHouseIcon>
                    </span>
                    <div class="flex flex-col gap-3">
                        <span class="text-gray-800 font-semibold text-base">Маяк AI</span>
                        <span class="text-gray-400 text-sm max-w-[240px]">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna.</span>
                    </div>
                </div>
        </div>

    </div>

</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
