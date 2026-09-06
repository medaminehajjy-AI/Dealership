<template>

    <!-- Page Header -->
    <div class="mb-4">
      <h1 class="h3 fw-semibold mb-1">
          {{ t('adminDashboard.title') }}
      </h1>

      <p class="text-muted mb-0">
          {{ t('adminDashboard.welcome') }}
      </p>
    </div>


    <!-- Loading -->
    <div
      v-if="loading"
      class="text-center py-5"
    >
      <div
        class="spinner-border text-primary"
        role="status"
      >
        <span class="visually-hidden">
            {{ t('adminDashboard.loading') }}
        </span>
      </div>

      <p class="text-muted mt-3 mb-0">
          {{ t('adminDashboard.loadingDashboard') }}
      </p>
    </div>


    <!-- Error -->
    <div
      v-else-if="error"
      class="alert alert-danger"
      role="alert"
    >
      {{ error }}
    </div>


    <!-- Dashboard -->
    <div
      v-else
      class="row g-4"
    >

      <!-- Total Cars -->
      <div class="col-12 col-sm-6 col-xl-3">
        <RouterLink
            to="/admin/cars"
            class="card border-0 shadow-sm h-100 text-decoration-none text-dark"
          >
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

              <div>
                <p class="text-muted small fw-semibold mb-2">
                  {{ t('adminDashboard.totalCars') }}
                </p>

                <h2 class="fw-bold mb-0">
                  {{ stats.total_cars }}
                </h2>
              </div>

              <div class="stat-icon bg-primary-subtle text-primary">
                <i class="bi bi-car-front-fill"></i>
              </div>

            </div>

          </div>
          </RouterLink>
      </div>


      <!-- Available Cars -->
      <div class="col-12 col-sm-6 col-xl-3">
        <RouterLink
          to="/admin/cars"
          class="card border-0 shadow-sm h-100 text-decoration-none text-dark"
        >
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

              <div>
                <p class="text-muted small fw-semibold mb-2">
                  {{ t('adminDashboard.availableCars') }}
                </p>

                <h2 class="fw-bold mb-0">
                  {{ stats.available_cars }}
                </h2>
              </div>

              <div class="stat-icon bg-success-subtle text-success">
                <i class="bi bi-check-circle-fill"></i>
              </div>

            </div>

          </div>
        </RouterLink>
      </div>


      <!-- Customers -->
      <div class="col-12 col-sm-6 col-xl-3">
        <RouterLink
          to="/admin/customers"
          class="card border-0 shadow-sm h-100 text-decoration-none text-dark"
        >
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

              <div>
                <p class="text-muted small fw-semibold mb-2">
                  {{ t('adminDashboard.customers') }}
                </p>

                <h2 class="fw-bold mb-0">
                  {{ stats.customers }}
                </h2>
              </div>

              <div class="stat-icon bg-info-subtle text-info">
                <i class="bi bi-people-fill"></i>
              </div>

            </div>

          </div>
        </RouterLink>
      </div>


      <!-- Pending Requests -->
      <div class="col-12 col-sm-6 col-xl-3">
        <RouterLink
          to="/admin/purchase-requests"
          class="card border-0 shadow-sm h-100 text-decoration-none text-dark"
        >
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

              <div>
                <p class="text-muted small fw-semibold mb-2">
                  {{ t('adminDashboard.pendingRequests') }}
                </p>

                <h2 class="fw-bold mb-0">
                  {{ stats.pending_purchase_requests }}
                </h2>
              </div>

              <div class="stat-icon bg-warning-subtle text-warning">
                <i class="bi bi-hourglass-split"></i>
              </div>

            </div>

          </div>
        </RouterLink>
      </div>

      <!-- Pending Bookings -->
      <div class="col-12 col-sm-6 col-xl-3">
        <RouterLink
          to="/admin/bookings"
          class="card border-0 shadow-sm h-100 text-decoration-none text-dark"
        >
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

              <div>
                <p class="text-muted small fw-semibold mb-2">
                  {{ t('adminDashboard.pendingBookings') }}
                </p>

                <h2 class="fw-bold mb-0">
                  {{ stats.pending_bookings }}
                </h2>
              </div>

              <div class="stat-icon bg-primary-subtle text-primary">
                <i class="bi bi-calendar-check-fill"></i>
              </div>

            </div>

          </div>
        </RouterLink>
      </div>

            <!-- Unread Messages -->
      <div class="col-12 col-sm-6 col-xl-3">
        <RouterLink
          to="/admin/messages"
          class="card border-0 shadow-sm h-100 text-decoration-none text-dark"
        >
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

              <div>
                <p class="text-muted small fw-semibold mb-2">
                  {{ t('adminDashboard.unreadMessages') }}
                </p>

                <h2 class="fw-bold mb-0">
                  {{ stats.unread_messages }}
                </h2>
              </div>

              <div class="stat-icon bg-info-subtle text-info">
                <i class="bi bi-chat-dots-fill"></i>
              </div>

            </div>

          </div>
        </RouterLink>
      </div>

    </div>


    <!-- Recent Activity -->
    <div class="row g-4 mt-1">

      <!-- Latest Pending Bookings -->
      <div class="col-12 col-xl-6">

        <div class="card border-0 shadow-sm">

          <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

              <div>
                <h5 class="mb-1">
                  {{ t('adminDashboard.latestPendingBookings') }}
                </h5>

                <p class="text-muted small mb-0">
                  {{ t('adminDashboard.recentBookingsDescription') }}
                </p>
              </div>

              <RouterLink
                to="/admin/bookings"
                class="btn btn-sm btn-outline-primary"
              >
                {{ t('adminDashboard.viewAll') }}
              </RouterLink>

            </div>


            <!-- No bookings -->
            <div
              v-if="stats.latest_pending_bookings.length === 0"
              class="text-muted text-center py-4"
            >
              {{ t('adminDashboard.noPendingBookings') }}
            </div>


            <!-- Bookings -->
            <div
              v-else
              class="table-responsive"
            >

              <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                  <tr>
                    <th>{{ t('adminDashboard.customer') }}</th>
                    <th>{{ t('adminDashboard.car') }}</th>
                    <th>{{ t('adminDashboard.bookingDate') }}</th>
                    <th>{{ t('adminDashboard.bookingTime') }}</th>
                    <th>{{ t('adminDashboard.status') }}</th>
                  </tr>
                </thead>

                <tbody>

                  <tr
                    v-for="booking in stats.latest_pending_bookings"
                    :key="booking.id"
                  >

                    <td>
                      {{ booking.user?.name || t('adminDashboard.unknownCustomer') }}
                    </td>

                    <td>
                      <div class="fw-semibold">
                        {{ booking.car?.brand?.name || t('adminDashboard.unknownBrand') }}
                        {{ booking.car?.model ?? '' }}
                      </div>
                    </td>

                    <td>
                      {{ new Date(booking.booking_date).toLocaleDateString() }}
                    </td>

                    <td>
                      {{ booking.booking_time }}
                    </td>

                    <td>
                      <span class="badge bg-warning text-dark">
                        {{ t('adminDashboard.statuses.pending') }}
                      </span>
                    </td>

                  </tr>

                </tbody>

              </table>

            </div>

          </div>

        </div>

      </div>
      
      <!-- Latest Purchase Requests -->
      <div class="col-12 col-xl-6">

        <div class="card border-0 shadow-sm">

          <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

              <div>
                <h5 class="mb-1">
                  {{ t('adminDashboard.latestPurchaseRequests') }}
                </h5>

                <p class="text-muted small mb-0">
                  {{ t('adminDashboard.recentPurchaseRequestsDescription') }}
                </p>
              </div>

              <RouterLink
                to="/admin/purchase-requests"
                class="btn btn-sm btn-outline-primary"
              >
                {{ t('adminDashboard.viewAll') }}
              </RouterLink>

            </div>


            <!-- No requests -->
            <div
              v-if="stats.latest_purchase_requests.length === 0"
              class="text-muted text-center py-4"
            >
              {{ t('adminDashboard.noPurchaseRequests') }}
            </div>


            <!-- Requests -->
            <div
              v-else
              class="table-responsive"
            >

              <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                  <tr>
                    <th>{{ t('adminDashboard.customer') }}</th>
                    <th>{{ t('adminDashboard.car') }}</th>
                    <th>{{ t('adminDashboard.date') }}</th>
                    <th>{{ t('adminDashboard.status') }}</th>
                  </tr>
                </thead>

                <tbody>

                  <tr
                    v-for="request in stats.latest_purchase_requests"
                    :key="request.id"
                  >

                    <td>
                      {{ request.user?.name || t('adminDashboard.unknownCustomer') }}
                    </td>

                    <td>
                      <div class="fw-semibold">
                        {{ request.car?.brand?.name || t('adminDashboard.unknownBrand') }}
                        {{ request.car?.model ?? '' }}
                      </div>
                    </td>

                    <td>
                      {{ new Date(request.created_at).toLocaleDateString() }}
                    </td>

                    <td>
                      <span
                        class="badge"
                        :class="{
                          'bg-warning text-dark': request.status === 'pending',
                          'bg-success': request.status === 'approved',
                          'bg-danger': request.status === 'rejected',
                          'bg-primary': request.status === 'completed'
                        }"
                      >
                        {{ t(`adminDashboard.statuses.${request.status}`, request.status) }}
                      </span>
                    </td>

                  </tr>

                </tbody>

              </table>

            </div>

          </div>

        </div>

      </div>

    </div>
        <!-- Low Inventory -->
        <div class="row g-4 mt-1">

          <div class="col-12">

            <div class="card border-0 shadow-sm">

              <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                  <div>
                    <h5 class="mb-1">
                      {{ t('adminDashboard.lowInventory') }}
                    </h5>

                    <p class="text-muted small mb-0">
                     {{ t('adminDashboard.lowInventoryDescription') }}
                    </p>
                  </div>

                  <RouterLink
                    to="/admin/cars"
                    class="btn btn-sm btn-outline-primary"
                  >
                    {{ t('adminDashboard.manageCars') }}
                  </RouterLink>

                </div>


                <!-- No low inventory -->
                <div
                  v-if="stats.low_inventory.length === 0"
                  class="text-muted text-center py-4"
                >
                  {{ t('adminDashboard.noLowInventoryAlerts') }}
                </div>


                <!-- Low inventory items -->
                <div
                  v-else
                  class="table-responsive"
                >

                  <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                      <tr>
                        <th>{{ t('adminDashboard.brand') }}</th>
                        <th>{{ t('adminDashboard.model') }}</th>
                        <th>{{ t('adminDashboard.available') }}</th>
                        <th>{{ t('adminDashboard.stockStatus') }}</th>
                      </tr>
                    </thead>

                    <tbody>

                      <tr
                        v-for="car in stats.low_inventory"
                        :key="`${car.brand}-${car.model}`"
                      >

                        <td>
                          {{ car.brand }}
                        </td>

                        <td class="fw-semibold">
                          {{ car.model }}
                        </td>

                        <td>
                          {{ car.available_count }}
                        </td>

                        <td>

                          <span
                            v-if="car.available_count === 1"
                            class="badge bg-danger"
                          >
                            {{ t('adminDashboard.critical') }}
                          </span>

                          <span
                            v-else
                            class="badge bg-warning text-dark"
                          >
                            {{ t('adminDashboard.lowStock') }}
                          </span>

                        </td>

                      </tr>

                    </tbody>

                  </table>

                </div>

              </div>

            </div>

          </div>

        </div>

        <!-- Most Requested Cars -->
        <div class="row g-4 mt-1">

          <div class="col-12">

            <div class="card border-0 shadow-sm">

              <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                  <div>
                    <h5 class="mb-1">
                      {{ t('adminDashboard.mostRequestedCars') }}
                    </h5>

                    <p class="text-muted small mb-0">
                      {{ t('adminDashboard.mostRequestedCarsDescription') }}
                    </p>
                  </div>

                  <RouterLink
                    to="/admin/purchase-requests"
                    class="btn btn-sm btn-outline-primary"
                  >
                    {{ t('adminDashboard.viewRequests') }}
                  </RouterLink>

                </div>


                <!-- No requests -->
                <div
                  v-if="stats.most_requested_cars.length === 0"
                  class="text-muted text-center py-4"
                >
                  {{ t('adminDashboard.noPurchaseRequestData') }}
                </div>


                <!-- Most requested cars -->
                <div
                  v-else
                  class="table-responsive"
                >

                  <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                      <tr>
                        <th>#</th>
                        <th>{{ t('adminDashboard.brand') }}</th>
                        <th>{{ t('adminDashboard.model') }}</th>
                        <th>{{ t('adminDashboard.purchaseRequests') }}</th>
                      </tr>
                    </thead>

                    <tbody>

                      <tr
                        v-for="(car, index) in stats.most_requested_cars"
                        :key="car.car_id"
                      >

                        <td>
                          {{ index + 1 }}
                        </td>

                        <td>
                          {{ car.brand }}
                        </td>

                        <td class="fw-semibold">
                          {{ car.model }}
                        </td>

                        <td>
                          <span class="badge bg-primary">
                            {{ car.requests_count }}
                          </span>
                        </td>

                      </tr>

                    </tbody>

                  </table>

                </div>

              </div>

            </div>

          </div>

        </div>
  
</template>

<style scoped>
.stat-icon {
  width: 44px;
  height: 44px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 10px;

  font-size: 18px;
  font-weight: 700;
}
</style>


<script setup>
import { ref, onMounted } from 'vue'
import carsService from '../../services/cars'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const stats = ref({
  total_cars: 0,
  available_cars: 0,
  customers: 0,
  pending_purchase_requests: 0,
  unread_messages : 0,
  pending_bookings : 0,
  latest_pending_bookings: [],
  latest_purchase_requests: [],
  low_inventory: [],
  most_requested_cars: [],
})

const loading = ref(true)
const error = ref(null)

const loadDashboard = async () => {
  try {
    const response = await carsService.getAdminDashboard()

    stats.value = response.data

  } catch (err) {
    error.value = t('adminDashboard.error')
  } finally {
    loading.value = false
  }
}


onMounted(() => {
  loadDashboard()
})
</script>
