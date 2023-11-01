<template>
  <div class="w-[60%]">
    <canvas class="w-full max-h-[440px]" ref="dinamogram"></canvas>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import Chart from 'chart.js/auto';

const props = defineProps({
  data: {
    type: Array,
  },
});

const dinamogram = ref(null);
const chartInstance = ref(null);

onMounted(() => {
  const rawData = props.data;
  drawChart(rawData);
});

watch(() => props.data, (newData) => {
    drawChart(newData);
}, { deep: true });


const drawChart = (data) => {
  if (!dinamogram.value) {
    return;
  }

  const ctx = dinamogram.value.getContext('2d');

  if (!ctx) {
    console.error("Canvas context is not available.");
    return;
  }

  const points = data.map(d => ({ x: parseFloat(d.X), y: parseFloat(d.Y) })).filter(d => !isNaN(d.x) && !isNaN(d.y));

  const chartData = {
    datasets: [{
      data: points,
      label: 'Dinamogram',
      showLine: false,
      borderColor: 'green',
      backgroundColor: 'green',
      pointRadius: 2,
      pointBackgroundColor: 'green',
      pointBorderColor: 'green',
    }],
  };

  const chartOptions = {
    scales: {
      x: {
        type: 'linear',
        position: 'bottom',
        title: {
          display: true,
          text: 'Длина, м',
        },
      },
      y: {
        type: 'linear',
        position: 'left',
        title: {
          display: true,
          text: 'Нагрузка, кг',
        },
      },
    },
    plugins: {
      legend: {
        display: false,
      },
      tooltip: {
        callbacks: {
          label: (context) => {
            const labelX = context.parsed.x;
            const labelY = context.parsed.y;
            return `Нагрузка: ${labelY}, Длина: ${labelX}`;
          },
        },
      },
    },
  };

  chartInstance.value = new Chart(ctx, {
    type: 'scatter',
    data: chartData,
    options: chartOptions,
  });
};
</script>
