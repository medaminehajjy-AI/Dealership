<template>
  <div class="card shadow-sm h-100">
    <div class="card-body">

      <h5 class="mb-3">
        Most Requested Cars
      </h5>

      <div
        v-if="cars.length === 0"
        class="text-muted"
      >
        No purchase requests yet.
      </div>

      <div
        v-else
        style="height: 300px;"
      >
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
  LinearScale,
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
  cars: {
    type: Array,
    default: () => [],
  },
})

const chartData = computed(() => ({
  labels: props.cars.map((car) => `${car.brand} ${car.car}`),
  datasets: [
    {
      label: 'Purchase Requests',
      data: props.cars.map((car) => car.requests_count),

      backgroundColor: [
        '#0d6efd',
        '#198754',
        '#ffc107',
        '#dc3545',
        '#6f42c1',
      ],

      borderRadius: 4,

      barThickness: 30,

      maxBarThickness: 30,
    },
  ],
}))

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,

  indexAxis: 'y',

  categoryPercentage: 0.7,

  plugins: {
    legend: {
      display: false,
    },

    tooltip: {
      displayColors: false,

      callbacks: {
        label: (context) => {
          return `${context.raw} request${context.raw === 1 ? '' : 's'}`
        },
      },
    },
  },

  scales: {
    x: {
        beginAtZero: true,

        ticks: {
            precision: 0,
        },

        grid: {
            display: false,
            drawBorder: false,
        },

        title: {
            display: true,
            text: 'Purchase Requests',
        },
        },

    y: {
      grid: {
        display: false,
        drawBorder: false,
      },

      ticks: {
        padding: 6,
      },
    },
  },
}
</script>