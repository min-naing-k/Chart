<template>
    <div class="mx-auto w-[95%] min-w-[300px] max-w-[900px] py-5">
        <div class="flex justify-between items-center">
            <h1 class="text-lg text-gray-500 font-medium">
                Dashboard \ Visual Charts
            </h1>
            <div class="flex gap-3 items-center">
                <div>
                    <label class="mr-3">From</label>
                    <input
                        type="date"
                        v-model="from"
                        class="border-gray-200 rounded-md text-sm text-gray-500"
                    />
                </div>

                <div>
                    <label class="mr-3">To</label>
                    <input
                        type="date"
                        v-model="to"
                        class="border-gray-200 rounded-md text-sm text-gray-500"
                    />
                </div>

                <div>
                    <button
                        class="bg-white border text-sm px-4 py-2 rounded-md focus:ring-2 ring-blue-500 ring-offset-1"
                        @click="fetchData"
                    >
                        Search
                    </button>
                </div>
            </div>
        </div>
        <div class="space-y-5 py-4">
            <div
                v-for="(chart, index) in chartsData"
                :key="index"
                class="bg-white p-4 shadow rounded-lg"
            >
                <Chart2 :data="chart" />
            </div>
        </div>
    </div>
</template>

<script setup>
import Chart2 from "@/components/Chart2.vue";
import { Inertia } from "@inertiajs/inertia";
import { computed, ref } from "vue";
import { throttle } from "lodash";

const props = defineProps({
    charts: { type: Object },
});

const from = ref(null);
const to = ref(null);

const SpecificChart = computed(() => Object.keys(props.charts));
const chartsData = computed(() => {
    return SpecificChart.value.map((chart) => {
        return {
            labels: Object.keys(props.charts[chart]).map((string) => {
                return string.split(" ");
            }),
            datasets: [
                {
                    label: chart.charAt(0).toUpperCase() + chart.substring(1),
                    data: Object.values(props.charts[chart]),
                    backgroundColor: [
                        "rgba(255, 99, 132, 1)",
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 206, 86, 1)",
                        "rgba(75, 192, 192, 1)",
                        "rgba(153, 102, 255, 1)",
                        "rgba(255, 159, 64, 1)",
                    ],
                },
            ],
        };
    });
});

const fetchData = () => {
    const data = { from: from.value, to: to.value };

    Inertia.get("dashboard", data, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>
