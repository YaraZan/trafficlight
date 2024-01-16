<script setup>
import { ref, nextTick } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Input } from 'flowbite-vue';
import EditIcon from '@/Components/Icons/EditIcon.vue';
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue';
import { Spinner } from 'flowbite-vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    role: {
        type: Object
    }
});

const editing = ref(false);

const confirmingRoleDeletion = ref(false);
const passwordInput = ref(null);

const nameInput = ref(null);
const canEditOption = ref(false);
const canViewAllOption = ref(false);

const form = useForm({
    public_id: props.role.public_id,
    name: props.role.name,
    can_edit: props.role.canEdit,
    can_view_all: props.role.canViewAll,
    confirm_password: ''
});

const deleteRole = () => {
    form.delete(route('roles.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            editing.value = false;
            passwordInput.value = null;
            closeModal();
        },
        onError: () => {
            passwordInput.value = null;
        },
    });
};

const updateRole = () => {
    form.patch(route('roles.update'), {
        preserveScroll: true,
        onSuccess: () => {editing.value = false;},
        onError: () => {
        // Handle validation errors here
        },
    });
};

const confirmRoleDeletion = () => {
    confirmingRoleDeletion.value = true;
};

const closeModal = () => {
    confirmingRoleDeletion.value = false;
};
</script>

<template>
    <tr :class="editing ? 'border-l-2 border-l-green-400 dark:border-l-green-400 bg-gray-50 dark:bg-gray-900 dark:bg-opacity-40' : ''" class="border-b border-gray-200 dark:border-gray-700">

        <td v-if="editing" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700 flex flex-col">
            <Input v-model="form.name" ref="nameInput" size="sm" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " type="text"  placeholder="Название" required="">
            </Input>
            <span v-if="form.errors.name" class="text-red-600">{{ form.errors.name }}</span>
        </td>
        <th v-else scope="row" class="font-semibold text-gray-800 dark:text-gray-400 px-6 py-3 text-left">{{ role.name }}</th>

        <td v-if="editing" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
            <select v-model="form.can_edit" ref="canEditOption" class="block p-2 text-sm font-semibold text-gray-800 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-opacity-80 dark:text-gray-300 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600 cursor-pointer">
                <option :value="true">
                    Да
                </option>
                <option :value="false">
                    Нет
                </option>
            </select>
        </td>
        <td v-else class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
            <span v-if="role.canEdit" class="py-1 px-2 bg-green-100 text-green-600 dark:bg-green-500 dark:text-white rounded-3xl">Да</span>
            <span v-else class="py-1 px-2 bg-red-100 text-red-600 dark:bg-red-500 dark:text-white rounded-3xl">Нет</span>
        </td>

        <td v-if="editing" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
            <select v-model="form.can_view_all" ref="canViewAllOption" class="block p-2 text-sm font-semibold text-gray-800 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-opacity-80 dark:text-gray-300 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600 cursor-pointer">
                <option :value="true">
                    Да
                </option>
                <option :value="false">
                    Нет
                </option>
            </select>
        </td>
        <td v-else class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
            <span v-if="role.canViewAll" class="py-1 px-2 bg-green-100 text-green-600 dark:bg-green-500 dark:text-white rounded-3xl">Да</span>
            <span v-else class="py-1 px-2 bg-red-100 text-red-600 dark:bg-red-500 dark:text-white rounded-3xl">Нет</span>
        </td>

        <td v-if="editing" class="flex gap-5 px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
            <button @click="editing = !editing" class="text-gray-600 text-sm font-semibold p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">Отмена</button>
            <button @click.prevent="updateRole" :disabled="form.processing" class="flex gap-2 bg-green-600 px-4 py-2 border border-green-500 rounded-lg text-white text-sm font-semibold hover:bg-opacity-80">
                <Spinner color="green" v-show="form.processing" />
                Сохранить
            </button>
        </td>
        <td v-else class="px-3 py-3 text-left border-l border-gray-200 dark:border-gray-700 flex gap-2">
            <button @click="editing = !editing" class="text-green-600 text-sm font-semibold flex items-center gap-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                <EditIcon />
            </button>
            <button @click.prevent="confirmRoleDeletion" :disabled="form.processing" class="text-red-600 text-sm font-semibold flex items-center gap-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                <DeleteIcon />
            </button>
        </td>
    </tr>

    <Modal :show="confirmingRoleDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-300">
                    Вы точно хотите удалить роль?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-500">
                    После того как вы это сделаете, роль будет удалена навсегда. Все пользователи, причастные к этой роли, получат роль с наименьшим доступом.
                </p>

                <div class="mt-6">
                    <Input v-model="form.confirm_password" ref="passwordInput" size="sm" type="password" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " placeholder="Пароль">
                    </Input>
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        @click="closeModal"
                        class="flex gap-2 bg-transparent px-4 py-2 border border-gray-200 dark:border-gray-700 dark:hover:bg-gray-900 dark:text-gray-300 rounded-lg text-gray-800 text-sm  hover:bg-gray-100"
                    > Отмена </button>

                    <button
                        class="ml-3 flex border border-red-600 bg-red-800 px-4 py-2 rounded-lg text-white text-sm font-normal text-center hover:bg-opacity-80"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteRole"
                    >
                        Удалить
                    </button>
                </div>
            </div>
        </Modal>
</template>
