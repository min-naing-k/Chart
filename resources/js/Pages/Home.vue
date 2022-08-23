<template>
    <div class="space-y-5 py-4">
        <div
            class="mx-auto bg-white p-4 shadow rounded-lg w-[95%] min-w-[300px] max-w-[900px]"
        >
            <h1 class="pb-6 text-2xl">Orders</h1>
            <OrdersChart :orders="orders" :filter="filter" />
        </div>
    </div>
</template>

<script setup>
import OrdersChart from "@/components/OrdersChart.vue";
import Chart from "@/components/Chart.vue";
import { computed } from "vue";

const props = defineProps({
    orders: { type: Object },
    filter: { type: Object },
});
</script>
