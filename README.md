![Logo](public/images/readme_logo.png)

# Светофор
Приложение для управления состоянием скважин, который делает процесс мониторинга простым и эффективным. 
Получайте надежную информацию о доступных вам скважинах в реальном времени и принимайте обоснованные решения на основе актуальных данных. 
Приложение разработано с учетом вашего комфорта и простоты использования для более эффективного управления вашими скважинами.


[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/vuejs-%2335495e.svg?style=for-the-badge&logo=vuedotjs&logoColor=%234FC08D)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Vite](https://img.shields.io/badge/vite-%23646CFF.svg?style=for-the-badge&logo=vite&logoColor=white)
![Postgres](https://img.shields.io/badge/postgres-%23316192.svg?style=for-the-badge&logo=postgresql&logoColor=white)

## Функционал

- [x] **Мониторинг:**

  Просмотр всех данных по доступным вам скважинам, в том числе: аварии, опросы,
  часовые архивы и.т.д. Для удобства просотра есть режимы `карточек` и `таблицы`, с возможностью экспорта в Excel

- [x] **Ролевое управление доступом**

  Для различных пользователей существуют разные уровни управления доступом. Например,
  рядовой пользователь может просматривать лишь скважины той НГДУ, к которой относится, в то  время как `модератору` доступны все. Также в зависимости от роли пользователя он может подать заявку на **изменение работы скважины**

- [x] **Фильтрация:**

  Скважины можно фильтровать по названию, НГДУ, а также по цехам, принадлежным к НГДУ.
  Аварии, Часовые архивы, Опросы фильтруются по дате и названию. Параметры и динамограммы
  на детальной странице скважины поддерживают **наложение** для мониторинга изменения состояний за разные промежутки времени

- [x] **AI отчёт**

  Генерация отчётов моделью машинного обучения [<b>Динамограф</b>](https://github.com/YaraZan/dinamograph-api)

- [x] **Персонализация**

  Возможность менять цветовую тему приложения 🌙


## Скриншоты
![App Screenshot](public/images/readme_scht_1.png)

**Страница со всеми доступными скважинами**

- **В верхней части:** Фильтры по НГДУ / связи, пагинация, переключение режима просмотра
- **Центр:** Карточки скважин с отображением основных данных, а также первых трёх основных
параметров слева направо: <code>число качаний</code>, <code>нагрузка макс.</code>, <code>нагрузка мин.</code>
<br>

![App Screenshot](public/images/readme_scht_3.png)

**Детальная страница скважины**

- **В верхней части:** Основные данные скважины, навигация по углубленным данным
- **В правой части:** Динамограмма, графическое представление работы скважины, а конкретно ШГН
- **Внизу:** Таблица с записями динамограмм для отображения, пагинация этих записей
<br>

![App Screenshot](public/images/readme_scht_4.png)

**Вывод отчёта Динамографа**

- **В правой нижней части:** Отчёт, сформированный моделью машинного обучения
[<b>Динамограф</b>](https://github.com/YaraZan/dinamograph-api). Анализ осуществляется над каждой выбранной
динамограммой. Для достижения максимальной эффективности рекоммендуется выбрать несколько записей

## Стек технологий
**Client:** Vue, Vite, TailwindCSS

**Server:** Laravel

**Database:** PostgreSQL

## Производство

Проект нашёл своё применение в компании [ПАО "Татнефть"](https://www.tatneft.ru/)
