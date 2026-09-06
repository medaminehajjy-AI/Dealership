```vue
<template>
  <div class="card shadow-sm h-100">
    <div class="card-body">

      <h5 class="mb-3">
        Sales Performance
      </h5>

      <div v-if="sales.length === 0" class="text-muted py-4 text-center">
        No completed sales yet.
      </div>

      <div v-else class="chart-container">
        <Bar
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
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js'

import { Bar } from 'vue-chartjs'

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
)

const props = defineProps({
  sales: {
    type: Array,
    default: () => []
  }
})

const chartData = computed(() => ({
  labels: props.sales.map(sale => {
    const [year, month] = sale.month.split('-')

    return new Date(year, month - 1).toLocaleDateString('en-US', {
      month: 'short',
      year: 'numeric'
    })
  }),

    datasets: [
    {
        label: 'Estimated Sales Value',
        data: props.sales.map(sale => sale.estimated_sales_value),

        backgroundColor: '#0d6efd',
        borderColor: '#0d6efd',

        borderWidth: 1,

        barPercentage: 0.5,
        categoryPercentage: 0.6
    }
    ]

}))

const chartOptions = {
  responsive: true,

  maintainAspectRatio: false,

  plugins: {
  legend: {
    display: true
  },

    tooltip: {
        callbacks: {
        label: (context) => {
            const value = context.raw ?? 0

            return ` Estimated Sales Value: ${new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
            }).format(value)}`
        }
        }
    }
    },

  scales: {
    y: {
      beginAtZero: true,

      ticks: {
        callback: (value) => {
          return new Intl.NumberFormat('en-US').format(value)
        }
      }
    }
  }
}
</script>

<style scoped>
.chart-container {
  position: relative;
  height: 300px;
}
</style>

