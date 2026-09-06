<template>
    <div class="container pb-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="mb-1">
                    {{ t('adminEditCar.title') }}
                </h2>

                <p class="text-muted mb-0">
                    {{ t('adminEditCar.description') }}
                </p>
            </div>

            <router-link
                to="/admin/cars"
                class="btn btn-secondary"
            >
                <i class="bi bi-arrow-left"></i>
                    {{ t('adminEditCar.back') }}
            </router-link>

        </div>


        <!-- Success message -->
        <div
            v-if="successMessage"
            class="alert alert-success"
        >
            {{ successMessage }}
        </div>


        <!-- Error message -->
        <div
            v-if="errorMessage"
            class="alert alert-danger"
        >
            {{ errorMessage }}
        </div>


        <div class="card shadow-sm">

            <div class="card-body">

                <form @submit.prevent="updateCar">


                    <div class="row">

                        <!-- Brand -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                {{ t('adminEditCar.brand') }}
                            </label>

                            <select
                                v-model="car.brand_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    {{ t('adminEditCar.selectBrand') }}
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
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                {{ t('adminEditCar.category') }}
                            </label>

                            <select
                                v-model="car.category_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    {{ t('adminEditCar.selectCategory') }}
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
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                {{ t('adminEditCar.model') }}
                            </label>

                            <input
                                v-model="car.model"
                                type="text"
                                class="form-control"
                                required
                            >

                        </div>


                        <!-- Year -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                {{ t('adminEditCar.year') }}
                            </label>

                            <input
                                v-model="car.year"
                                type="number"
                                class="form-control"
                                required
                            >

                        </div>


                        <!-- Price -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                {{ t('adminEditCar.price') }}
                            </label>

                            <input
                                v-model="car.price"
                                type="number"
                                step="0.01"
                                class="form-control"
                                required
                            >

                        </div>


                        <!-- Mileage -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                {{ t('adminEditCar.mileage') }}
                            </label>

                            <input
                                v-model="car.mileage"
                                type="number"
                                class="form-control"
                                required
                            >

                        </div>


                        <!-- Fuel -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                {{ t('adminEditCar.fuelType') }}
                            </label>

                            <select
                                v-model="car.fuel_type"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    {{ t('adminEditCar.selectFuelType') }}
                                </option>

                                <option value="Petrol">
                                    {{ t('adminEditCar.petrol') }}
                                </option>

                                <option value="Diesel">
                                    {{ t('adminEditCar.diesel') }}
                                </option>

                                <option value="Hybrid">
                                    {{ t('adminEditCar.hybrid') }}
                                </option>

                                <option value="Electric">
                                    {{ t('adminEditCar.electric') }}
                                </option>

                            </select>

                        </div>


                        <!-- Transmission -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                {{ t('adminEditCar.transmission') }}
                            </label>

                            <select
                                v-model="car.transmission"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    {{ t('adminEditCar.selectTransmission') }}
                                </option>

                                <option value="Automatic">
                                    {{ t('adminEditCar.automatic') }}
                                </option>

                                <option value="Manual">
                                    {{ t('adminEditCar.manual') }}
                                </option>

                            </select>

                        </div>


                        <!-- Color -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                {{ t('adminEditCar.color') }}
                            </label>

                            <input
                                v-model="car.color"
                                type="text"
                                class="form-control"
                                required
                            >

                        </div>


                        <!-- Status -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                {{ t('adminEditCar.status') }}
                            </label>

                            <select
                                v-model="car.status"
                                class="form-select"
                                required
                            >

                                <option value="available">
                                    {{ t('adminEditCar.available') }}
                                </option>

                                <option value="sold">
                                    {{ t('adminEditCar.sold') }}
                                </option>

                            </select>

                        </div>

                        <!-- Car Images -->
                    <div class="card shadow-sm mt-4">

                        <div class="card-body">

                            <h4 class="mb-3">
                                <i class="bi bi-images"></i>
                                {{ t('adminEditCar.carImages') }}
                            </h4>

                            <!-- Existing images -->
                            <div
                                v-if="carImages.length > 0"
                                class="row g-3 mb-4"
                            >

                                <div
                                    v-for="image in carImages"
                                    :key="image.id"
                                    class="col-md-4 col-lg-3"
                                >

                                    <div class="card h-100">

                                        <img
                                            :src="getImageUrl(image.image)"
                                            class="card-img-top"
                                            style="height: 180px; object-fit: cover;"
                                            alt="Car image"
                                        >

                                        <div class="card-body p-2">

                                            <button
                                                type="button"
                                                class="btn btn-danger btn-sm w-100"
                                                @click="deleteImage(image.id)"
                                            >
                                                <i class="bi bi-trash"></i>
                                                {{ t('adminEditCar.deleteImage') }}
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- No images -->
                            <div
                                v-else
                                class="alert alert-secondary"
                            >
                                {{ t('adminEditCar.noImages') }}
                            </div>


                            <!-- Upload -->
                            <div class="border rounded p-3">

                                <label class="form-label">
                                    {{ t('adminEditCar.addNewImage') }}
                                </label>

                                <input
                                    type="file"
                                    class="form-control"
                                    accept="image/jpeg,image/png,image/webp"
                                    @change="handleImageSelect"
                                >

                                <div
                                    v-if="selectedImage"
                                    class="mt-3"
                                >

                                    <p class="mb-2">
                                        {{ t('adminEditCar.selectedImage') }}
                                        <strong>{{ selectedImage.name }}</strong>
                                    </p>

                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        @click="uploadImage"
                                        :disabled="uploading"
                                    >

                                        <span v-if="uploading">
                                            {{ t('adminEditCar.uploading') }}
                                        </span>

                                        <span v-else>
                                            <i class="bi bi-upload"></i>
                                            {{ t('adminEditCar.uploadImage') }}
                                        </span>

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>


                        <!-- Description -->
                        <div class="col-12 mb-3">

                            <label class="form-label">
                                {{ t('adminEditCar.descriptionField') }}
                            </label>

                            <textarea
                                v-model="car.description"
                                class="form-control"
                                rows="5"
                            ></textarea>

                        </div>

                    </div>


                    <!-- Submit -->
                    <div class="d-flex justify-content-end">

                        <button
                            type="submit"
                            class="btn btn-primary"
                            :disabled="loading"
                        >

                            <span v-if="loading">
                                {{ t('adminEditCar.updating') }}
                            </span>

                            <span v-else>
                                <i class="bi bi-check-circle"></i>
                                {{ t('adminEditCar.updateCar') }}
                            </span>

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
</template>


