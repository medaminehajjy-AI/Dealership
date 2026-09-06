<template>
        <div class="container-fluid pb-4">
            <div class="mb-4">
                <h1>{{ t('adminCreateCar.title') }}</h1>

                <p class="text-muted">
                    {{ t('adminCreateCar.description') }}
                </p>
            </div>

            <div class="card shadow-sm">
            <div class="card-body">

                <form @submit.prevent="createCar">

                <div class="row g-3">

                    <!-- Brand -->
                    <div class="col-md-6">
                    <label class="form-label">
                        {{ t('adminCreateCar.brand') }}
                    </label>

                    <select
                        v-model="form.brand_id"
                        class="form-select"
                        required
                    >
                        <option value="">
                            {{ t('adminCreateCar.selectBrand') }}
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
                    <div class="col-md-6">
                    <label class="form-label">
                        {{ t('adminCreateCar.category') }}
                    </label>

                    <select
                        v-model="form.category_id"
                        class="form-select"
                        required
                    >
                        <option value="">
                            {{ t('adminCreateCar.selectCategory') }}
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

                    <!-- Model -->
                    <div class="col-md-6">
                    <label class="form-label">
                        {{ t('adminCreateCar.model') }}
                    </label>

                    <input
                        v-model="form.model"
                        type="text"
                        class="form-control"
                        required
                    >
                    </div>

                    <!-- Year -->
                    <div class="col-md-6">
                    <label class="form-label">
                         {{ t('adminCreateCar.year') }}
                    </label>

                    <input
                        v-model="form.year"
                        type="number"
                        class="form-control"
                        required
                    >
                    </div>

                    <!-- Price -->
                    <div class="col-md-6">
                    <label class="form-label">
                        {{ t('adminCreateCar.price') }}
                    </label>

                    <input
                        v-model="form.price"
                        type="number"
                        class="form-control"
                        required
                    >
                    </div>

                    <!-- Mileage -->
                    <div class="col-md-6">
                    <label class="form-label">
                        {{ t('adminCreateCar.mileage') }}
                    </label>

                    <input
                        v-model="form.mileage"
                        type="number"
                        class="form-control"
                        required
                    >
                    </div>

                    <!-- Fuel -->
                    <div class="col-md-6">
                    <label class="form-label">
                         {{ t('adminCreateCar.fuelType') }}
                    </label>

                    <select
                        v-model="form.fuel_type"
                        class="form-select"
                        required
                    >
                        <option value="">
                            {{ t('adminCreateCar.selectFuelType') }}
                        </option>

                        <option value="Petrol">
                            {{ t('adminCreateCar.petrol') }}
                        </option>

                        <option value="Diesel">
                            {{ t('adminCreateCar.diesel') }}
                        </option>

                        <option value="Hybrid">
                            {{ t('adminCreateCar.hybrid') }}
                        </option>

                        <option value="Electric">
                            {{ t('adminCreateCar.electric') }}
                        </option>
                    </select>
                    </div>

                    <!-- Transmission -->
                    <div class="col-md-6">
                    <label class="form-label">
                        {{ t('adminCreateCar.transmission') }}
                    </label>

                    <select
                        v-model="form.transmission"
                        class="form-select"
                        required
                    >
                        <option value="">
                            {{ t('adminCreateCar.selectTransmission') }}
                        </option>

                        <option value="Automatic">
                            {{ t('adminCreateCar.automatic') }}
                        </option>

                        <option value="Manual">
                            {{ t('adminCreateCar.manual') }}
                        </option>
                    </select>
                    </div>

                    <!-- Color -->
                    <div class="col-md-6">
                    <label class="form-label">
                        {{ t('adminCreateCar.color') }}
                    </label>

                    <input
                        v-model="form.color"
                        type="text"
                        class="form-control"
                        required
                    >
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                    <label class="form-label">
                        {{ t('adminCreateCar.status') }}
                    </label>

                    <select
                        v-model="form.status"
                        class="form-select"
                        required
                    >
                        <option value="available">
                            {{ t('adminCreateCar.available') }}
                        </option>

                        <option value="reserved">
                            {{ t('adminCreateCar.reserved') }}
                        </option>

                        <option value="sold">
                            {{ t('adminCreateCar.sold') }}
                        </option>
                    </select>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                    <label class="form-label">
                        {{ t('adminCreateCar.descriptionField') }}
                    </label>

                    <textarea
                        v-model="form.description"
                        class="form-control"
                        rows="5"
                    ></textarea>
                    </div>

                </div>

                <!-- Error -->
                <div
                    v-if="error"
                    class="alert alert-danger mt-4"
                >
                    {{ error }}
                </div>

                <!-- Buttons -->
                <div class="mt-4">

                    <button
                    type="submit"
                    class="btn btn-primary me-2"
                    :disabled="loading"
                    >
                    {{ loading ? t('adminCreateCar.creating') : t('adminCreateCar.createCar') }}
                    </button>

                    <router-link
                    to="/admin/cars"
                    class="btn btn-secondary"
                    >
                       {{ t('adminCreateCar.cancel') }}
                    </router-link>

                </div>

                </form>

            </div>
            </div>

        </div>

</template>

<style scoped>

</style>

  


<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import carsService from '../../services/cars'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const router = useRouter()

const brands = ref([])
const categories = ref([])

const loading = ref(false)
const error = ref(null)

const form = ref({
  brand_id: '',
  category_id: '',
  model: '',
  year: '',
  price: '',
  mileage: '',
  fuel_type: '',
  transmission: '',
  color: '',
  description: '',
  status: 'available',
})

const loadFormData = async () => {
  try {
    const [brandsResponse, categoriesResponse] =
      await Promise.all([
        carsService.getBrands(),
        carsService.getCategories(),
      ])

    brands.value = brandsResponse.data.brands
    categories.value = categoriesResponse.data.categories

  } catch (err) {
    error.value = t('adminCreateCar.loadError')
  }
}

const createCar = async () => {
  loading.value = true
  error.value = null

  try {
    await carsService.createCar(form.value)

    router.push('/admin/cars')

  } catch (err) {
    if (err.response?.data?.message) {
      error.value = err.response.data.message
    } else {
      error.value = t('adminCreateCar.createError')
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadFormData()
})
</script>