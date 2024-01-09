<script setup>
import { ref } from 'vue';

const data = [
    {
        name: 'Матрица',
        pageDescr: 'На данной странице вы можете посмотреть список скважин, доступных для обзора и управления.',
        paragraphs: [
            {
                images: [
                    '/images/click-card.gif'
                ],
                header: 'Детальный просмотр',
                text: `Для детального просмотра скважины нажмите на нужную вам карточку. Каждая карточка отображает
                первичную информацию о скважине: <span class="text-green-500 font-medium">Название, цех, номер, НГДУ, ПЛК</span>, а также графическое отображение
                основных параметров (слева направо): <span class="text-green-500 font-medium">Число качаний, Нагрузка максимальная, Нагрузка минимальная</span>.`,
            },
            {
                images: [
                    '/images/table.gif'
                ],
                header: 'Режим таблицы',
                text: `Чтобы просмотреть полный список параметров и их значений для предоставленных скважин вы можете использовать <span class="text-green-500 font-medium"> режим таблицы </span>.
                Для этого нажмите на иконку таблицы в правом верхнем углу над списком скважин. Чтобы вернуться в режим карточек, нажмите на иконку карточек
                (рядом с иконкой таблицы).`,
            },
            {
                images: [
                    '/images/webvisu.gif'
                ],
                header: 'Визуализация',
                text: `Некоторые скважины предоставляют возможность удалённого подключения к контроллеру, слева у таких скважин находится иконка "монитора",
                нажатие на которую перенаправляет вас на веб-визуализацию. Цвета иконок и записей будут <span class="text-green-500 font-semibold"> зелёными </span>,
                если с ними установлена связь, или <span class="text-gray-500 font-semibold">тускло-серыми</span> если связь потеряна.
                Чтобы в режиме таблицы перейти на детальную страницу скважины необходимо дважды нажать на запись
                с необходимой скважиной в таблице (любое место, кроме иконки визуализации).`,
            },
        ]
    },
    {
        name: 'Скважина',
        pageDescr: 'Детальная страница для наиболее полного отображения данных по скважине.Основные характеристики, навигация по углублённым данным и динамограммы.',
        paragraphs: [
            {
                images: [
                    '/images/dinamogramm-2.gif',
                    '/images/dinamogramm-1.gif',
                ],
                header: 'Динамограммы',
                text: `На детальной странице в правой половине экрана вы можете увидеть последнюю снятую <span class="text-green-500 font-semibold">динамограмму</span>. Ниже будет находиться таблица с записями о снятии
                динамограмм с соответствующей датой, наименованием и количеством точек. Чтобы посмотреть динамограмму за другую дату,
                вы можете снять <span class="text-green-500 font-medium">галочку</span> с текущей и выбрать нужную вам. Для наложения разных динамограмм друг на друга последовательно поставьте галочки
                на необходимые динамограммы. Каждой выбранной динамограмме будет соответствовать её <span class="text-green-500 font-medium">цвет</span>.`,
            },
            {
                images: [
                    '/images/graphs-1.gif',
                    '/images/graphs-2.gif',
                ],
                header: 'Графики и диаграммы',
                text: `В разделе "Диаграммы" вы можете строить графики фактических и установочных значений <span class="text-green-500 font-medium">параметров скважины</span>.
                По умолчанию первым выводится число качаний с данными за последнюю неделю, диапазон времени можно поставить любой по желанию.
                Также есть возможность наложения нескольких параметров друг на друга. Каждый выбранный параметр по умолчанию показывает график фактических значений и график установочных значений
                (такого же цвета но более тусклый), но в случае необходимости вы можете скрыть установочный график, нажав на зелёную кнопку справа от записи с параметром в таблице.`,
            },
        ]
    },
];

const currentPage = ref(data[0]);

</script>

<template>
    <div class="flex flex-col w-[1200px] h-[800px] font-montserrat">
        <div class="flex p-2 border-b border-gray-200 dark:border-gray-700">
            <span class="text-gray-800 dark:text-gray-300 text-[18px] font-semibold">Помощь 🛈</span>
        </div>
        <div class="flex relative overflow-y-auto">
            <div class="fixed flex flex-col p-2 gap-[5px] border-r border-gray-200 dark:border-gray-700 w-[200px] h-full">
                <span v-for="(item, index) in data"
                    :key="index"
                    :class="currentPage.name == item.name ? 'font-semibold bg-gray-100 dark:bg-gray-700' : ''" @click="currentPage = item"
                    class="p-2 hover:font-semibold dark:hover:font-semibold
                    text-gray-700 dark:text-gray-400 rounded-lg cursor-pointer
                    text-[14px] font-medium"
                >{{ item.name }}</span>
            </div>
            <!-- Page -->
            <div class="flex flex-col ml-[200px] justify-center items-center w-full">

                <div class="flex flex-col gap-[30px] w-[600px] h-full py-[30px]">

                    <div class="flex flex-col gap-[10px]">
                        <span
                            class="text-gray-800 dark:text-gray-300 text-[24px] font-semibold"
                        >{{ currentPage.name }}</span>
                        <p
                            class="text-gray-800 dark:text-gray-300 text-[16px] font-medium"
                        >{{ currentPage.pageDescr }}</p>
                    </div>

                    <div class="flex flex-col mt-[20px]">

                        <div v-for="(paragraph, index) in currentPage.paragraphs"
                            class="flex flex-col mb-[50px] gap-[5px]"
                            :key="index"
                        >
                            <span
                                class="text-green-500 text-[18px] font-semibold"
                            >{{ paragraph.header }}</span>
                            <p
                                v-html="paragraph.text"
                                class="text-gray-800 dark:text-gray-300 text-[14px] font-normal text-justify leading-normal"
                            ></p>
                            <img v-for="(image, index) in paragraph.images"
                                :key="index"
                                class="rounded-lg border border-gray-200 dark:border-gray-700 mt-[10px] w-full"
                                :src="image"
                                :alt="paragraph.header">
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>