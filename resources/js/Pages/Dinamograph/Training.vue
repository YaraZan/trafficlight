<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import SubAsideLink from '@/Components/SubAsideLink.vue';
import UserDefaultIcon from '@/Components/Icons/UserDefaultIcon.vue';


const props = defineProps({
    profile_data: {
        type: Object
    },
});

</script>

<template>
    <Head title="Динамограф / Тренировка" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('settings.data')">
                <BreadCrumb
                    :name="'Тренировка'"
                ></BreadCrumb>
            </Link>
        </template>

        <template #subAside>
            <div class="w-full h-full flex flex-col">
                <div class="flex items-center text-gray-800 h-[51px] font-semibold dark:text-gray-300 text-sm px-4 border-b border-gray-200 dark:border-gray-700">Настройки</div>
                <div class="flex flex-col p-2 gap-1">
                    <Link :href="route('settings.profile')">
                        <SubAsideLink
                            :text="'Профиль'"
                            :active="$page.component.includes('Settings/Profile')"
                        />
                    </link>
                    <Link :href="route('settings.data')">
                        <SubAsideLink
                            :text="'Данные'"
                            :active="$page.component.includes('Settings/Data')"
                        />
                    </link>
                </div>
            </div>
        </template>

        <div class="flex w-full p-4 items-center justify-center">

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
