<template>
    <div>
      <canvas ref="chartCanvas"></canvas>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue';
  import {
    Chart as ChartJS,
    LineController,
    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    LinearScale,
    CategoryScale,
  } from 'chart.js';

  ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, LinearScale, CategoryScale, LineController);

  const data = [] // main array

  const sortedData = data.sort((a, b) => a.P - b.P);

  const chartData = {
    labels: sortedData.map(point => `Point ${point.P}`),
    datasets: [
      {
        label: 'Line Dataset',
        data: sortedData.map(point => ({ x: point.X, y: point.Y })),
        borderColor: 'rgba(75, 192, 192, 1)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        fill: false,
      }
    ]
  };

  const chartOptions = {
    responsive: true,
    scales: {
      x: {
        type: 'linear',
        position: 'bottom'
      },
      y: {
        beginAtZero: true
      }
    }
  };

  const chartCanvas = ref(null);

  onMounted(() => {
    new ChartJS(chartCanvas.value, {
      type: 'line',
      data: chartData,
      options: chartOptions
    });
  });
  </script>
