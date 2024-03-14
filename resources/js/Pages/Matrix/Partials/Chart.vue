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
import { timeParse } from 'd3-time-format';

const dinamogram = ref(null);

const lastDatasetRef = ref(null);

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

  const parseTime = d3.timeParse("%Y-%m-%d %H:%M:%S%Z");

  // Create the SVG for each dataset
  datasets.forEach((dataset) => {
    const data = dataset.data.map(d => {
      return {
        ...d,
        R: parseFloat(d.R),
        X: parseTime(d.X), // Parse the X field as a date
        Y: parseFloat(d.Y),
      };
    });

    const svg = d3.select(dinamogram.value)
      .append('g')
      .attr('width', width + margin.left + margin.right)
      .attr('height', height + margin.top + margin.bottom)
      .attr('transform', `translate(${margin.left}, ${margin.top})`);

    const xScale = d3.scaleTime()
      .domain([d3.max(data, d => d.X), d3.min(data, d => d.X)])
      .range([0, width]);

    // Customize tick formatting based on the number of ticks
    const tickCount = d3.timeHour.every(2).count;
    const customTickFormat = (tickDate) => {
      const tickFormatOptions = {
        day: 'numeric',
        month: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
      };

      if (tickCount < 12) {
        // Show day, month, year, and time
        return tickDate.toLocaleString(undefined, tickFormatOptions);
      } else if (tickCount >= 12 && tickCount < 24) {
        // Show only day, month, and year
        return tickDate.toLocaleString(undefined, { ...tickFormatOptions, hour: undefined, minute: undefined });
      } else {
        // Show only day if they belong to one month
        const previousDate = new Date(tickDate);
        previousDate.setHours(previousDate.getHours() - 2);

        if (tickDate.getMonth() === previousDate.getMonth()) {
          return tickDate.toLocaleString(undefined, { day: 'numeric', month: 'short' });
        } else {
          return tickDate.toLocaleString(undefined, { day: 'numeric', month: 'short', year: 'numeric' });
        }
      }
    };

    svg.append('g')
      .attr('class', 'x-axis')
      .attr('transform', `translate(0, ${height})`)
      .call(d3.axisBottom(xScale)
        .ticks(d3.timeHour.every(2))
        .tickFormat(customTickFormat)
      );

    const yScale = d3.scaleLinear()
      .domain([d3.min(data, d => Math.min(d.Y, d.R)), d3.max(data, d => Math.max(d.Y, d.R))])
      .range([height, 0]);


    svg.append('g')
      .attr('class', 'y-axis')
      .call(d3.axisLeft(yScale));

    const tooltip = d3.select('#tooltip');

    // Draw lines between fact points based on "X" field
    for (let i = 1; i < data.length; i++) {
      svg.append('line')
        .attr('x1', xScale(data[i - 1].X))
        .attr('y1', yScale(data[i - 1].Y))
        .attr('x2', xScale(data[i].X))
        .attr('y2', yScale(data[i].Y))
        .attr('stroke', dataset.color)
        .attr('stroke-width', 2);
    }

    // Draw points for each dataset
    svg.selectAll('circle.fact') // <-- Add 'fact' class to distinguish between fact and setpoint circles
      .data(data)
      .enter()
      .append('circle')
      .attr('class', 'fact') // <-- Add 'fact' class
      .attr('cx', (d) => xScale(d.X.getTime()))
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
          ${dataset.paramName}: <b>${d.Y}</b>, Дата: <b>${d.X.toLocaleString()}</b>
        </div>
        `)
          .style('left', left + 'px')
          .style('top', mouseY - 25 + 'px')
          .style('border-radius', '10px');
      })
      .on('mouseout', () => {
        tooltip.style('display', 'none');
      });

    const setpointData = [];
    data.forEach(d => {
      setpointData.push({
        X: d.X,
        Y: d.R
      })
    });

    if (dataset.setpoint) {
      // Draw lines between setpoint points based on "X" field
      for (let i = 1; i < setpointData.length; i++) {
        svg.append('line')
          .attr('x1', xScale(setpointData[i - 1].X))
          .attr('y1', yScale(setpointData[i - 1].Y))
          .attr('x2', xScale(setpointData[i].X))
          .attr('y2', yScale(setpointData[i].Y))
          .attr('stroke', dataset.color)
          .attr('stroke-width', 2)
          .attr('opacity', 0.4); // Set opacity to 70%
      }

      svg.selectAll('circle.setpoint') // <-- Add 'setpoint' class
        .data(setpointData)
        .enter()
        .append('circle')
        .attr('class', 'setpoint') // <-- Add 'setpoint' class
        .attr('cx', (d) => xScale(d.X.getTime()))
        .attr('cy', (d) => yScale(d.Y))
        .attr('r', 2)
        .attr('fill', dataset.color)
        .attr('opacity', 0.4)
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
            Уставка: <b>${d.Y}</b>, Дата: <b>${d.X.toLocaleString()}</b>
          </div>
          `)
            .style('left', left + 'px')
            .style('top', mouseY - 25 + 'px')
            .style('border-radius', '10px');
        })
        .on('mouseout', () => {
          tooltip.style('display', 'none');
        });
    }

      lastDatasetRef.current = datasets[datasets.length - 1];

      if (dataset === lastDatasetRef.current) {
        svg.selectAll('path.domain')
          .classed("text-white dark:text-gray-800", true);

        svg.selectAll('.x-axis .tick line')  // Select 'x' ticks
          .classed("text-gray-300 dark:text-gray-600", true);

        svg.selectAll('.y-axis .tick line')  // Select 'y' ticks
          .classed("text-gray-300 dark:text-gray-600", true);

        svg.selectAll('text')
          .classed("text-gray-300 dark:text-gray-600", true);

        const xTicks = svg.selectAll('.x-axis .tick text'); // Select 'x' tick texts

        // Check the length of the dataset and apply styles accordingly
        if (dataset.data.length > 45) {
          xTicks.attr('class', 'text-white dark:text-gray-800'); // Set the class for text-white style
        }
      } else {
          svg.selectAll('path.domain')
              .classed("text-white dark:text-gray-800", true);

          svg.selectAll('g.tick line')
              .classed("text-white dark:text-gray-800", true);

          svg.selectAll('text')
              .classed("text-white dark:text-gray-800", true);
      }

  });
};

</script>
