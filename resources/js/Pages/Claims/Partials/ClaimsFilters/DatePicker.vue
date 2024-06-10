<template>
    <div class="relative w-full flex flex-col">
      <div @click="showDatePicker = !showDatePicker"
        :class="{'border-green-400 hover:border-green-400 dark:border-green-400 dark:hover:border-green-400' : showDatePicker}"
        class="w-full px-3 py-2 flex items-center gap-4 justify-between bg-white border-gray-300 shadow dark:bg-gray-900 dark:border-gray-700
        border rounded-xl hover:border-green-400 cursor-pointer select-none whitespace-nowrap">

        <div class="flex items-center gap-2">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path class="fill-gray-400" fill-rule="evenodd" clip-rule="evenodd" d="M8.58656 2C9.26862 2 9.82154 2.55292 9.82154 3.23498V5.70494C9.82154 7.29641 8.53139 8.58656 6.93992 8.58656H4.88162C4.65427 8.58656 4.46996 8.77086 4.46996 8.99822V27.3171C4.46996 27.5444 4.65427 27.7287 4.88162 27.7287H27.3171C27.5444 27.7287 27.7287 27.5444 27.7287 27.3171V8.99822C27.7287 8.77086 27.5444 8.58656 27.3171 8.58656H25.4646C23.8731 8.58656 22.583 7.29641 22.583 5.70494V3.23498C22.583 2.55292 23.1359 2 23.818 2C24.5 2 25.0529 2.55292 25.0529 3.23498V5.70494C25.0529 5.93229 25.2373 6.1166 25.4646 6.1166H27.3171C28.9086 6.1166 30.1987 7.40674 30.1987 8.99822V27.3171C30.1987 28.9085 28.9086 30.1987 27.3171 30.1987H4.88162C3.29014 30.1987 2 28.9085 2 27.3171V8.99822C2 7.40674 3.29014 6.1166 4.88162 6.1166H6.93992C7.16727 6.1166 7.35158 5.93229 7.35158 5.70494V3.23498C7.35158 2.55292 7.9045 2 8.58656 2ZM11.2623 7.35158C11.2623 6.66952 11.8153 6.1166 12.4973 6.1166H19.9072C20.5893 6.1166 21.1422 6.66952 21.1422 7.35158C21.1422 8.03364 20.5893 8.58656 19.9072 8.58656H12.4973C11.8153 8.58656 11.2623 8.03364 11.2623 7.35158ZM7.55741 14.3498C8.23947 14.3498 8.79239 13.7969 8.79239 13.1148C8.79239 12.4328 8.23947 11.8798 7.55741 11.8798C6.87535 11.8798 6.32243 12.4328 6.32243 13.1148C6.32243 13.7969 6.87535 14.3498 7.55741 14.3498ZM14.5556 13.1148C14.5556 13.7969 14.0027 14.3498 13.3206 14.3498C12.6386 14.3498 12.0857 13.7969 12.0857 13.1148C12.0857 12.4328 12.6386 11.8798 13.3206 11.8798C14.0027 11.8798 14.5556 12.4328 14.5556 13.1148ZM19.0839 14.3498C19.7659 14.3498 20.3189 13.7969 20.3189 13.1148C20.3189 12.4328 19.7659 11.8798 19.0839 11.8798C18.4018 11.8798 17.8489 12.4328 17.8489 13.1148C17.8489 13.7969 18.4018 14.3498 19.0839 14.3498ZM26.0821 13.1148C26.0821 13.7969 25.5292 14.3498 24.8471 14.3498C24.1651 14.3498 23.6121 13.7969 23.6121 13.1148C23.6121 12.4328 24.1651 11.8798 24.8471 11.8798C25.5292 11.8798 26.0821 12.4328 26.0821 13.1148ZM7.55741 19.2897C8.23947 19.2897 8.79239 18.7368 8.79239 18.0547C8.79239 17.3727 8.23947 16.8198 7.55741 16.8198C6.87535 16.8198 6.32243 17.3727 6.32243 18.0547C6.32243 18.7368 6.87535 19.2897 7.55741 19.2897ZM14.5556 18.0547C14.5556 18.7368 14.0027 19.2897 13.3206 19.2897C12.6386 19.2897 12.0857 18.7368 12.0857 18.0547C12.0857 17.3727 12.6386 16.8198 13.3206 16.8198C14.0027 16.8198 14.5556 17.3727 14.5556 18.0547ZM19.0839 19.2897C19.7659 19.2897 20.3189 18.7368 20.3189 18.0547C20.3189 17.3727 19.7659 16.8198 19.0839 16.8198C18.4018 16.8198 17.8489 17.3727 17.8489 18.0547C17.8489 18.7368 18.4018 19.2897 19.0839 19.2897ZM26.0821 18.0547C26.0821 18.7368 25.5292 19.2897 24.8471 19.2897C24.1651 19.2897 23.6121 18.7368 23.6121 18.0547C23.6121 17.3727 24.1651 16.8198 24.8471 16.8198C25.5292 16.8198 26.0821 17.3727 26.0821 18.0547ZM7.55741 24.6413C8.23947 24.6413 8.79239 24.0884 8.79239 23.4063C8.79239 22.7242 8.23947 22.1713 7.55741 22.1713C6.87535 22.1713 6.32243 22.7242 6.32243 23.4063C6.32243 24.0884 6.87535 24.6413 7.55741 24.6413ZM14.5556 23.4063C14.5556 24.0884 14.0027 24.6413 13.3206 24.6413C12.6386 24.6413 12.0857 24.0884 12.0857 23.4063C12.0857 22.7242 12.6386 22.1713 13.3206 22.1713C14.0027 22.1713 14.5556 22.7242 14.5556 23.4063ZM19.0839 24.6413C19.7659 24.6413 20.3189 24.0884 20.3189 23.4063C20.3189 22.7242 19.7659 22.1713 19.0839 22.1713C18.4018 22.1713 17.8489 22.7242 17.8489 23.4063C17.8489 24.0884 18.4018 24.6413 19.0839 24.6413Z"/>
            </svg>

            <span v-if="!selectedDates.length" class="text-sm text-gray-800 font-semibold select-none dark:text-white">Выберите</span>
            <span v-else class="text-sm text-gray-800 dark:text-white font-semibold select-none">{{ formattedDates }}</span>
        </div>
        <svg class="fill-none w-6 h-6 stroke-gray-800 dark:stroke-white" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.09961 9.6687L12.0996 15.6687L18.0996 9.6687" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>

      <div v-show="showDatePicker" class="left-[101%] z-[50] w-[300px] absolute bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg">
        <div class="w-full border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
          <button @click="prevMonth" class="p-4 border-r border-gray-200 dark:border-gray-700 rounded hover:bg-gray-50 dark:hover:bg-gray-800">&lt;</button>
          <span class="p-4">{{ currentMonthName }} {{ currentYear }}</span>
          <button @click="nextMonth" class="p-4 border-l border-gray-200 dark:border-gray-700 rounded hover:bg-gray-50 dark:hover:bg-gray-800">&gt;</button>
        </div>
        <div class="p-4 grid grid-cols-7 gap-2 text-center">
          <span v-for="day in weekdays" :key="day" class="font-medium text-[13px]">{{ day }}</span>
          <div v-for="n in leadingEmptyDays" :key="'empty-' + n" class="p-1"></div>
          <div
            v-for="(date, index) in dates"
            :key="index"
            :class="{
              'bg-green-600 dark:bg-green-600 text-white hover:bg-green-600 dark:hover:bg-green-600 border border-green-400 shadow-md': isSelected(date),
              'bg-green-100 dark:bg-green-900 hover:bg-green-100 dark:hover:bg-green-900': isInRange(date) && !isSelected(date),
              'text-gray-400': !isCurrentMonth(date),
            }"
            class="p-1 flex items-center justify-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 rounded-md"
            @click="selectDate(date)"
          >
            <span class="font-semibold text-sm">{{ date.getDate() }}</span>
          </div>
        </div>
      </div>
    </div>
  </template>

