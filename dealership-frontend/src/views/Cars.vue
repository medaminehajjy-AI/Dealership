<template>
  <div class="container py-5">

    <!-- Page Header -->
    <div class="text-center mb-2">
      <h1 class="fw-bold">{{ t('cars.title') }}</h1>

      <p class="text-muted">
        {{ t('cars.subtitle') }}
      </p>
    </div>


    <!-- Filters -->
    <div class="card shadow-sm mb-4">

      <div class="card-body py-3">
          <!-- Header -->
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0">
              {{ t('cars.searchFilter') }}
            </h5>
          </div>

          <div class="row g-2 align-items-end">

            <!-- Search -->
            <div class="col-lg-3 col-md-6">
              <label class="form-label small mb-1">
                {{ t('cars.searchModel') }}
              </label>

              <input
                v-model="filters.search"
                type="text"
                class="form-control form-control-sm"
                :placeholder="t('cars.searchModelPlaceholder')"
              >
            </div>

            <!-- Brand -->
            <div class="col-lg-2 col-md-6">
              <label class="form-label small mb-1">
                {{ t('cars.brand') }}
              </label>

              <select
                v-model="filters.brand_id"
                class="form-select form-select-sm"
              >
                <option value="">
                  {{ t('cars.allBrands') }}
                </option>

                <option
                  v-for="brand in brands"
                  :key="brand.id"
                  :value="brand.id"
                >
                  {{ brand.name }}
                </option>
              </select>
            </div>

            <!-- Category -->
            <div class="col-lg-2 col-md-6">
              <label class="form-label small mb-1">
                {{ t('cars.category') }}
              </label>

              <select
                v-model="filters.category_id"
                class="form-select form-select-sm"
              >
                <option value="">
                  {{ t('cars.allCategories') }}
                </option>

                <option
                  v-for="category in categories"
                  :key="category.id"
                  :value="category.id"
                >
                  {{ category.name }}
                </option>
              </select>
            </div>

            <!-- Fuel -->
            <div class="col-lg-2 col-md-6">
              <label class="form-label small mb-1">
                {{ t('cars.fuelType') }}
              </label>

              <select
                v-model="filters.fuel_type"
                class="form-select form-select-sm"
              >
                <option value="">
                  {{ t('cars.allFuelTypes') }}
                </option>

                <option value="Petrol">
                  {{ t('cars.petrol') }}
                </option>

                <option value="Diesel">
                  {{ t('cars.diesel') }}
                </option>

                <option value="Hybrid">
                  {{ t('cars.hybrid') }}
                </option>

                <option value="Electric">
                  {{ t('cars.electric') }}
                </option>
              </select>
            </div>

            <!-- Transmission -->
            <div class="col-lg-2 col-md-6">
              <label class="form-label small mb-1">
                {{ t('cars.transmission') }}
              </label>

              <select
                v-model="filters.transmission"
                class="form-select form-select-sm"
              >
                <option value="">
                  {{ t('cars.allTransmissions') }}
                </option>

                <option value="Automatic">
                  {{ t('cars.automatic') }}
                </option>

                <option value="Manual">
                  {{ t('cars.manual') }}
                </option>
              </select>
            </div>

            <!-- Min Price -->
            <div class="col-lg-2 col-md-6">
              <label class="form-label small mb-1">
                {{ t('cars.minPrice') }}
              </label>

              <input
                v-model="filters.min_price"
                type="number"
                class="form-control form-control-sm"
                :placeholder="t('cars.minPricePlaceholder')"
              >
            </div>

            <!-- Max Price -->
            <div class="col-lg-2 col-md-6">
              <label class="form-label small mb-1">
                {{ t('cars.maxPrice') }}
              </label>

              <input
                v-model="filters.max_price"
                type="number"
                class="form-control form-control-sm"
                :placeholder="t('cars.maxPricePlaceholder')"
              >
            </div>

            <!-- Buttons -->
            <div class="col-lg-3 col-md-6">
              <div class="d-flex gap-2">
                <button
                  @click="applyFilters"
                  class="btn btn-primary btn-sm flex-grow-1"
                  :disabled="loading"
                >
                  <span v-if="loading">
                    {{ t('cars.searching') }}
                  </span>

                  <span v-else>
                    {{ t('cars.search') }}
                  </span>
                </button>

                <button
                  @click="resetFilters"
                  class="btn btn-outline-secondary btn-sm"
                >
                  {{ t('cars.reset') }}
                </button>
              </div>
            </div>

          </div>

      </div>

    </div>

    <!-- Loading -->
    <div
      v-if="loading"
      class="text-center py-5"
    >
      <div class="spinner-border text-primary"></div>

      <p class="mt-3">
          {{ t('cars.loading') }}
      </p>
    </div>


    <!-- Error -->
    <div
      v-else-if="error"
      class="alert alert-danger"
    >
      {{ error }}
    </div>


    <!-- Results -->
    <div v-else>

      <div
        v-if="cars.length"
        class="row g-4"
      >

        <div
          v-for="car in cars"
          :key="car.id"
          class="col-md-6 col-lg-4"
        >
          <CarCard :car="car" />
        </div>

      </div>


      <!-- No Results -->
      <div
        v-else
        class="text-center py-5"
      >
        <h4>
            {{ t('cars.noCars') }}
        </h4>

        <p class="text-muted">
            {{ t('cars.noCarsMessage') }}
        </p>
      </div>


          <!-- Pagination -->
          <nav
            v-if="lastPage > 1 && cars.length"
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
                  @click="changePage(currentPage - 1)"
                >
                  {{ t('pagination.previous') }}
                </button>
              </li>


              <!-- Page Numbers -->
              <li
                v-for="page in lastPage"
                :key="page"
                class="page-item"
                :class="{ active: currentPage === page }"
              >
                <button
                  class="page-link"
                  @click="changePage(page)"
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
                  @click="changePage(currentPage + 1)"
                >
                  {{ t('pagination.next') }}
                </button>
              </li>

            </ul>

          </nav>
          <!-- end Pagination -->

    </div>

  </div>
