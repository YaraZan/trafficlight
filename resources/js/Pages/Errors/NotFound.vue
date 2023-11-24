<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import NotFound from '@/Components/Errors/NotFound.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Страница не найдена" />

    <GuestLayout> 

        <div class="flex flex-col items-center gap-2 mt-60">
            <img src="/images/404.png" alt="">
            <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-300">Страница не найдена</h3>
            <span class="text-gray-400 text-sm max-w-[300px] text-center">Запрашиваемый адрес не соответствует ни одной из страниц</span>
            <Link :href="route('home')">
                <span class="text-sm text-green-500 hover:text-green-600 mt-10">На главную</span>
            </Link>
        </div>

    </GuestLayout>
</template>


