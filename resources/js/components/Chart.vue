<template>
    <canvas ref="ctx"></canvas>
</template>

<script setup>
import Chart from "chart.js/auto";
import { onMounted, ref, watch } from "vue";

const props = defineProps({
    labels: { type: Array },
    datasets: { type: Array },
    update: { type: Boolean },
});

let chart = null;
const ctx = ref(null);

const updateTheChart = () => {
    props.datasets.forEach((dataset, index) => {
        chart.data.datasets[index].label = dataset.label;
        chart.data.datasets[index].data = dataset.data;
    });
    chart.update();
};

onMounted(() => {
    chart = new Chart(ctx.value.getContext("2d"), {
        type: "bar",
        data: {
            labels: props.labels,
            datasets: props.datasets,
        },
        options: {
            responsive: true,
            borderRadius: 3,
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

watch(
    () => props.datasets[0].data,
    () => {
        updateTheChart();
    }
);
</script>

<style></style>
