<template>
    <div class="relative inline-block">
      <input
        type="text"
        v-model="formattedDate"
        @focus="toggleCalendar"
        readonly
        class="w-48 p-2 border border-gray-300 rounded shadow-sm"
      />
      <div v-if="isCalendarOpen" class="absolute top-12 left-0 w-64 p-4 bg-white border border-gray-200 rounded shadow-lg">
        <div class="flex items-center justify-between mb-2">
          <button @click="prevMonth" class="p-1 rounded hover:bg-gray-100">&lt;</button>
          <span>{{ currentMonthName }} {{ currentYear }}</span>
          <button @click="nextMonth" class="p-1 rounded hover:bg-gray-100">&gt;</button>
        </div>
        <div class="grid grid-cols-7 gap-1 text-center">
          <div v-for="day in weekdays" :key="day" class="font-medium">{{ day }}</div>
          <div
            v-for="(date, index) in dates"
            :key="index"
            :class="{
              'bg-blue-500 text-white rounded-full': isSelected(date),
              'text-gray-400': !isCurrentMonth(date),
              'cursor-pointer hover:bg-gray-100': isCurrentMonth(date)
            }"
            @click="selectDate(date)"
          >
            {{ date.getDate() }}
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import { ref, computed } from 'vue';
  import { format, getDaysInMonth, startOfMonth, addMonths, subMonths, isSameMonth, isToday } from 'date-fns';

  export default {
    name: 'Datepicker',
    props: {
      modelValue: {
        type: Date,
        default: new Date()
      }
    },
    emits: ['update:modelValue'],
    setup(props, { emit }) {
      const isCalendarOpen = ref(false);
      const currentDate = ref(new Date(props.modelValue));
      const selectedDate = ref(new Date(props.modelValue));

      const toggleCalendar = () => {
        isCalendarOpen.value = !isCalendarOpen.value;
      };

      const prevMonth = () => {
        currentDate.value = subMonths(currentDate.value, 1);
      };

      const nextMonth = () => {
        currentDate.value = addMonths(currentDate.value, 1);
      };

      const selectDate = (date) => {
        selectedDate.value = date;
        emit('update:modelValue', date);
        isCalendarOpen.value = false;
      };

      const formattedDate = computed(() => format(selectedDate.value, 'yyyy-MM-dd'));
      const currentMonthName = computed(() => format(currentDate.value, 'MMMM'));
      const currentYear = computed(() => format(currentDate.value, 'yyyy'));

      const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

      const dates = computed(() => {
        const start = startOfMonth(currentDate.value);
        const daysInMonth = getDaysInMonth(currentDate.value);
        const datesArray = [];

        for (let i = 0; i < daysInMonth; i++) {
          datesArray.push(new Date(currentDate.value.getFullYear(), currentDate.value.getMonth(), i + 1));
        }

        return datesArray;
      });

      const isSelected = (date) => selectedDate.value.toDateString() === date.toDateString();
      const isCurrentMonth = (date) => isSameMonth(date, currentDate.value);

      return {
        isCalendarOpen,
        toggleCalendar,
        prevMonth,
        nextMonth,
        selectDate,
        formattedDate,
        currentMonthName,
        currentYear,
        weekdays,
        dates,
        isSelected,
        isCurrentMonth
      };
    }
  };
  </script>
