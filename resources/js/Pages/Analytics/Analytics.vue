<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Аналитика" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('analytics')">
                <BreadCrumb
                :name="'Аналитика'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full h-screen flex justify-center">


            <div class="flex flex-col items-center mt-52">
                <div class="w-56 h-56 rounded-lg">
                    <img class="rounded-lg" src="/images/well.png" alt="">
                </div>      
                <h3 class="font-semibold text-gray-800 text-lg mt-5 dark:text-gray-300">Ой, здесь пусто!</h3>
                <span class="text-gray-400 text-sm mt-2">Но скоро что-то будет</span>
            </div>

            

        </div>
        
    </AuthorizedLayout>
</template>
