<template>

<span @click="showMoveWellWindow = !showMoveWellWindow" class="text-[13px] text-gray-400 dark:text-gray-500 font-semibold cursor-pointer hover:text-green-500 dark:hover:text-green-500">
    Оборудование было перемещено?
</span>

<teleport to="body">
    <Modal :show="showMoveWellWindow" @close="closeModal">
            <div class="select-none flex flex-col p-5 w-[400px] items-center gap-5">

                <span class="text-[18px] text-gray-800 dark:text-white font-semibold">Перемещение оборудования</span>

                <p class="p-4 bg-gray-100 dark:bg-gray-900 rounded-md text-[14px] text-normal text-gray-400">
                    * Примечание: Отправленные вами данные будут сформированы в заявку, и, по возможности
                    рассмотрены оператором.
                </p>

                <div class="w-full flex flex-col gap-2">
                    <span class="text-[13px] text-gray-800 dark:text-white font-semibold">Идентификатор АРМИТС</span>
                    <Input v-model="form.well_id_conn"
                        class="w-full focus:ring-green-600 focus:border-green-500 ring-green-600 h-9" type="number" placeholder="Значение">
                    </Input>
                </div>

                <div class="w-full flex flex-col gap-2">
                    <span class="text-[13px] text-gray-800 dark:text-white font-semibold">Вес колонны штанг (Опционально)</span>
                    <Input v-model="form.roadheight"
                        class="w-full focus:ring-green-600 focus:border-green-500 ring-green-600 h-9" type="number" placeholder="Значение">
                    </Input>
                </div>

                <div class="w-full flex flex-col gap-2">
                    <span class="text-[13px] text-gray-800 dark:text-white font-semibold">Комментарий (Опционально)</span>
                    <textarea v-model="form.comment"
                        class="w-full focus:ring-green-600 focus:border-green-500 ring-green-600 h-24 rounded-lg
                        border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 max-h-24"
                        type="number"
                        placeholder="Текст">
                    </textarea>
                </div>


                <button
                    @click="creteNewClaim"
                    :disabled="form.processing"
                    class="w-full flex justify-center items-center h-[32px] gap-2 bg-green-600 px-4 py-2 border border-green-500 rounded-lg hover:bg-opacity-80">
                    <Spinner v-if="form.processing"/>
                    <span v-else class="text-white text-sm font-semibold">Отправить</span>
                </button>

            </div>
        </Modal>
</teleport>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { Input } from 'flowbite-vue';
import { onMounted } from 'vue';
import axios from 'axios';

onMounted(()=> {
    wells.value = fetchAllWells()
})

const fetchAllWells = async () => {
    return await axios.get('/api/well/all')
        .then((res) => {
            return res.data;
        })
}

const props = defineProps({
    well: {
        type: Object,
        required: true,
    }
});

const form = useForm({
    well_uuid: props.well.public_id,
    well_id_conn: '',
    roadheight: 2000,
    comment: '',
});

const creteNewClaim = () => {
    form.post(route('well.move'), {
        onSuccess: () => {
            form.reset();
            showMoveWellWindow.value = false
        },
    });
};

const wells = ref([]);
const showMoveWellWindow = ref(false);

const closeModal = () => {
    showMoveWellWindow.value = false;
};
</script>
