<template>
    <div class="w-full h-[calc(100%-50px)] flex flex-col items-center justify-center gap-4">

        <span class="text-xl text-gray-800 dark:text-white font-semibold">Данных нет</span>
        <pre class="text-sm text-gray-400 dark:text-gray-500">
            Это может произойти по нескольким причинам:

            - На данный момент заявок нет
            - Под выбранные вами фильтры не подходит ни одна заявка
            - Ошибка сервера
        </pre>

        <slot />
    </div>
</template>
