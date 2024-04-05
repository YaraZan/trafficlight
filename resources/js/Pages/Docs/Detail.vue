<script setup>
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Документация: Страница скважины" />

    <AuthorizedLayout>

        <div class="w-full flex gap-10 items-center justify-center pt-24">

            <div class="fixed top-40 left-40 flex flex-col gap-2 items-end">
                    <Link :href="route('docs.matrix')" >
                        <span class="text-gray-400 dark:text-gray-600 text-sm font-medium" :class="{ 'text-green-500' : $page.component.includes('Docs/Matrix') }">
                            Матрица
                        </span>
                    </Link>
                    <Link :href="route('docs.detail')" >
                        <span class="text-gray-400 dark:text-gray-600 text-sm font-medium" :class="{ 'text-green-500' : $page.component.includes('Docs/Detail') }">
                            Страница скважины
                        </span>
                    </Link>
                </div>

            <div class="relative flex flex-col w-3/5">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam laborum qui sunt dignissimos tempora quos vitae quae nemo libero, quaerat, voluptatibus doloribus? Laudantium quia reprehenderit tenetur! Explicabo, eius. Minima, veniam.</p>
            </div>

        </div>

    </AuthorizedLayout>
</template>
