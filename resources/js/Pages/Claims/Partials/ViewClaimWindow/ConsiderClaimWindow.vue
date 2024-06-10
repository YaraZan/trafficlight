<template>
    <button @click="showConsiderClaimWindow = !showConsiderClaimWindow" class="group ease-in hover:bg-purple-500 dark:hover:bg-purple-500 focus:bg-purple-500 dark:focus:bg-purple-500 p-1 w-full flex items-center justify-center gap-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 shadow rounded-lg outline-none">
        <svg class="stroke-purple-500 group-hover:stroke-white dark:group-hover:stroke-white group-focus:stroke-white dark:group-focus:stroke-white" width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M7.70728 21.1013C7.83507 21.9958 14.5316 25.7325 15.5126 26.2756C15.5938 26.3205 15.6807 26.3415 15.7735 26.3415H21.9756C22.3074 26.3415 22.5643 26.0526 22.523 25.7234C22.3661 24.474 22.0168 21.704 21.911 20.9634M7.70728 21.1013L21.911 20.9634M7.70728 21.1013C7.70728 20.6896 8.42437 19.151 9.14489 17.709M21.911 20.9634C21.911 20.627 21.2217 19.1419 20.5157 17.709M19.0151 14.7579L14.0507 14.8393M19.0151 14.7579C19.0151 14.7579 19.7746 16.2047 20.5157 17.709M19.0151 14.7579L18.729 11.4207M14.0507 14.8393L10.9265 14.8905C10.7268 14.8938 10.5448 15.0043 10.451 15.1806C10.1992 15.6541 9.67112 16.6558 9.14489 17.709M14.0507 14.8393L14.9152 11.4207M9.14489 17.709H20.5157M14.9152 11.4207L15.1865 10.3478C15.2484 10.1029 15.4687 9.9314 15.7212 9.9314H18.095C18.3814 9.9314 18.6202 10.1506 18.6446 10.4359L18.729 11.4207M14.9152 11.4207C14.9152 11.4207 12.1752 10.4278 12.5062 8.44208C12.8372 6.45632 14.9332 5.46344 16.9742 5.46344C19.0151 5.46344 20.7802 6.45632 21.4421 8.44208C22.104 10.4278 18.729 11.4207 18.729 11.4207" stroke-width="1.6548" stroke-linecap="round"/>
        </svg>
        <span class="text-sm font-semibold text-purple-500 group-hover:text-white dark:group-hover:text-white group-focus:text-white dark:group-focus:text-white">Утвердить</span>
    </button>

    <Modal :custom-styles="'mt-[250px]'" :show="showConsiderClaimWindow" @close="showConsiderClaimWindow = false">
        <div
        class="
        w-[calc(100vw-20px)]
        md:w-[500px]
        flex flex-col p-5 gap-4 border border-gray-200 dark:border-gray-700 rounded-xl font-montserrat overflow-visible">

        <span class="text-xl text-gray-800 dark:text-white font-semibold">Утвердить данную заявку?</span>
        <div class="w-full flex items-center justify-center gap-4 text-sm text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-900  p-4 rounded-xl">
            <svg class="fill-red-500" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M26.6146 16C26.6146 21.8623 21.8623 26.6146 16 26.6146C10.1377 26.6146 5.38535 21.8623 5.38535 16C5.38535 10.1377 10.1377 5.38535 16 5.38535C21.8623 5.38535 26.6146 10.1377 26.6146 16ZM29.2683 16C29.2683 23.3279 23.3279 29.2683 16 29.2683C8.67211 29.2683 2.73169 23.3279 2.73169 16C2.73169 8.67211 8.67211 2.73169 16 2.73169C23.3279 2.73169 29.2683 8.67211 29.2683 16ZM15.0306 9.54698C14.7195 9.9528 14.4552 10.6524 14.4552 11.7073C14.4552 12.435 14.8696 13.3822 15.496 14.3376C15.7421 14.7129 16.0003 15.059 16.2371 15.3554C16.4632 15.0451 16.7101 14.6847 16.9454 14.2982C17.545 13.3129 17.935 12.3704 17.935 11.7073C17.935 9.80567 16.8217 8.99178 16.1064 8.99178C15.6923 8.99178 15.3252 9.16271 15.0306 9.54698ZM13.1467 8.10268C13.8721 7.15658 14.9241 6.61797 16.1064 6.61797C18.5841 6.61797 20.3088 8.99698 20.3088 11.7073C20.3088 13.0711 19.6026 14.4981 18.9732 15.5323C18.3133 16.6165 17.5887 17.5042 17.3043 17.8401C16.7864 18.4517 15.853 18.4803 15.2997 17.8956C14.9941 17.5726 14.2179 16.7177 13.5108 15.6391C12.8315 14.603 12.0814 13.1622 12.0814 11.7073C12.0814 10.2789 12.4379 9.02724 13.1467 8.10268ZM16.5532 20.8925C16.3262 20.6655 15.9564 20.673 15.7394 20.9067C15.5439 21.1173 15.5378 21.443 15.7271 21.6614C15.9476 21.9158 16.3393 21.9222 16.5674 21.6778C16.7744 21.4561 16.769 21.1083 16.5532 20.8925ZM13.9999 19.2915C15.1339 18.0703 17.0548 18.037 18.2317 19.214C19.3507 20.333 19.3839 22.1393 18.3028 23.2975C17.111 24.5745 15.0758 24.5344 13.9333 23.2161C12.9515 22.0833 12.9787 20.3912 13.9999 19.2915Z" />
            </svg>

            Данное действие невозможно отменить
        </div>

        <button @click="considerClaim" class="group ease-in hover:bg-purple-500 dark:hover:bg-purple-500 focus:bg-purple-500 dark:focus:bg-purple-500 p-1 w-full flex items-center justify-center gap-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 shadow rounded-lg outline-none">
            <Spinner v-if="form.processing" class="fill-gray-800 dark:fill-white" />
            <template v-else>
                <svg class="stroke-purple-500 group-hover:stroke-white dark:group-hover:stroke-white group-focus:stroke-white dark:group-focus:stroke-white" width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.70728 21.1013C7.83507 21.9958 14.5316 25.7325 15.5126 26.2756C15.5938 26.3205 15.6807 26.3415 15.7735 26.3415H21.9756C22.3074 26.3415 22.5643 26.0526 22.523 25.7234C22.3661 24.474 22.0168 21.704 21.911 20.9634M7.70728 21.1013L21.911 20.9634M7.70728 21.1013C7.70728 20.6896 8.42437 19.151 9.14489 17.709M21.911 20.9634C21.911 20.627 21.2217 19.1419 20.5157 17.709M19.0151 14.7579L14.0507 14.8393M19.0151 14.7579C19.0151 14.7579 19.7746 16.2047 20.5157 17.709M19.0151 14.7579L18.729 11.4207M14.0507 14.8393L10.9265 14.8905C10.7268 14.8938 10.5448 15.0043 10.451 15.1806C10.1992 15.6541 9.67112 16.6558 9.14489 17.709M14.0507 14.8393L14.9152 11.4207M9.14489 17.709H20.5157M14.9152 11.4207L15.1865 10.3478C15.2484 10.1029 15.4687 9.9314 15.7212 9.9314H18.095C18.3814 9.9314 18.6202 10.1506 18.6446 10.4359L18.729 11.4207M14.9152 11.4207C14.9152 11.4207 12.1752 10.4278 12.5062 8.44208C12.8372 6.45632 14.9332 5.46344 16.9742 5.46344C19.0151 5.46344 20.7802 6.45632 21.4421 8.44208C22.104 10.4278 18.729 11.4207 18.729 11.4207" stroke-width="1.6548" stroke-linecap="round"/>
                </svg>
                <span class="text-sm font-semibold text-purple-500 group-hover:text-white dark:group-hover:text-white group-focus:text-white dark:group-focus:text-white">Я понимаю и хочу утвердить</span>
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

const showConsiderClaimWindow = ref(false);

const props = defineProps(['claim']);
const emit = defineEmits(['consider', 'error']);

const form = useForm({
    claim_id: props.claim.Id
})

function considerClaim() {
    form.post(route('claims.consider'), {
        onSuccess: () => {
            emit('consider');
        },
        onError: () => {
            emit('error');
        }
    })
}
</script>
