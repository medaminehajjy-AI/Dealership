<template>
  <div class="container"><!-- py-5 is optional-->

    

    <div v-if="loading" class="text-center">
      <div class="spinner-border text-primary"></div>
      <p class="mt-2">{{ t('home.loading') }}</p>
    </div>

    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

     <div v-else>
       
        <!-- Latest Vehicles Carousel -->
          <LatestVehiclesCarousel
              :cars="latestCars"
              :loading="latestCarsLoading"
              :error="latestCarsError"
          />
        

        <div class="text-center mb-2">
          <h1 class="fw-bold"> {{ t('home.title') }}</h1>

          <p class="text-muted">
            {{ t('home.subtitle') }}
          </p>
        </div>

        <div class="row g-4">
            <div
                v-for="car in cars"
                :key="car.id"
                class="col-md-6 col-lg-4"
            >
                <CarCard :car="car" />
            </div>
        </div>

        <!-- Pagination -->
        <nav
            v-if="lastPage > 1"
            class="mt-5"
            aria-label="Cars pagination"
        >
            <ul class="pagination justify-content-center">

                <!-- Previous -->
                <li
                    class="page-item"
                    :class="{ disabled: currentPage === 1 }"
                >
                    <button
                        class="page-link"
                        :disabled="currentPage === 1"
                        @click="fetchCars(currentPage - 1)"
                    >
                        {{ t('pagination.previous') }}
                    </button>
                </li>

                <!-- Page numbers -->
                <li
                    v-for="page in lastPage"
                    :key="page"
                    class="page-item"
                    :class="{ active: currentPage === page }"
                >
                    <button
                        class="page-link"
                        @click="fetchCars(page)"
                    >
                        {{ page }}
                    </button>
                </li>

                <!-- Next -->
                <li
                    class="page-item"
                    :class="{ disabled: currentPage === lastPage }"
                >
                    <button
                        class="page-link"
                        :disabled="currentPage === lastPage"
                        @click="fetchCars(currentPage + 1)"
                    >
                        {{ t('pagination.next') }}
                    </button>
                </li>

            </ul>
        </nav>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import CarCard from '../components/CarCard.vue'
import LatestVehiclesCarousel from '../components/LatestVehiclesCarousel.vue'
import carsService from '../services/cars'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const cars = ref([])
const latestCars = ref([])

const loading = ref(true)
const error = ref(null)
const latestCarsLoading = ref(false)
const latestCarsError = ref(null)

/* pagination params */
const currentPage = ref(1)
const lastPage = ref(1)

const fetchCars = async (page = 1) => {
    loading.value = true
    error.value = null

    try {
        const response = await carsService.getCars({
            page: page
        })

        const pagination = response.data.cars

        cars.value = pagination.data
        currentPage.value = pagination.current_page
        lastPage.value = pagination.last_page
    } catch (err) {
        console.error(err)
        error.value = t('home.error')
    } finally {
        loading.value = false
    }
}

/* This is for the Carousel */
const fetchLatestCars = async () => {
    latestCarsLoading.value = true
    latestCarsError.value = null

    try {
        const response = await carsService.getLatestCars()

        latestCars.value = response.data.cars
    } catch (err) {
        console.error(err)
        latestCarsError.value = t('home.error')
    } finally {
        latestCarsLoading.value = false
    }
}

onMounted(() => {
  fetchCars()
  fetchLatestCars()
})
</script>