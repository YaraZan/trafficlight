<template>
  <div class="w-[60%] flex items-start border border-gray-200 rounded-xl">
    <svg ref="dinamogram" class="min-h-full w-full"></svg>
    <div id="tooltip" class="absolute hidden p-2 bg-gray-900 text-white border border-gray-200 rounded-lg gap-1">

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
  const width = 1000 - margin.left - margin.right;
  const height = 400 - margin.top - margin.bottom;

  // Find the maximum and minimum X and Y values across all datasets
  const xMax = d3.max(allData, (d) => parseFloat(d.X));
  const yMax = Math.ceil(d3.max(allData, (d) => d.Y) / 500) * 500;
  const yMin = Math.floor(d3.min(allData, (d) => d.Y) / 500) * 500;
  

  // Clear the existing chart
  d3.select(dinamogram.value).selectAll('*').remove();

  // Create the SVG for each dataset
  datasets.forEach((dataset) => {

    const data = dataset.data.map(d => {
    return {
      ...d,
      X: parseFloat(d.X),
      Y: parseFloat(d.Y),
      P: parseInt(d.P), // Parse the P field as an integer
    };
  });

    // Sort the data based on the "P" field
    data.sort((a, b) => a.P - b.P); // Sort by the "P" field

    const svg = d3.select(dinamogram.value)
      .append('g')
      .attr('width', width + margin.left + margin.right)
      .attr('height', height + margin.top + margin.bottom)
      .attr('transform', `translate(${margin.left}, ${margin.top})`);

    const xScale = d3.scaleLinear()
      .domain([0, xMax])
      .range([0, width]);
    svg.append('g')
      .attr('transform', `translate(0, ${height})`)
      .call(d3.axisBottom(xScale));

    const yScale = d3.scaleLinear()
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
      .attr('cx', (d) => xScale(d.X))
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
        <div class="flex items-center gap-2">
          <div class="w-2 h-2 rounded-full" style="background-color: ${dataset.color}"></div> Нагрузка, кг: <b>${d.Y}</b>, Длина: <b>${d.X}</b>
        </div>
        `)
          .style('left', left + 'px')
          .style('top', mouseY - 25 + 'px')
          .style('border-radius', '10px');
      })
      .on('mouseout', () => {
        tooltip.style('display', 'none');
      });
      

    // Draw lines between points based on "P" field
    for (let i = 1; i < data.length; i++) {
      svg.append('line')
        .attr('x1', xScale(data[i - 1].X))
        .attr('y1', yScale(data[i - 1].Y))
        .attr('x2', xScale(data[i].X))
        .attr('y2', yScale(data[i].Y))
        .attr('stroke', dataset.color)
        .attr('stroke-width', 1);
    }

    svg.selectAll('path.domain')
    .style('stroke', 'white');

    svg.selectAll('g.tick line')
      .style('stroke', '#9ca3af');

    svg.selectAll('text')
      .style('fill', '#9ca3af');
  });
};
</script>
