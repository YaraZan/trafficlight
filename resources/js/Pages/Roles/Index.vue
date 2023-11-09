<script setup>
import { Link } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthorizedLayout from '@/Layouts/AuthorizedLayout.vue';
import NoDataIcon from '@/Components/Icons/NoDataIcon.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { Input } from 'flowbite-vue';
import { ref, computed, watch } from 'vue';
import CreateRoleForm from './Partials/CreateRoleForm.vue';
import EditRoleForm from './Partials/EditRoleForm.vue';

const props = defineProps({
    roles: {
        type: Array,
        required: false
    }
});

const currentPage = ref(1);
const perPage = ref(20);
const searchFilter = ref('');
const creating = ref(false);
const editing = ref(false);

const handleCreated = () => {
    creating.value = false;
}

const handleCancelled = () => {
    creating.value = false;
}

const perPageOptions = [10, 20, 30];

const totalPages = computed(() => Math.ceil(filteredData.value.length / perPage.value));

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return filteredData.value.slice(start, end);
});

const updateData = () => {
  currentPage.value = 1;
};

const setCurrentPage = (page) => {
  currentPage.value = page;
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const filteredData = computed(() => {
  let data = props.roles;

  if (searchFilter.value !== '') {
        data = data.filter(item => item.name.toLowerCase().includes(searchFilter.value.toLowerCase()));
    }

    return data;
});

const visiblePages = computed(() => {
  const totalVisiblePages = 5;
  const pages = [];
  let startPage;

  if (totalPages.value <= totalVisiblePages) {
    startPage = 1;
  } else if (currentPage.value <= 2) {
    startPage = 1;
  } else if (currentPage.value >= totalPages.value - 2) {
    startPage = totalPages.value - totalVisiblePages + 1;
  } else {
    startPage = currentPage.value - Math.floor(totalVisiblePages / 2);
  }

  for (let i = 0; i < totalVisiblePages && startPage <= totalPages.value; i++) {
    pages.push(startPage);
    startPage++;
  }

  return pages;
});

watch(() => [searchFilter.value], () => {
  currentPage.value = 1;
}, { deep: true });

</script>

<template>
    <Head title="Роли" />

    <AuthorizedLayout>
        <template #nav>
            <Link :href="route('roles')">
                <BreadCrumb
                :name="'Роли'"
                ></BreadCrumb>
            </Link>
        </template>

        <div class="bg-white dark:bg-gray-800 relative w-full">  
            
            <div class="flex w-full items-center p-4 gap-3">

                <Input v-model="searchFilter" size="sm" class="focus:ring-green-600 focus:border-green-500 w-56 ring-green-600 " type="text"  placeholder="Название" required="">
                </Input>
                <select v-model="perPage" @change="updateData" class="block p-2 text-sm font-semibold dark:hover:bg-opacity-80 text-gray-800 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 border border-gray-300 rounded-lg focus:ring-green-600 focus:border-green-600 cursor-pointer">
                    <option v-for="option in perPageOptions" :key="option" :value="option">
                        {{ `${option} записей` }}
                    </option>
                </select>
                <ul class="flex items-center -space-x-px h-9 text-sm">
                    <li>
                        <button @click="prevPage" :disabled="currentPage === 1" href="#" class="flex items-center justify-center px-3 h-9 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Previous</span>
                            <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                            </svg>
                        </button>
                    </li>
                    <li v-for="page in visiblePages" :key="page">
                        <button
                            @click="setCurrentPage(page)"
                            :class="{ 'font-bold text-green-600': currentPage === page }"
                            class="flex items-center justify-center px-3 h-9 leading-tight text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        >
                            {{ page }}
                        </button>
                    </li>
                    <li>
                        <button @click="nextPage" :disabled="currentPage === totalPages" href="#" class="flex items-center justify-center px-3 h-9 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Next</span>
                            <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                        </button>
                    </li>
                </ul>
                <button @click="creating = !creating" :class="creating ? 'opacity-80' : ''" :disabled="creating" class="flex gap-2 bg-green-600 px-4 py-2 border border-green-700 rounded-lg text-white text-sm font-semibold hover:opacity-80">
                    Создать
                </button>


            </div>
            
            <div class="w-full h-full overflow-x-auto">
                <table v-if="props.roles.length" class="w-full" striped>
                    <thead>
                        <tr class="border-y bg-gray-50 dark:bg-gray-900 dark:bg-opacity-40 border-gray-200 dark:border-gray-700">
                            <th scope="col" class="px-6 py-3 text-left">
                                <span class="text font-semibold text-gray-800 dark:text-gray-300">Название</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
                                <span class="text font-semibold text-gray-800 dark:text-gray-300">Редактирование</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
                                <span class="text font-semibold text-gray-800 dark:text-gray-300">Все НГДУ</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left border-l border-gray-200 dark:border-gray-700">
                                <span class="text font-semibold text-gray-800 dark:text-gray-300">Действие</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <Transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="opacity-0 translateX-95"
                            enter-to-class="opacity-100 translateX-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="opacity-100 translateX-100"
                            leave-to-class="opacity-0 translateX-95"
                        > 
                            <CreateRoleForm v-show="creating" @cancelled="handleCancelled" @created="handleCreated" />
                        </Transition>
                        
                        <EditRoleForm v-if="paginatedData.length > 0" v-for="role in paginatedData" :key="role.id" :role="role" />
                        <div v-else class="flex flex-col gap-4 items-center justify-center w-full h-full p-20">
                            <NoDataIcon />
                            <span class="text-gray-500 text-lg font-semibold">Данных нет..</span>
                        </div>
                    </tbody>
                </table>  
            </div>
        
        </div>

    </AuthorizedLayout>
</template>