</template>


<script setup>

import { ref, onMounted } from 'vue'
import CarCard from '../components/CarCard.vue'
import carsService from '../services/cars'
import api from '../services/api'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const cars = ref([])
const brands = ref([])
const categories = ref([])

const loading = ref(true)
const error = ref(null)

const currentPage = ref(1)
const lastPage = ref(1)

const filters = ref({

  search: '',
  brand_id: '',
  category_id: '',
  fuel_type: '',
  transmission: '',
  min_price: '',
  max_price: ''

})


const loadBrands = async () => {

  try {

    const response = await api.get('/brands')

    brands.value = response.data.brands

  } catch (err) {

    console.error(err)

  }

}


const loadCategories = async () => {

  try {

    const response = await api.get('/categories')

    categories.value = response.data.categories

  } catch (err) {

    console.error(err)

  }

}


const loadCars = async (params = {}) => {

  loading.value = true
  error.value = null

  try {

    const response = await carsService.getCars(params)
    /* applying the pagination */
    const pagination = response.data.cars

    cars.value = pagination.data
    currentPage.value = pagination.current_page
    lastPage.value = pagination.last_page

  } catch (err) {

    console.error(err)

    error.value = t('cars.error')

  } finally {

    loading.value = false

  }

}
/* this the continuation of the pagination ,its task to avoid losing the user filter  */
const changePage = (page) => {

  if (page < 1 || page > lastPage.value) {
    return
  }

  const params = {}

  Object.keys(filters.value).forEach(key => {

    if (filters.value[key] !== '') {
      params[key] = filters.value[key]
    }

  })

  params.page = page

  loadCars(params)

}


const applyFilters = () => {

  const params = {}

  Object.keys(filters.value).forEach(key => {

    if (filters.value[key] !== '') {

      params[key] = filters.value[key]

    }

  })

  params.page = 1

  loadCars(params)

}


const resetFilters = () => {

  filters.value = {

    search: '',
    brand_id: '',
    category_id: '',
    fuel_type: '',
    transmission: '',
    min_price: '',
    max_price: ''

  }

  loadCars({ page: 1 })

}


onMounted(() => {

  loadBrands()
  loadCategories()
  loadCars()

})

</script>
