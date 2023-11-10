<template>
  <div class="w-full h-[500px] flex items-start border border-gray-200 dark:border-gray-700 rounded-xl">
    <svg ref="dinamogram" class="min-h-full w-full"></svg>
    <div id="tooltip" class="absolute hidden p-2 bg-white dark:bg-gray-900 dark:border-gray-700 text-white border border-gray-200 rounded-lg gap-1">
    </div>
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

const drawChart = (datasets) => {
  // Extract and merge all data points from the datasets
  const allData = datasets.reduce((acc, dataset) => [...acc, ...dataset.data], []);

  const margin = { top: 20, right: 30, bottom: 30, left: 60 };
  const width = 1800 - margin.left - margin.right;
  const height = 500 - margin.top - margin.bottom;

  // Clear the existing chart
  d3.select(dinamogram.value).selectAll('*').remove();

  // Find the maximum and minimum Y values across all datasets
  const yMax = d3.max(allData, (d) => d.Y);
  const yMin = d3.min(allData, (d) => d.Y);

  // Create the SVG for each dataset
  datasets.forEach((dataset) => {
    const data = dataset.data.map(d => {
      return {
        ...d,
        X: parseFloat(d.X),
        Y: new Date(d.Y), // Parse the Y field as a date
      };
    });

    // Sort the data based on the "X" field
    data.sort((a, b) => a.X - b.X); // Sort by the "X" field

    const svg = d3.select(dinamogram.value)
      .append('g')
      .attr('width', width + margin.left + margin.right)
      .attr('height', height + margin.top + margin.bottom)
      .attr('transform', `translate(${margin.left}, ${margin.top})`);

    const yScale = d3.scaleTime()
      .domain([yMin, yMax])
      .range([height, 0]);
    svg.append('g')
      .call(d3.axisLeft(yScale));

    const tooltip = d3.select('#tooltip');

    // Draw points for each dataset
    svg.selectAll('circle')
      .data(data)
      .enter()
      .append('circle')
      .attr('cx', (d) => (d.X * width) / data[data.length - 1].X) // Scale the x-coordinate
      .attr('cy', (d) => yScale(d.Y))
      .attr('r', 2)
      .attr('fill', dataset.color)
      .style('cursor', 'pointer')
      .on('mouseover', (event, d) => {
        const tooltipWidth = 300;
        const mouseX = event.pageX;
        const mouseY = event.pageY;

        let left = mouseX + 10; // Default position

        // Check if the tooltip would overflow to the right
        if (left + tooltipWidth > window.innerWidth) {
          // Move the tooltip to the left of the cursor
          left = mouseX - tooltipWidth - 10;
        }

        tooltip.style('display', 'block');
        tooltip.html(`
        <div class="flex items-center gap-2 text-gray-800 dark:text-gray-300">
          <div class="w-2 h-2 rounded-full" style="background-color: ${dataset.color}"></div> 
          ${dataset.paramName}: <b>${d.X}</b>, Дата: <b>${d.Y.getFullYear()}-${d.Y.getMonth()}-${d.Y.getDay()} / ${d.Y.getHours()}:${d.Y.getMinutes()}</b>
        </div>
        `)
          .style('left', left + 'px')
          .style('top', mouseY - 25 + 'px')
          .style('border-radius', '10px');
      })
      .on('mouseout', () => {
        tooltip.style('display', 'none');
      });

    // Draw lines between points based on "X" field
    for (let i = 1; i < data.length; i++) {
      svg.append('line')
        .attr('x1', (data[i - 1].X * width) / data[data.length - 1].X) // Scale the x-coordinate
        .attr('y1', yScale(data[i - 1].Y))
        .attr('x2', (data[i].X * width) / data[data.length - 1].X) // Scale the x-coordinate
        .attr('y2', yScale(data[i].Y))
        .attr('stroke', dataset.color)
        .attr('stroke-width', 1);
    }

    svg.selectAll('path.domain')
    .classed("text-white dark:text-gray-800", true);

    svg.selectAll('g.tick line')
    .classed("text-gray-300 dark:text-gray-600", true);

    svg.selectAll('text')
    .classed("text-gray-300 dark:text-gray-600", true);
  });
};
</script>