<script setup>

import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

import carsService from '../../services/cars'


const route = useRoute()
const router = useRouter()


// Brand and category dropdowns
const brands = ref([])
const categories = ref([])


// Car form
const car = ref({
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
    status: '',
})


// UI state
const loading = ref(false)

const successMessage = ref('')

const errorMessage = ref('')


// Car images
const carImages = ref([])

const selectedImage = ref(null)

const uploading = ref(false)

// Load brands
const loadBrands = async () => {

    const response = await carsService.getBrands()

    brands.value = response.data.brands
}


// Load categories
const loadCategories = async () => {

    const response = await carsService.getCategories()

    categories.value = response.data.categories
}


// Load existing car
const loadCar = async () => {

    try {

        const response =
            await carsService.getAdminCar(route.params.id)

        car.value = {
            brand_id: response.data.brand_id,
            category_id: response.data.category_id,
            model: response.data.model,
            year: response.data.year,
            price: response.data.price,
            mileage: response.data.mileage,
            fuel_type: response.data.fuel_type,
            transmission: response.data.transmission,
            color: response.data.color,
            description: response.data.description,
            status: response.data.status,
        }
        carImages.value = response.data.images || []

    } catch (error) {

        console.error(error)

        errorMessage.value = t('adminEditCar.loadError')

    }
}


// Update car
const updateCar = async () => {

    loading.value = true

    errorMessage.value = ''
    successMessage.value = ''


    try {

        await carsService.updateCar(
            route.params.id,
            car.value
        )


        successMessage.value = t('adminEditCar.updatedSuccessfully')


        setTimeout(() => {

            router.push('/admin/cars')

        }, 1000)


    } catch (error) {

        console.error(error)


        if (error.response?.data?.errors) {

            errorMessage.value =
                Object.values(error.response.data.errors)
                    .flat()
                    .join(' ')

        } else {

            errorMessage.value = error.response?.data?.message || t('adminEditCar.updateError')

        }

    } finally {

        loading.value = false

    }
}


// Create the image URL
const getImageUrl = (imagePath) => {

    if (!imagePath) {
        return ''
    }

    // Existing external image URL
    if (
        imagePath.startsWith('http://') ||
        imagePath.startsWith('https://')
    ) {
        return imagePath
    }

    // Images stored by Laravel
    return `http://127.0.0.1:8000/storage/${imagePath}`
}

// Handle image selection
const handleImageSelect = (event) => {

    const file = event.target.files[0]

    if (!file) {
        return
    }

    selectedImage.value = file
}
// Upload the selected image
const uploadImage = async () => {

    if (!selectedImage.value) {
        return
    }

    uploading.value = true
    errorMessage.value = ''

    try {
       
        const response = await carsService.uploadCarImage(
            route.params.id,
            selectedImage.value
        )

        carImages.value.push(response.data.image)

        selectedImage.value = null

    } catch (error) {

        console.error(error)

        if (error.response?.data?.errors) {

            errorMessage.value =
                Object.values(error.response.data.errors)
                    .flat()
                    .join(' ')

        } else {

            errorMessage.value = error.response?.data?.message || t('adminEditCar.uploadError')
        }

    } finally {

        uploading.value = false
    }
}

    const deleteImage = async (imageId) => {

        try {

            await carsService.deleteCarImage(imageId)

            carImages.value = carImages.value.filter(
                image => image.id !== imageId
            )

        } catch (error) {

            console.error(error)

            errorMessage.value = error.response?.data?.message || t('adminEditCar.deleteImageError')
        }
    }


// Load everything when page opens
onMounted(async () => {

    try {

        await Promise.all([
            loadBrands(),
            loadCategories(),
            loadCar()
        ])

    } catch (error) {

        console.error(error)

        errorMessage.value = t('adminEditCar.pageLoadError')

    }

})

</script>