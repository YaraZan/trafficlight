<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const open = ref(false);

const preventClose = (e) => {
    e.stopPropagation();
};
</script>

<template>
    <div class="flex flex-col items-center w-full">

        <div class="flex items-center w-full">

            <div class="flex items-center gap-2">
                <slot name="ignore" />
            </div>

            <div class="ml-auto h-full cursor-pointer" @click="open = !open">
                <slot name="trigger" />
            </div>
        </div>

        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-show="open"
                class="flex items-center w-full"
                style="display: none"
                @click="preventClose" 
            ><!-- open = false -->
                <div class="py-2 px-3">
                    <slot name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>
