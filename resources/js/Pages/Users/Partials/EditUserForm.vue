<script setup>
import {ref, nextTick, onMounted, watch} from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Input } from 'flowbite-vue';
import EditIcon from '@/Components/Icons/EditIcon.vue';
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue';
import { Spinner } from 'flowbite-vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    user: {
        type: Object
    },
    roles: {
        type: Array,
        required: true
    },
    ngdus: {
        type: Array,
        required: true
    }
});

const hidePassPlaceholder = ref('fdsfdsfdsfdsfdsf')

const editing = ref(false);

const confirmingUserDeletion = ref(false);
const confirmingUserEditing = ref(false);

const nameInput = ref(null);
const emailInput = ref(null);
const passwordInput = ref(null);
const roleSelect = ref(null);
const ngduSelect = ref(null);

const form = useForm({
    public_id: props.user.public_id,
    name: props.user.name,
    email: props.user.email,
    role_id: props.user.role_id,
    ngdu_id: props.user.ngdu_id,
    password: null,
    confirm_password: null
});

const deleteUser = () => {
    form.delete(route('users.destroy'), {
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

const updateUser = () => {
    console.log(form.data());

    form.patch(route('users.update'), {
        preserveScroll: true,
        onSuccess: () => {
            editing.value = false;
            passwordInput.value = null;
            closeModal();
        },
        onError: () => {
            passwordInput.value = '';
        },
    });
};

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const confirmUserEditing = () => {
    confirmingUserEditing.value = true;
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    confirmingUserEditing.value = false;
};
</script>

<template>
    <tr :class="editing ? 'border-l-2 border-l-green-400 dark:border-l-green-400 bg-gray-50 dark:bg-gray-900 dark:bg-opacity-40' : ''" class="border-b border-gray-200 dark:border-gray-700">

        <!-- ФИО -->
        <th scope="row" v-if="editing" class="px-6 py-3 text-left flex flex-col">
            <Input v-model="form.name" ref="nameInput" size="sm" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " type="text"  placeholder="ФИО" />
            <span v-if="form.errors.name" class="text-red-600">{{ form.errors.name }}</span>
        </th>
        <th v-else scope="row" class="text-sm font-semibold text-gray-800 dark:text-white px-6 py-3 text-left">{{ user.name }}</th>

        <!-- Пароль -->
        <td v-if="editing" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
            <Input v-model="form.password" ref="passwordInput" size="sm" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " type="password"  placeholder="Пароль" />
            <span v-if="form.errors.password" class="text-red-600">{{ form.errors.password }}</span>
        </td>
        <td v-else class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
            <Input disabled v-model="hidePassPlaceholder" size="sm" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " type="password"  placeholder="Пароль" />
        </td>

        <!-- Роль -->
        <td v-if="editing" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
            <select v-model="form.role_id" ref="roleSelect" class="block p-2 text-sm font-semibold text-gray-800 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-opacity-80 dark:text-gray-300 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600 cursor-pointer">
                <option v-for="role in roles" :key="role.id" :value="role.id">
                    {{ role.name }}
                </option>
            </select>
        </td>
        <td v-else class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
            <span class="text-sm py-1 px-2 bg-blue-200 text-blue-800 font-semibold rounded-3xl">{{ user.roleName }}</span>
        </td>

        <!-- Роль -->
        <td v-if="editing" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700 flex flex-col">
            <Input v-model="form.email" ref="emailInput" size="sm" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " type="text"  placeholder="ФИО" />
            <span v-if="form.errors.email" class="text-red-600">{{ form.errors.email }}</span>
        </td>
        <td v-else class="text-sm font-semibold text-gray-800 dark:text-white px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
            {{ user.email }}
        </td>

        <!-- НГДУ -->
        <td v-if="editing" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
            <select v-model="form.ngdu_id" ref="ngduSelect" class="block p-2 text-sm font-semibold text-gray-800 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-opacity-80 dark:text-gray-300 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600 cursor-pointer">
                <option v-for="ngdu in ngdus" :key="ngdu.Id" :value="ngdu.Id">
                    {{ ngdu.NgduName }}
                </option>
            </select>
        </td>
        <td v-else class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
            <span class="text-sm py-1 px-2 bg-orange-200 text-orange-800  font-semibold rounded-3xl">{{ user.ngduName }}</span>
        </td>

        <!-- Действия -->
        <td v-if="editing" class="flex gap-5 px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
            <button @click="editing = !editing" class="text-gray-600 dark:hover:bg-gray-700 text-sm font-semibold p-2 hover:bg-gray-100 rounded-lg">Отмена</button>
            <button @click.prevent="confirmUserEditing" :disabled="form.processing" class="flex gap-2 bg-green-600 px-4 py-2 border border-green-500 rounded-lg text-white text-sm font-semibold hover:bg-opacity-80">
                <Spinner color="green" v-show="form.processing" />
                Сохранить
            </button>
        </td>
        <td v-else class="px-3 py-3 text-left border-l border-gray-200 dark:border-gray-700 flex gap-2">
            <button @click="editing = !editing" class="text-green-600 text-sm font-semibold flex items-center gap-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                <EditIcon />
            </button>
            <button @click.prevent="confirmUserDeletion" :disabled="form.processing" class="text-red-600 text-sm font-semibold flex items-center gap-2 p-2 dark:hover:bg-gray-700 hover:bg-gray-100 rounded-lg">
                <DeleteIcon />
            </button>
        </td>


    </tr>

    <Modal :show="confirmingUserEditing" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-800 dark:text-gray-300">
                    Подтвердите действие
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    После того как вы это сделаете, данные пользователя будут обновлены.
                </p>

                <div class="mt-6">
                    <Input v-model="form.confirm_password" ref="passwordInput" size="sm" type="password" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " placeholder="Пароль">
                    </Input>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button
                        @click="closeModal"
                        class="flex gap-2 bg-transparent px-4 py-2 border border-gray-200 dark:border-gray-700 dark:hover:bg-gray-900 dark:text-gray-300 rounded-lg text-gray-800 text-sm  hover:bg-gray-100"
                    > Отмена </button>

                    <button
                        class="flex gap-2 bg-green-600 px-4 py-2 border border-green-500 rounded-lg text-white text-sm font-semibold hover:bg-opacity-80"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="updateUser"
                    >
                        Обновить
                    </button>
                </div>
            </div>
        </Modal>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-300">
                    Вы точно хотите удалить пользователя?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-500">
                    После того как вы это сделаете, пользователь и его данные будут удалены навсегда.
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
                        @click="deleteUser"
                    >
                        Удалить
                    </button>
                </div>
            </div>
        </Modal>
</template>
