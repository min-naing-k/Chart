<template>
    <canvas ref="ctx"></canvas>
</template>

<script setup>
import Chart from "chart.js/auto";
import { onMounted, ref, watch } from "vue";

const props = defineProps({
    data: { type: Object },
});

let chart = null;
const ctx = ref(null);

onMounted(() => {
    chart = new Chart(ctx.value.getContext("2d"), {
        type: "bar",
        data: props.data,
        options: {
            responsive: true,
            borderRadius: 3,
            maxBarThickness: 30,
            plugins: {
                legend: {
                    labels: {
                        usePointStyle: true,
                        pointStyle: "rectRounded",
                    },
                },
            },
        },
    });
});

const updateTheChart = () => {
    chart.data.labels = props.data.labels;
    chart.data.datasets[0].data = props.data.datasets[0].data;
    chart.update();
};

watch(() => props.data, updateTheChart);
</script>

<style></style>
