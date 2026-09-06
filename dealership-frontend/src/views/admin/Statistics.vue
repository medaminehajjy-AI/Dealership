<template>
  <div class="container-fluid py-4">

    <div class="mb-4">
      <h1>{{ t('adminStatistics.title') }}</h1>
      <p class="text-muted">
            {{ t('adminStatistics.description') }}
      </p>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary"></div>
      <p class="mt-3">
        {{ t('adminStatistics.loading') }}
      </p>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <!-- Statistics -->
    <div v-else>

      <!-- Sales Overview -->
      <div class="row g-4 mb-4">

        <div class="col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h6 class="text-muted">
                {{ t('adminStatistics.carsSold') }}
              </h6>

              <h2 class="mb-0">
                {{ statistics.cars_sold }}
              </h2>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h6 class="text-muted">
                {{ t('adminStatistics.estimatedSalesValue') }}
              </h6>

              <h2 class="mb-0">
                {{ formatPrice(statistics.estimated_sales_value) }}
              </h2>
            </div>
          </div>
        </div>

      </div>
      
        <!-- Analytics Charts -->
        <div class="row g-4 mb-4">

            <!-- Sales Performance -->
            <div class="col-12 col-lg-6">

                <SalesPerformanceChart
                :sales="statistics.monthly_sales"
                />

            </div>


            <!-- Inventory by Brand -->
            <div class="col-12 col-lg-6">

                <BrandDistributionChart
                :brands="statistics.inventory_by_brand"
                />

            </div>

        </div>
    
        <!-- Latest Sold Cars -->
        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <h5 class="mb-3">
                    {{ t('adminStatistics.latestSoldCars') }}
                </h5>

                <div
                v-if="statistics.latest_sold_cars.length === 0"
                class="text-muted"
                >
                    {{ t('adminStatistics.noCompletedSales') }}
                </div>

                <div v-else class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                    <tr>
                        <th>{{ t('adminStatistics.car') }}</th>
                        <th>{{ t('adminStatistics.brand') }}</th>
                        <th>{{ t('adminStatistics.category') }}</th>
                        <th>{{ t('adminStatistics.price') }}</th>
                        <th>{{ t('adminStatistics.soldDate') }}</th>
                    </tr>
                    </thead>

                    <tbody>

                    <tr
                        v-for="sale in statistics.latest_sold_cars"
                        :key="sale.id"
                    >

                        <td class="fw-semibold">
                        {{ sale.car }}
                        </td>

                        <td>
                        {{ sale.brand }}
                        </td>

                        <td>
                        {{ sale.category }}
                        </td>

                        <td>
                        {{ formatPrice(sale.price) }}
                        </td>

                        <td>
                        {{ sale.sold_at }}
                        </td>

                    </tr>

                    </tbody>

                </table>

                </div>

            </div>

        </div>


        <!-- Most Requested Cars -->
        <div class="row g-4 mb-4">

            <div class="col-12">

                <MostRequestedCarsChart
                    :cars="statistics.most_requested_cars"
                />

            </div>

        </div>


        <!-- Monthly Sales -->
        <div class="row g-4 mb-4">
           <div class="col-md-6">

        <div class="card shadow-sm mb-4">
            <div class="card-body">

            <h5 class="mb-3">
                {{ t('adminStatistics.monthlySales') }}
            </h5>

            <div
                v-if="statistics.monthly_sales.length === 0"
                class="text-muted"
            >
                {{ t('adminStatistics.noCompletedSales') }}
            </div>

            <div v-else class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>{{ t('adminStatistics.month') }}</th>
                        <th>{{ t('adminStatistics.salesCarsSold') }}</th>
                        <th>{{ t('adminStatistics.salesValue') }}</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                    v-for="sale in statistics.monthly_sales"
                    :key="sale.month"
                    >
                    <td>{{ sale.month }}</td>

                    <td>
                        {{ sale.cars_sold }}
                    </td>

                    <td>
                        {{ formatPrice(sale.estimated_sales_value) }}
                    </td>
                    </tr>
                </tbody>

                </table>

            </div>

            </div>
        </div>

        </div>

        <!-- Annual Sales -->
        <div class="col-md-6">
        <div class="card shadow-sm">

            <div class="card-body">

            <h5 class="mb-3">
                {{ t('adminStatistics.annualSales') }}
            </h5>

            <div
                v-if="statistics.annual_sales.length === 0"
                class="text-muted"
            >
                {{ t('adminStatistics.noCompletedSales') }}
            </div>

            <div v-else class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>{{ t('adminStatistics.year') }}</th>
                        <th>{{ t('adminStatistics.salesCarsSold') }}</th>
                        <th>{{ t('adminStatistics.salesValue') }}</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                    v-for="sale in statistics.annual_sales"
                    :key="sale.year"
                    >
                    <td>{{ sale.year }}</td>

                    <td>
                        {{ sale.cars_sold }}
                    </td>

                    <td>
                        {{ formatPrice(sale.estimated_sales_value) }}
                    </td>
                    </tr>
                </tbody>

                </table>

            </div>

            </div>

        </div>

        </div>
        </div>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import carsService from '../../services/cars'
import SalesPerformanceChart from '../../components/SalesPerformanceChart.vue'
import BrandDistributionChart from '../../components/BrandDistributionChart.vue'
import MostRequestedCarsChart from '../../components/MostRequestedCarsChart.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const loading = ref(true)
const error = ref(null)

const statistics = ref({
  cars_sold: 0,
  estimated_sales_value: 0,
  monthly_sales: [],
  annual_sales: [],
  inventory_by_brand: [],
  latest_sold_cars: [],
  most_requested_cars: [],
})

const loadStatistics = async () => {
  try {
    const response = await carsService.getAdminStatistics()

    statistics.value = response.data
  } catch (err) {
    error.value = t('adminStatistics.error')
  } finally {
    loading.value = false
  }
}

const formatPrice = (price) => {
  return new Intl.NumberFormat('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(price)
}

onMounted(() => {
  loadStatistics()
})
</script>
