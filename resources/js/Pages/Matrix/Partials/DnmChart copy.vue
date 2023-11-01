<template>
  <div class="w-[60%] flex items-start">
    <svg ref="dinamogram" class="min-h-full w-full"></svg>
    <div id="tooltip" class="flex-col absolute hidden p-2 bg-gray-900 text-white border border-gray-200 rounded-lg gap-1"></div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import * as d3 from 'd3';

const dinamogram = ref(null);

const props = defineProps({
  data: {
    type: Array,
  },
});

onMounted(() => {
  const rawData = props.data;
  drawChart(rawData);
});

watch(() => props.data, (newData) => {
  drawChart(newData);
}, { deep: true });

const drawChart = (data) => {
  data = data.map(d => {
    return {
      ...d,
      X: parseFloat(d.X),
      Y: parseFloat(d.Y),
    };
  });

  if (data.length === 0) {
    return;
  }

  // Sort the data based on a meaningful attribute, for example, a timestamp or another identifier
  data.sort((a, b) => a.Timestamp - b.Timestamp); // Adjust the property to sort by

  const margin = { top: 10, right: 30, bottom: 30, left: 60 };
  const width = 900 - margin.left - margin.right;
  const height = 400 - margin.top - margin.bottom;

  d3.select(dinamogram.value).selectAll('*').remove();

  const svg = d3.select(dinamogram.value)
    .append('g')
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .attr("transform", `translate(${margin.left}, ${margin.top})`);

  const xScale = d3.scaleLinear()
    .domain([0, d3.max(data, (d) => d.X)])
    .range([0, width]);
  svg.append("g")
    .attr("transform", `translate(0, ${height})`)
    .call(d3.axisBottom(xScale));

  const yScale = d3.scaleLinear()
    .domain([0, d3.max(data, (d) => d.Y)])
    .range([height, 0]);
  svg.append("g")
    .call(d3.axisLeft(yScale));

  const tooltip = d3.select('#tooltip');

  svg.selectAll('circle')
    .data(data)
    .enter()
    .append('circle')
    .attr('cx', (d) => xScale(d.X))
    .attr('cy', (d) => yScale(d.Y))
    .attr('r', 2)
    .attr('fill', 'green')
    .style('cursor', 'pointer')
    .on('mouseover', (event, d) => {
      tooltip.style('display', 'block');
      tooltip.html(`Нагрузка, кг: <b>${d.Y}</b>, Длина: <b>${d.X}</b>`)
        .style('left', event.pageX + 10 + 'px')
        .style('top', event.pageY - 25 + 'px')
        .style('border-radius', 10 + 'px');
    })
    .on('mouseout', () => {
      tooltip.style('display', 'none');
    });

  svg.selectAll('path.domain')
    .style('stroke', 'white');

  svg.selectAll('g.tick line')
    .style('stroke', '#9ca3af');

  svg.selectAll('text')
    .style('fill', '#9ca3af');
};


</script>

