<template>
  <div class="w-[60%] flex items-start">
    <svg ref="dinamogram" class="min-h-full w-full"></svg>
    <div id="tooltip" class="flex-col absolute hidden p-2 bg-white border border-gray-200 rounded-lg gap-1"></div>
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

  const width = 1000;
  const height = 350;

  d3.select(dinamogram.value).selectAll('*').remove();

  const svg = d3.select(dinamogram.value)
    .append('g')
    .attr('width', 900)
    .attr('height', 400)
    .attr('transform', 'translate(40, 10)');

  const xScale = d3.scaleLinear()
    .domain([0, d3.max(data, (d) => d.X)])
    .range([0, 900]);

  const yScale = d3.scaleLinear()
    .domain([0, d3.max(data, (d) => d.Y)])
    .range([400, 0]);

  const xAxis = d3.axisBottom(xScale)
    .tickFormat(d3.format('.0f'))
    .ticks(4);

  const yAxis = d3.axisLeft(yScale)
    .tickFormat(d3.format('.0f'))
    .ticks(6);

  svg.append('g')
    .attr('transform', `translate(0, ${height})`)
    .call(xAxis);

  svg.append('g')
    .call(yAxis);

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
      tooltip.html(`Нагрузка, кг: ${d.Y}, Длина: ${d.X}`)
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
