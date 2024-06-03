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
    gradientStroke.addColorStop(0, "#b6f016");
    gradientStroke.addColorStop(1, "#00b53f");

    const gradientFill = ctx.createLinearGradient(500, 0, 100, 0);
    gradientFill.addColorStop(0, "rgba(182, 240, 22, 0.2)");
    gradientFill.addColorStop(1, "rgba(0, 181, 63, 0.2)");


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
                pointBorderWidth: 5,
                pointHoverRadius: 5,
                pointHoverBorderWidth: 1,
                pointRadius: 1,
                fill: true,
                backgroundColor: gradientFill,
                borderWidth: 4,
                data: Object.values(claimsDatsArr.value)
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                },
            },
            animation: {
                easing: "easeInOutBack"
            },
            legend: {
                position: "bottom",
                display: false,
            },
            scales: {
                x: {
                display: false,
            },
            y: {
                display: false,
            },
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
