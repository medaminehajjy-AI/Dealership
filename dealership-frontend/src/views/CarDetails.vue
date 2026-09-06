<template>
  <div class="container py-5">
  <nav> 
    <b>
      <RouterLink to="/" class="text-decoration-none">
        {{ t('carDetails.home') }}
      </RouterLink>
      >
      <span>{{ t('carDetails.details') }}</span>
    </b>
 </nav> <br>
 
    <!-- Loading -->
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status"></div>
      <p class="mt-3">{{ t('carDetails.loading') }}</p>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <!-- Car Details -->
    <div v-else-if="car">

      <div class="row">

        <!-- Car Image -->
        <div class="col-md-6">

             <!-- Main Image -->
            <div v-if="car.images?.length">
                <img
                :src="getImageUrl(selectedImage)"
                :alt="`${car.brand.name} ${car.model}`"
                class="img-fluid rounded w-100"
                style="height: 400px; object-fit: cover;"
                >

                <!-- Thumbnails -->
                <div class="d-flex gap-2 mt-3 flex-wrap">

                <img
                    v-for="image in car.images"
                    :key="image.id"
                    :src="getImageUrl(image.image)"
                    :alt="`${car.brand.name} ${car.model}`"
                    class="rounded"
                    style="width: 80px; height: 60px; object-fit: cover; cursor: pointer;"
                    @click="selectedImage = image.image"
                >

                </div>
            </div>

            <!-- No Image -->
            <div
                v-else
                class="bg-light p-5 text-center rounded"
            >
                {{ t('carDetails.noImage') }}
            </div>

        </div>

        <!-- Car Information -->
        <div class="col-md-6">

          <h1 class="mb-3">
            {{ car.brand.name }} {{ car.model }}
          </h1>

          <h3 class="text-primary mb-4">
            ${{ car.price }}
          </h3>

          <p>
            <strong>{{ t('carDetails.year') }}:</strong>
            {{ car.year }}
          </p>

          <p>
            <strong>{{ t('carDetails.mileage') }}:</strong>
            {{ car.mileage }} km
          </p>

          <p>
            <strong>{{ t('carDetails.fuelType') }}:</strong>
            {{ car.fuel_type }}
          </p>

          <p>
            <strong>{{ t('carDetails.transmission') }}:</strong>
            {{ car.transmission }}
          </p>

          <p>
            <strong>{{ t('carDetails.color') }}:</strong>
            {{ car.color }}
          </p>

          <p>
            <strong>{{ t('carDetails.category') }}:</strong>
            {{ car.category.name }}
          </p>

          <p>
            <strong>{{ t('carDetails.status') }}:</strong>
            {{ car.status }}
          </p>
            
          <!-- Favorite Button -->
            <div class="mt-4">

                <button
                    v-if="authStore.isAuthenticated"
                    class="btn btn-outline-danger"
                    :disabled="favoriteLoading"
                    @click="toggleFavorite"
                >
                    <span v-if="favoriteLoading">
                    {{ t('carDetails.saving') }}
                    </span>

                    <span v-else-if="isFavorite">
                    ♥ {{ t('carDetails.favorited') }}
                    </span>

                    <span v-else>
                    ♡ {{ t('carDetails.addToFavorites') }}
                    </span>
                </button>

                <p
                    v-else
                    class="text-muted"
                >
                   {{ t('carDetails.loginToFavorites') }}
                </p>

            </div>
          <hr>

          <h4>{{ t('carDetails.description') }}</h4>

          <p>
            {{ car.description }}
          </p>

        </div>

      </div>
      
        <!-- Purchase Request Form -->
         <div v-if="authStore.isAuthenticated" class="card mt-4">
            <div class="card-body">

                <h4 class="card-title mb-3">
                {{ t('carDetails.interested') }}
                </h4>

                <form @submit.prevent="submitPurchaseRequest">

                <div class="mb-3">
                    <label for="purchaseMessage" class="form-label">
                      {{ t('carDetails.message') }}
                    </label>

                    <textarea
                    id="purchaseMessage"
                    v-model="purchaseMessage"
                    class="form-control"
                    rows="4"
                    maxlength="1000"
                    :placeholder="t('carDetails.purchasePlaceholder')"
                    ></textarea>
                </div>

                <div
                    v-if="purchaseSuccess"
                    class="alert alert-success"
                >
                    {{ purchaseSuccess }}
                </div>

                <div
                    v-if="purchaseError"
                    class="alert alert-danger"
                >
                    {{ purchaseError }}
                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="purchaseLoading"
                >
                    <span v-if="purchaseLoading">
                    {{ t('carDetails.sending') }}
                    </span>

                    <span v-else>
                    {{ t('carDetails.requestPurchase') }}
                    </span>
                </button>

                </form>

            </div>
            </div>

            <div v-else class="alert alert-info mt-4">
            {{ t('carDetails.loginToPurchase') }}
            </div>  

                      <!-- Test Drive Booking Form -->
          <div v-if="authStore.isAuthenticated" class="card mt-4">
              <div class="card-body">

                  <h4 class="card-title mb-3">
                      {{ t('carDetails.bookTestDrive') }}
                  </h4>

                  <form @submit.prevent="submitBooking">

                      <!-- Date -->
                      <div class="mb-3">
                          <label for="bookingDate" class="form-label">
                              {{ t('carDetails.date') }}
                          </label>

                          <input
                              id="bookingDate"
                              v-model="bookingDate"
                              type="date"
                              class="form-control"
                              required
                          >
                      </div>

                      <!-- Time -->
                      <div class="mb-3">
                          <label for="bookingTime" class="form-label">
                              {{ t('carDetails.time') }}
                          </label>

                          <input
                              id="bookingTime"
                              v-model="bookingTime"
                              type="time"
                              class="form-control"
                              required
                          >
                      </div>

                      <!-- Message -->
                      <div class="mb-3">
                          <label for="bookingMessage" class="form-label">
                              {{ t('carDetails.message') }}
                          </label>

                          <textarea
                              id="bookingMessage"
                              v-model="bookingMessage"
                              class="form-control"
                              rows="4"
                              maxlength="1000"
                              :placeholder="t('carDetails.optionalMessage')"
                          ></textarea>
                      </div>

                      <!-- Success -->
                      <div
                          v-if="bookingSuccess"
                          class="alert alert-success"
                      >
                          {{ bookingSuccess }}
                      </div>

                      <!-- Error -->
                      <div
                          v-if="bookingError"
                          class="alert alert-danger"
                      >
                          {{ bookingError }}
                      </div>

                      <!-- Submit -->
                      <button
                          type="submit"
                          class="btn btn-primary"
                          :disabled="bookingLoading"
                      >
                          <span v-if="bookingLoading">
                              {{ t('carDetails.booking') }}
                          </span>

                          <span v-else>
                              {{ t('carDetails.bookTestDriveButton') }}
                          </span>
                      </button>

                  </form>

              </div>
          </div>

          <div v-else class="alert alert-info mt-4">
              {{ t('carDetails.loginToBooking') }}
          </div>
        
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import carsService from '../services/cars'
import { useAuthStore } from '../stores/auth' 
import bookingsService from '../services/bookings'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const route = useRoute()
const authStore = useAuthStore()