<script setup>
import { onMounted, ref, computed } from 'vue';
import { format, getDaysInMonth, startOfMonth, addMonths, subMonths, isSameMonth, isToday, getDay, subDays, addDays, isWithinInterval, isAfter, isBefore } from 'date-fns';
import { ru } from 'date-fns/locale';

const props = defineProps({
  modelValue: {
    type: Date,
    default: new Date()
  }
});

const weekdays = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];

const showDatePicker = ref(false);
const currentDate = ref(new Date(props.modelValue));
const selectedDates = ref([]);

function prevMonth() {
  currentDate.value = subMonths(currentDate.value, 1);
};

function nextMonth() {
  currentDate.value = addMonths(currentDate.value, 1);
};

const formattedDates = computed(() => {
  return selectedDates.value.map(date => format(date, 'yyyy-MM-dd')).join(' - ');
});

const currentMonthName = computed(() => format(currentDate.value, 'MMMM', { locale: ru }));
const currentYear = computed(() => format(currentDate.value, 'yyyy', { locale: ru }));


function selectDate(date) {
    const dateString = date.toDateString(); // Convert the date to a string for comparison
    const existingIndex = selectedDates.value.findIndex(d => d.toDateString() === dateString);

    if (existingIndex !== -1) {
        // If the date is already in the array, remove it
        selectedDates.value.splice(existingIndex, 1);
    } else {
        // If the date is not in the array, add it
        if (selectedDates.value.length === 2) {
            selectedDates.value = [date];
        } else {
            selectedDates.value.push(date);
            if (selectedDates.value.length === 2 && isAfter(selectedDates.value[0], selectedDates.value[1])) {
                selectedDates.value.reverse();
            }
        }
    }
    emit('change', selectedDates.value);
}


const dates = computed(() => {
  const start = startOfMonth(currentDate.value);
  const daysInMonth = getDaysInMonth(currentDate.value);
  const datesArray = [];

  // Add previous month's dates
  const leadingEmptyDays = getDay(start) - 1;
  const previousMonth = subMonths(currentDate.value, 1);
  const daysInPreviousMonth = getDaysInMonth(previousMonth);

  for (let i = leadingEmptyDays - 1; i >= 0; i--) {
    datesArray.push(new Date(previousMonth.getFullYear(), previousMonth.getMonth(), daysInPreviousMonth - i));
  }

  // Add current month's dates
  for (let i = 0; i < daysInMonth; i++) {
    datesArray.push(new Date(currentDate.value.getFullYear(), currentDate.value.getMonth(), i + 1));
  }

  // Add next month's dates
  const trailingEmptyDays = 42 - datesArray.length; // Ensures a full 6 weeks (6 x 7 = 42)
  const nextMonth = addMonths(currentDate.value, 1);

  for (let i = 0; i < trailingEmptyDays; i++) {
    datesArray.push(new Date(nextMonth.getFullYear(), nextMonth.getMonth(), i + 1));
  }

  return datesArray;
});

const isSelected = (date) => selectedDates.value.some(selectedDate => selectedDate.toDateString() === date.toDateString());
const isInRange = (date) => {
  if (selectedDates.value.length !== 2) return false;
  return isWithinInterval(date, { start: selectedDates.value[0], end: selectedDates.value[1] });
};
const isCurrentMonth = (date) => isSameMonth(date, currentDate.value);

const emit = defineEmits(['change']);
</script>
