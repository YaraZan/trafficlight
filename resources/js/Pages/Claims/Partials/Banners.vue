<template>
    <Banner :show="model === 'claims:no-new-claims'" text="Новых заявок нет" type="warn"/>
    <Banner :show="model === 'claims:claim-created'" text="Заявка успешно создана!" type="success"/>
    <Banner :show="model === 'claims:claim-not-created'" text="Ошибка при создании заявки" type="danger"/>
</template>

<script setup>
import Banner from "@/Components/Banners/Banner.vue";
import { watch } from 'vue';

const model = defineModel();

watch(model, (newValue)=> {
    model.value = newValue;

    setTimeout(() => {
        model.value = '';
    }, 7000);
})
</script>
