<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Input } from 'flowbite-vue';
import { Spinner } from 'flowbite-vue';

const nameInput = ref(null);
const canEditOption = ref(false);
const canViewAllOption = ref(false);

const form = useForm({
    name: '',
    can_edit: false,
    can_view_all: false,
});

const emit = defineEmits(['created', 'cancelled']);

const createRole = () => {
    form.post(route('roles.store'), {
        onSuccess: () => {
            form.reset();
            emit('created');
        },
    });
};
</script>

<template>
    <tr class="border-l-2 border-l-green-400 bg-gray-50 border-b border-gray-200">
        <td class="px-6 py-3 text-left border-l border-gray-200">
            <Input v-model="form.name" ref="nameInput" size="sm" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " type="text"  placeholder="Название" required="">
            </Input>
        </td>
        <td class="px-6 py-3 text-left border-l border-gray-200">
            <select v-model="form.can_edit" ref="canEditOption" class="block p-2 text-sm font-semibold text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-600 focus:border-green-600 cursor-pointer">
                <option :value="true">
                    Да
                </option>
                <option :value="false">
                    Нет
                </option>
            </select>
        </td>
        <td class="px-6 py-3 text-left border-l border-gray-200">
            <select v-model="form.can_view_all" ref="canViewAllOption" class="block p-2 text-sm font-semibold text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-600 focus:border-green-600 cursor-pointer">
                <option :value="true">
                    Да
                </option>
                <option :value="false">
                    Нет
                </option>
            </select>
        </td>
        <td class="flex items-center gap-3 px-4 py-3 text-left border-l border-gray-200">
            <button @click="emit('cancelled')" class="text-gray-600 text-sm font-semibold p-2 hover:bg-gray-100 rounded-lg">Отмена</button>
            <button @click.prevent="createRole" :disabled="form.processing" class="flex gap-2 bg-green-600 px-4 py-2 border border-green-700 rounded-lg text-white text-sm font-semibold hover:opacity-80">
                <Spinner color="green" v-show="form.processing" />
                Сохранить
            </button>
        </td>
    </tr>
</template>