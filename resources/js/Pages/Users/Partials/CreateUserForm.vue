<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Input } from 'flowbite-vue';
import { Spinner } from 'flowbite-vue';

const props = defineProps({
    roles: {
        type: Array,
        required: true
    },
    ngdus: {
        type: Array,
        required: true
    }
});

const nameInput = ref(null); 
const emailInput = ref(null);
const passwordInput = ref(null);

const emit = defineEmits(['created', 'cancelled']);

const form = useForm({
    name: '',
    email: '',
    role_id: '',
    ngdu_id: '',
    password: '',
});

const createUser = () => {
    form.post(route('users.store'), {
        onSuccess: () => {
            form.reset();
            emit('created');
        },
    });
};
</script>

<template>
    <tr class="border-l-2 border-l-green-400 bg-gray-50 border-b border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:bg-opacity-40">
        <td class="px-6 py-3 text-left">
            <Input v-model="form.name" ref="nameInput" size="sm" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " type="text"  placeholder="Название">
            </Input>
            <span v-if="form.errors.name" class="text-red-600">{{ form.errors.name }}</span>
        </td>
        <td class="px-6 py-3 text-left border-l border-gray-200">
            <Input v-model="form.password" ref="passwordInput" size="sm" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " type="password"  placeholder="Пароль">
            </Input>
            <span v-if="form.errors.password" class="text-red-600">{{ form.errors.password }}</span>
        </td>
        <td v-if="props.roles" class="px-6 py-3 text-left border-l border-gray-200">
            <select v-model="form.role_id" ref="roleSelect" class="block p-2 text-sm font-semibold text-gray-800 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-opacity-80 dark:text-gray-300 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600 cursor-pointer">
                <option v-for="role in roles" ref="" :key="role.id" :value="role.id">
                    {{ role.name }}
                </option>
            </select>
        </td>
        <td v-else class="px-6 py-3 text-left border-l border-gray-200">
            Ролей нет
        </td>
        <td class="px-6 py-3 text-left border-l border-gray-200">
            <Input v-model="form.email" ref="emailInput" size="sm" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " type="text"  placeholder="Почта">
            </Input>
        </td>
        <td v-if="props.ngdus" class="px-6 py-3 text-left border-l border-gray-200">
            <select v-model="form.ngdu_id" ref="ngduSelect" class="block p-2 text-sm font-semibold text-gray-800 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-opacity-80 dark:text-gray-300 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600 cursor-pointer">
                <option v-for="ngdu in ngdus" :key="ngdu.Id" :value="ngdu.Id">
                    {{ ngdu.NgduName }}
                </option>
            </select>
        </td>
        <td v-else class="px-6 py-3 text-left border-l border-gray-200">
            НГДУ нет
        </td>
        <td class="flex items-center px-4 gap-3 py-3 text-left border-l border-gray-200">
            <button @click="emit('cancelled')" class="text-gray-600 dark:hover:bg-gray-700 text-sm font-semibold p-2 hover:bg-gray-100 rounded-lg">Отмена</button>
            <button @click.prevent="createUser" :disabled="form.processing" class="flex gap-2 bg-green-600 px-4 py-2 border border-green-700 rounded-lg text-white text-sm font-semibold hover:opacity-80">
                <Spinner color="green" v-show="form.processing" />
                Сохранить
            </button>
        </td>
    </tr>
</template>