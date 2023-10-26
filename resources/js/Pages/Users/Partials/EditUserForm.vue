<script setup>
import { ref, nextTick, onMounted } from 'vue';
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
    password: '',
    confirm_password: ''
});

const deleteUser = () => {
    form.delete(route('users.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            editing.value = false; 
            closeModal();
        },
        onError: () => {
        // Handle validation errors here
        },
    });
};

const updateUser = () => {
    form.patch(route('users.update'), {
        preserveScroll: true,
        onSuccess: () => {
            editing.value = false;
            closeModal();
        },
        onError: () => {
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
    <tr :class="editing ? 'bg-gray-50' : ''" class="border-b border-gray-200">

        <!-- ФИО -->
        <th scope="row" v-if="editing" class="px-6 py-3 text-left flex flex-col">
            <Input v-model="form.name" ref="nameInput" size="sm" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " type="text"  placeholder="ФИО" />
            <span v-if="form.errors.name" class="text-red-600">{{ form.errors.name }}</span>
        </th>
        <th v-else scope="row" class="font-semibold text-gray-800 px-6 py-3 text-left">{{ user.name }}</th>

        <!-- Пароль -->
        <td v-if="editing" class="px-6 py-3 text-left border-l border-gray-200">
            <Input v-model="form.password" ref="passwordInput" size="sm" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " type="password"  placeholder="Пароль" />
            <span v-if="form.errors.password" class="text-red-600">{{ form.errors.password }}</span>
        </td>
        <td v-else class="px-6 py-3 text-left border-l border-gray-200">
            <Input disabled v-model="hidePassPlaceholder" size="sm" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " type="password"  placeholder="Пароль" />
        </td>

        <!-- Роль -->
        <td v-if="editing" class="px-6 py-3 text-left border-l border-gray-200">
            <select v-model="form.role_id" ref="roleSelect" class="block p-2 text-sm font-semibold text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-600 focus:border-green-600 cursor-pointer">
                <option v-for="role in roles" :key="role.id" :value="role.id">
                    {{ role.name }}
                </option>
            </select>
        </td>
        <td v-else class="px-6 py-3 text-left border-l border-gray-200">
            <span class="py-1 px-2 bg-blue-100 text-blue-800 font-semibold rounded-3xl">{{ user.roleName }}</span>
        </td>

        <!-- Роль -->
        <td v-if="editing" class="px-6 py-3 text-left border-l border-gray-200 flex flex-col">
            <Input v-model="form.email" ref="emailInput" size="sm" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " type="text"  placeholder="ФИО" />
            <span v-if="form.errors.email" class="text-red-600">{{ form.errors.email }}</span>
        </td>
        <td v-else class="font-semibold text-gray-800 px-6 py-3 text-left border-l border-gray-200">
            {{ user.email }}
        </td>

        <!-- НГДУ -->
        <td v-if="editing" class="px-6 py-3 text-left border-l border-gray-200">
            <select v-model="form.ngdu_id" ref="ngduSelect" class="block p-2 text-sm font-semibold text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-600 focus:border-green-600 cursor-pointer">
                <option v-for="ngdu in ngdus" :key="ngdu.Id" :value="ngdu.Id">
                    {{ ngdu.NgduName }}
                </option>
            </select>
        </td>
        <td v-else class="px-6 py-3 text-left border-l border-gray-200">
            <span class="py-1 px-2 bg-orange-100 text-orange-800 font-semibold rounded-3xl">{{ user.ngduName }}</span>
        </td>

        <!-- Действия -->
        <td v-if="editing" class="flex gap-5 px-6 py-3 text-left border-l border-gray-200">
            <button @click="editing = !editing" class="text-gray-600 text-sm font-semibold p-2 hover:bg-gray-100 rounded-lg">Отмена</button>
            <button @click.prevent="confirmUserEditing" :disabled="form.processing" class="flex gap-2 bg-green-600 px-4 py-2 border border-green-700 rounded-lg text-white text-sm font-semibold hover:opacity-80">
                <Spinner color="green" v-show="form.processing" />
                Сохранить
            </button>
        </td>
        <td v-else class="px-3 py-3 text-left border-l border-gray-200 flex gap-5">
            <button @click="editing = !editing" class="text-green-600 text-sm font-semibold flex items-center gap-2 p-2 hover:bg-gray-100 rounded-lg">
                <EditIcon />
                Изменить
            </button>
            <button @click.prevent="confirmUserDeletion" :disabled="form.processing" class="text-red-600 text-sm font-semibold flex items-center gap-2 p-2 hover:bg-gray-100 rounded-lg">
                <DeleteIcon />
                Удалить
            </button>
        </td>


    </tr>

    <Modal :show="confirmingUserEditing" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Подтвердите действие
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    После того как вы это сделаете, данные пользователя будут обновлены.
                </p>

                <div class="mt-6">
                    <Input v-model="form.confirm_password" ref="passwordInput" size="sm" type="password" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " placeholder="Пароль">
                    </Input>
                </div>

                <div class="mt-6 flex justify-end">
                    <button 
                        @click="closeModal"
                        class="flex gap-2 bg-transparent px-4 py-2 border border-gray-200 rounded-lg text-gray-800 text-sm font-semibold hover:bg-gray-100"
                    > Отмена </button>

                    <button
                        class="ml-3 flex bg-green-600 px-4 py-2 rounded-lg text-white text-sm font-semibold hover:opacity-80"
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
                <h2 class="text-lg font-medium text-gray-900">
                    Вы точно хотите удалить пользователя?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    После того как вы это сделаете, пользователь и его данные будут удалены навсегда.
                </p>

                <div class="mt-6">
                    <Input v-model="form.confirm_password" ref="passwordInput" size="sm" type="password" class="focus:ring-green-500 focus:border-green-500 w-1/2 ring-green-600 " placeholder="Пароль">
                    </Input>
                </div>

                <div class="mt-6 flex justify-end">
                    <button 
                        @click="closeModal"
                        class="flex gap-2 bg-transparent px-4 py-2 border border-gray-200 rounded-lg text-gray-800 text-sm font-semibold hover:bg-gray-100"
                    > Отмена </button>

                    <button
                        class="ml-3 flex bg-red-600 px-4 py-2 rounded-lg text-white text-sm font-semibold hover:opacity-80"
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