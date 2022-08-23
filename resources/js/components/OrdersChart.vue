<template>
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-3 mb-3">
            <label for="years" class="text-sm">Years:</label>
            <select
                name="years"
                class="flex items-center py-2 border border-gray-200 rounded-lg text-sm"
                v-model="selectedYear"
            >
                <option
                    :value="year"
                    v-for="year in availableYears"
                    :key="year"
                    :selected="year === selectedYear"
                >
                    {{ year }}
                </option>
            </select>
        </div>
        <transition name="fade" mode="out-in">
            <div class="text-sm flex items-center gap-4" :key="lastYear">
                <h1>
                    {{ lastYear }}:
                    <span class="ml-1">{{ totalLastYearOrders }} orders</span>
                </h1>
                <h1>
                    {{ thisYear }}:
                    <span class="ml-1">{{ totalthisYearOrders }} orders</span>
                </h1>
            </div>
        </transition>
    </div>
    <Chart :labels="labels" :datasets="datasets" />
</template>

<script setup>
import Chart from "@/components/Chart.vue";
import { computed, reactive, ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    orders: { type: Object },
    filter: { type: Object },
});

const selectedYear = ref(Number(props.filter.year));
const thisYear = computed(() => selectedYear.value);
const lastYear = computed(() => selectedYear.value - 1);
const totalLastYearOrders = computed(() =>
    props.orders.lastYearOrders.reduce((total, number) => total + number, 0)
);
const totalthisYearOrders = computed(() =>
    props.orders.thisYearOrders.reduce((total, number) => total + number, 0)
);
const availableYears = Array.from(
    Array(5).keys(),
    (number) => new Date().getFullYear() - number
);
const labels = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
];
const datasets = computed(() => {
    return [
        {
            label: `${lastYear.value} Orders`,
            data: props.orders.lastYearOrders,
            backgroundColor: ["#d1d5db"],
        },
        {
            label: `${thisYear.value} Orders`,
            data: props.orders.thisYearOrders,
            backgroundColor: ["#4ade80"],
        },
    ];
});

watch(
    () => selectedYear.value,
    () => {
        Inertia.get(
            "/",
            { year: selectedYear.value },
            {
                preserveScroll: true,
                preserveState: true,
            }
        );
    }
);
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: all 0.3s linear;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
