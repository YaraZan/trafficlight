<template>
    <div class="w-full h-[200px] relative">
        <canvas class="w-full h-full" id="totalClaimsCreatedChart"></canvas>
    </div>
</template>

<script setup>
import Chart from 'chart.js/auto';
import { computed } from 'vue';

const props = defineProps({
    claims: {
        type: Array
    }
})

const claimsDatsArr = computed(() => {
    const counts = {};
    props.claims.forEach(claim => {
        const date = claim.Dat;
        counts[date] = (counts[date] || 0) + 1;
    });
    return counts;
})

window.onload = function() {
    const ctx = document.getElementById('totalClaimsCreatedChart').getContext("2d");

    const gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, "#80b6f4");
    gradientStroke.addColorStop(1, "#f49080");

    const gradientFill = ctx.createLinearGradient(500, 0, 100, 0);
    gradientFill.addColorStop(0, "rgba(128, 182, 244, 0.6)");
    gradientFill.addColorStop(1, "rgba(244, 144, 128, 0.6)");


    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: Object.keys(claimsDatsArr.value),
            datasets: [{
                label: "Data",
                borderColor: gradientStroke,
                pointBorderColor: gradientStroke,
                pointBackgroundColor: gradientStroke,
                pointHoverBackgroundColor: gradientStroke,
                pointHoverBorderColor: gradientStroke,
                pointBorderWidth: 10,
                pointHoverRadius: 10,
                pointHoverBorderWidth: 1,
                pointRadius: 2,
                fill: true,
                backgroundColor: gradientFill,
                borderWidth: 4,
                data: Object.values(claimsDatsArr.value)
            }]
        },
        options: {
            animation: {
                easing: "easeInOutBack"
            },
            legend: {
                position: "bottom",
                display: false,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        fontColor: "rgba(0,0,0,0.5)",
                        fontStyle: "bold",
                        beginAtZero: true,
                        maxTicksLimit: 5,
                        padding: 20
                    },
                    gridLines: {
                        drawTicks: false,
                        display: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                        zeroLineColor: "transparent"
                },
                    ticks: {
                        padding: 20,
                        fontColor: "rgba(0,0,0,0.5)",
                        fontStyle: "bold"
                    }
                }]
            }
        }
    });
}
</script>
