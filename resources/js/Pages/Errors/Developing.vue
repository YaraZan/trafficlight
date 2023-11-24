<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Developing from '@/Components/Errors/Developing.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="В разработке..." />

    <GuestLayout>

        <div class="bg-white dark:bg-gray-800 w-screen h-screen overflow-hidden flex justify-center">
            <div class="flex flex-col items-center gap-2 mt-60">
                <img src="/images/developing.png" alt="">
                <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-300">Страница в разработке</h3>
                <span class="text-gray-400 text-sm max-w-[300px] text-center">Скоро здесь будет что-то интересное!</span>
                <Link :href="route('home')">
                    <span class="text-sm text-green-500 hover:text-green-600">На главную</span>
                </Link>
            </div>
        </div>

    </GuestLayout>
</template>
