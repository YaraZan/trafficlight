<template>
    <button @click="showDeclineClaimWindow = !showDeclineClaimWindow" class="group ease-in hover:bg-red-500 dark:hover:bg-red-500 focus:bg-red-500 dark:focus:bg-red-500 p-1 w-full flex items-center justify-center gap-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 shadow rounded-lg outline-none">
        <svg class="stroke-red-500 group-hover:stroke-white dark:group-hover:stroke-white group-focus:stroke-white dark:group-focus:stroke-white" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12.2927 20.0976L16.1951 16M16.1951 16L20.0976 11.9024M16.1951 16L20.0976 20.0976M16.1951 16L12.2927 11.9024M8.19513 23.4146V8.58537C8.19513 8.36985 8.36985 8.19513 8.58537 8.19513H23.4146C23.6302 8.19513 23.8049 8.36985 23.8049 8.58537V23.4146C23.8049 23.6302 23.6302 23.8049 23.4146 23.8049H8.58537C8.36985 23.8049 8.19513 23.6302 8.19513 23.4146Z" stroke-width="1.59071" stroke-linecap="round"/>
        </svg>
        <span class="text-sm font-semibold text-red-500 group-hover:text-white dark:group-hover:text-white group-focus:text-white dark:group-focus:text-white">Отклонить</span>
    </button>

    <Modal :custom-styles="'mt-[250px]'" :show="showDeclineClaimWindow" @close="showDeclineClaimWindow = false">
        <div
        class="
        w-[calc(100vw-20px)]
        md:w-[500px]
        flex flex-col p-5 gap-4 border border-gray-200 dark:border-gray-700 rounded-xl font-montserrat overflow-visible">

        <span class="text-xl text-gray-800 dark:text-white font-semibold">Отклонить данную заявку?</span>
        <div class="w-full flex items-center justify-center gap-4 text-sm text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-900  p-4 rounded-xl">
            <svg class="fill-red-500" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M26.6146 16C26.6146 21.8623 21.8623 26.6146 16 26.6146C10.1377 26.6146 5.38535 21.8623 5.38535 16C5.38535 10.1377 10.1377 5.38535 16 5.38535C21.8623 5.38535 26.6146 10.1377 26.6146 16ZM29.2683 16C29.2683 23.3279 23.3279 29.2683 16 29.2683C8.67211 29.2683 2.73169 23.3279 2.73169 16C2.73169 8.67211 8.67211 2.73169 16 2.73169C23.3279 2.73169 29.2683 8.67211 29.2683 16ZM15.0306 9.54698C14.7195 9.9528 14.4552 10.6524 14.4552 11.7073C14.4552 12.435 14.8696 13.3822 15.496 14.3376C15.7421 14.7129 16.0003 15.059 16.2371 15.3554C16.4632 15.0451 16.7101 14.6847 16.9454 14.2982C17.545 13.3129 17.935 12.3704 17.935 11.7073C17.935 9.80567 16.8217 8.99178 16.1064 8.99178C15.6923 8.99178 15.3252 9.16271 15.0306 9.54698ZM13.1467 8.10268C13.8721 7.15658 14.9241 6.61797 16.1064 6.61797C18.5841 6.61797 20.3088 8.99698 20.3088 11.7073C20.3088 13.0711 19.6026 14.4981 18.9732 15.5323C18.3133 16.6165 17.5887 17.5042 17.3043 17.8401C16.7864 18.4517 15.853 18.4803 15.2997 17.8956C14.9941 17.5726 14.2179 16.7177 13.5108 15.6391C12.8315 14.603 12.0814 13.1622 12.0814 11.7073C12.0814 10.2789 12.4379 9.02724 13.1467 8.10268ZM16.5532 20.8925C16.3262 20.6655 15.9564 20.673 15.7394 20.9067C15.5439 21.1173 15.5378 21.443 15.7271 21.6614C15.9476 21.9158 16.3393 21.9222 16.5674 21.6778C16.7744 21.4561 16.769 21.1083 16.5532 20.8925ZM13.9999 19.2915C15.1339 18.0703 17.0548 18.037 18.2317 19.214C19.3507 20.333 19.3839 22.1393 18.3028 23.2975C17.111 24.5745 15.0758 24.5344 13.9333 23.2161C12.9515 22.0833 12.9787 20.3912 13.9999 19.2915Z" />
            </svg>

            Данное действие невозможно отменить
        </div>

        <button @click="declineClaim" class="group ease-in hover:bg-red-500 dark:hover:bg-red-500 focus:bg-red-500 dark:focus:bg-red-500 p-1 w-full flex items-center justify-center gap-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 shadow rounded-lg outline-none">
            <Spinner v-if="form.processing" class="fill-gray-800 dark:fill-white" />
            <template v-else>
                <svg class="stroke-red-500 group-hover:stroke-white dark:group-hover:stroke-white group-focus:stroke-white dark:group-focus:stroke-white" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.2927 20.0976L16.1951 16M16.1951 16L20.0976 11.9024M16.1951 16L20.0976 20.0976M16.1951 16L12.2927 11.9024M8.19513 23.4146V8.58537C8.19513 8.36985 8.36985 8.19513 8.58537 8.19513H23.4146C23.6302 8.19513 23.8049 8.36985 23.8049 8.58537V23.4146C23.8049 23.6302 23.6302 23.8049 23.4146 23.8049H8.58537C8.36985 23.8049 8.19513 23.6302 8.19513 23.4146Z" stroke-width="1.59071" stroke-linecap="round"/>
                </svg>
                <span class="text-sm font-semibold text-red-500 group-hover:text-white dark:group-hover:text-white group-focus:text-white dark:group-focus:text-white">Я понимаю и хочу отклонить</span>
            </template>
        </button>
    </div>
    </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { Spinner } from 'flowbite-vue';
import { ref } from 'vue';

const showDeclineClaimWindow = ref(false);

const props = defineProps(['claim']);
const emit = defineEmits(['decline', 'error']);

const form = useForm({
    claim_id: props.claim.Id
})

function declineClaim() {
    form.post(route('claims.decline'), {
        onSuccess: () => {
            emit('decline');
        },
        onError: () => {
            emit('error');
        }
    })
}
</script>
