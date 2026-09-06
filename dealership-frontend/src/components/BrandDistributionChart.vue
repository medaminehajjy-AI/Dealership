```vue
<template>
  <div class="card shadow-sm h-100">
    <div class="card-body">

      <h5 class="mb-3">
        Inventory by Brand
      </h5>

      <div
        v-if="brands.length === 0"
        class="text-muted py-4 text-center"
      >
        No inventory data available.
      </div>

      <div v-else class="chart-container">
        <Doughnut
            :data="chartData"
            :options="chartOptions"
        />
      </div>

    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

import {
  Chart as ChartJS,
  ArcElement,
  Tooltip,
  Legend
} from 'chart.js'

import { Doughnut } from 'vue-chartjs'

ChartJS.register(
  ArcElement,
  Tooltip,
  Legend
)

const props = defineProps({
  brands: {
    type: Array,
    default: () => []
  }
})

const chartData = computed(() => ({
  labels: props.brands.map(item => item.brand),

    datasets: [
    {
        label: 'Cars',
        data: props.brands.map(item => item.cars_count),

        backgroundColor: [
        '#0d6efd',
        '#198754',
        '#ffc107',
        '#dc3545',
        '#6f42c1',
        '#20c997',
        '#fd7e14',
        '#6c757d'
        ],

        borderWidth: 2
    }
    ]
}))

const chartOptions = {
  responsive: true,

  maintainAspectRatio: false,

  plugins: {
    legend: {
      position: 'right',

      labels: {
        padding: 15
      }
    }
  },

  cutout: '60%'
}
</script>

<style scoped>
.chart-container {
  position: relative;
  height: 300px;
}
</style>
