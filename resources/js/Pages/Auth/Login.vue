<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Input, Spinner } from 'flowbite-vue';
import Logo from '@/Components/Logo.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Вход" />

    <div class="w-screen h-screen flex items-center justify-center font-montserrat bg-white dark:bg-gray-800">
        
        <div class="flex flex-col items-center justify-center gap-6">

            <div class="p-4 flex items-center justify-center border border-gray-200 rounded-lg bg-white dark:border-gray-700 dark:bg-gray-800">
                <Logo />
            </div>

            <div class="flex flex-col gap-2 text-center">
                <h2 class="font-semibold text-[24px] text-gray-800 dark:text-gray-300">Вход</h2>
                <span class="text-[16px] text-gray-300">Войдите в свой аккаунт</span>
            </div>

            <div class="flex flex-col gap-5 pb-40">
                <Input v-model="form.email" label="Почта" size="sm" class="focus:ring-green-500 focus:border-green-500 min-w-[300px] ring-green-600 " type="text"  />
                <Input v-model="form.password" label="Пароль" size="sm" class="focus:ring-green-500 focus:border-green-500 min-w-[300px] ring-green-600 " type="password"  />
                <button @click.prevent="submit" :disabled="form.processing" class="px-4 py-2 bg-green-600 flex items-center justify-center gap-2 font-semibold text-white rounded-lg hover:opacity-80">
                    <Spinner color="green" v-show="form.processing" />
                    Войти
                </button>
            </div>

        </div>

    </div>
</template>
