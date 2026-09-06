<template>
  <div class="container py-5">

    <h1 class="mb-4">{{ t('purchaseRequests.title') }}</h1>

    <!-- Loading -->
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status"></div>

      <p class="mt-3">{{ t('purchaseRequests.loading') }}</p>

    </div>

    <!-- Error -->
    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <!-- Empty -->
    <div
      v-else-if="requests.length === 0"
      class="text-center py-5"
    >
      <h4>{{ t('purchaseRequests.emptyTitle') }}</h4>

      <p class="text-muted">
        {{ t('purchaseRequests.emptyMessage') }}
      </p>

      <router-link to="/cars" class="btn btn-primary">
        {{ t('purchaseRequests.browseCars') }}
      </router-link>
    </div>

    <!-- Requests -->
    <div v-else>

      <div
        v-for="request in requests"
        :key="request.id"
        class="card mb-4"
      >

        <div class="row g-0">

          <!-- Car image -->
          <div class="col-md-4">

            <img
              v-if="request.car.images?.[0]?.image"
              :src="getImageUrl(request.car.images?.[0]?.image)"
              :alt="request.car.model"
              class="img-fluid rounded-start h-100"
              style="object-fit: cover;"
            >

            <div v-else class="d-flex align-items-center justify-content-center h-100 bg-light">
              {{ t('purchaseRequests.noImage') }}
            </div>

          </div>

          <!-- Request information -->
          <div class="col-md-8">

            <div class="card-body">

              <h4 class="card-title">
                {{ request.car.brand?.name }}
                {{ request.car.model }}
              </h4>

              <p class="text-muted">
                {{ request.car.year }}
                ·
                {{ request.car.category?.name }}
              </p>

              <p>
                <strong>{{ t('purchaseRequests.status') }}:</strong>

                <span
                  class="badge ms-2"
                  :class="{
                    'bg-warning text-dark': request.status === 'pending',
                    'bg-success': request.status === 'approved',
                    'bg-danger': request.status === 'rejected',
                    'bg-primary': request.status === 'completed'
                  }"
                >
                  {{ request.status }}
                </span>
              </p>

              <p v-if="request.message">
                <strong>{{ t('purchaseRequests.yourMessage') }}</strong><br>
                {{ request.message }}
              </p>

              <router-link
                :to="`/cars/${request.car.id}`"
                class="btn btn-outline-primary"
              >
                {{ t('purchaseRequests.viewCar') }}
              </router-link>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import carsService from '../services/cars'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const requests = ref([])
const loading = ref(true)
const error = ref(null)

const loadRequests = async () => {
  try {
    const response = await carsService.getPurchaseRequests()

    requests.value = response.data.purchase_requests

  } catch (err) {
    error.value = t('purchaseRequests.error')
  } finally {
    loading.value = false
  }
}

const getImageUrl = (imagePath) => {

  if (!imagePath) {
    return ''
  }

  if (
    imagePath.startsWith('http://') ||
    imagePath.startsWith('https://')
  ) {
    return imagePath
  }

  return `http://127.0.0.1:8000/storage/${imagePath}`
}

onMounted(() => {
  loadRequests()
})
</script>