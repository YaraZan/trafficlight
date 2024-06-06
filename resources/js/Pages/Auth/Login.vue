<template>
    <Head title="Вход" />

    <GuestLayout>

        <div class="absolute top-48 w-80 flex flex-col items-center justify-center gap-[100px]">

            <Logo class="w-[32px] h-[32px]" />

            <div class="w-full flex flex-col gap-10 items-center justify-center">
                <h2 class="font-bold text-[26px] text-gray-800 dark:text-gray-300">Добро пожаловать</h2>
                <div class="w-full flex flex-col gap-5">
                    <EmailInput v-model="form.email" />
                    <PasswordInput v-model="form.password" />
                    <Button :processing="form.processing" @click.prevent="submit" />
                    <span v-if="form.errors.email || form.errors.password" class="font-normal text-red-500">Пароль или почта введены неверно!</span>
                </div>
            </div>

        </div>

    </GuestLayout>


</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Logo from '@/Components/Logo.vue';
import EmailInput from './Partials/EmailInput.vue';
import Button from './Partials/Button.vue';
import PasswordInput from './Partials/PasswordInput.vue';

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