const car = ref(null)
const loading = ref(true)
const error = ref(null)
const selectedImage = ref(null)

const isFavorite = ref(false)
const favoriteLoading = ref(false)

const purchaseMessage = ref('')
const purchaseLoading = ref(false)
const purchaseSuccess = ref('')
const purchaseError = ref('')

const bookingDate = ref('')
const bookingTime = ref('')
const bookingMessage = ref('')
const bookingLoading = ref(false)
const bookingSuccess = ref('')
const bookingError = ref('')

const loadCar = async () => {
  try {
    const response = await carsService.getCar(route.params.id)

    car.value = response.data.car
    
    if (car.value.images?.length) {
         selectedImage.value = car.value.images[0].image
    }

  } catch (err) {
    error.value = t('carDetails.unableToLoad')
  } finally {
    loading.value = false
  }
}

const checkFavorite = async () => {
  if (!authStore.isAuthenticated) {
    return
  }

  try {
    const response = await carsService.checkFavorite(route.params.id)

    isFavorite.value = response.data.is_favorite

  } catch (err) {
    console.error('Unable to check favorite status.')
  }
}

const toggleFavorite = async () => {
  
        if (!authStore.isAuthenticated) {
        return
        }

        favoriteLoading.value = true

        try {
            if (isFavorite.value) {
            await carsService.removeFavorite(route.params.id)

            isFavorite.value = false
            } else {
            await carsService.addFavorite(route.params.id)

            isFavorite.value = true
            }
        } catch (err) {
            console.error('Unable to update favorite.')
        } finally {
            favoriteLoading.value = false
        }
        }

    const submitPurchaseRequest = async () => {
        purchaseLoading.value = true
        purchaseSuccess.value = ''
        purchaseError.value = ''

        try {
            const response = await carsService.submitPurchaseRequest(route.params.id,purchaseMessage.value)

            purchaseSuccess.value = response.data.message

            purchaseMessage.value = ''

        } catch (err) {
            if (err.response?.data?.message) {
            purchaseError.value = err.response.data.message
            } else {
            purchaseError.value = t('carDetails.unableToSubmitPurchase')
            }
        } finally {
            purchaseLoading.value = false
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


      const submitBooking = async () => {
            bookingLoading.value = true
            bookingSuccess.value = ''
            bookingError.value = ''

            try {
                const response = await bookingsService.submitBooking(
                      route.params.id,
                      {
                          booking_date: bookingDate.value,
                          booking_time: bookingTime.value,
                          message:      bookingMessage.value,
                      }
                  )

                bookingSuccess.value = response.data.message

                bookingDate.value = ''
                bookingTime.value = ''
                bookingMessage.value = ''

            } catch (err) {
                if (err.response?.data?.message) {
                    bookingError.value = err.response.data.message
                } else {
                    bookingError.value = t('carDetails.unableToBook')
                }
            } finally {
                bookingLoading.value = false
            }
        }


onMounted(async () => {
  await loadCar()
  await checkFavorite()
})
</script>