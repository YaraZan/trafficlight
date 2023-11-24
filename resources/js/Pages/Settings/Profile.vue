<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedWithSubAside from '@/Layouts/AuthorizedWithSubAside.vue';
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
    <Head title="Профиль" />

    <AuthorizedWithSubAside>
        <template #nav>
            <Link :href="route('settings.profile')">
                <BreadCrumb
                :name="'Профиль'"
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

        <template #content>
            <div class="flex w-full p-4 items-center justify-center">

                <div class="flex flex-col items-center mt-32">
                    <UserDefaultIcon />

                    <div class="flex items-center flex-col gap-2">
                        <h2 class="font-semibold text-gray-800 dark:text-gray-200 text-2xl mt-3">{{ profile_data.name }}</h2>

                        <div class="flex items-center gap-2">
                            <span class="px-2 py-1 border border-green-600 rounded-full font-semibold text-green-600 text-xs ">{{ profile_data.role.name }}</span>
                            <span class="font-normal text-gray-400 text-lg">{{ profile_data.email }}</span>                        
                        </div>

                    </div>

                    <Link
                    :href="route('logout')"
                    :method="'post'"
                    as="button"
                    type="submit"
                    class="border border-gray-200 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-opacity-80 dark:bg-gray-700 px-3 py-2 w-18 rounded-lg mt-5 font-medium flex items-center justify-center hover:bg-gray-50"
                    >
                    Выход
                    </Link>

                </div>

            </div>
        </template>
        
    </AuthorizedWithSubAside>
</template>
