<template> 
  <div class="container-fluid pb-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

      <div>
        <h1>{{ t('adminCars.title') }}</h1>

        <p class="text-muted">
            {{ t('adminCars.description') }}
        </p>
      </div>

      <router-link
        to="/admin/cars/create"
        class="btn btn-primary"
      >
        <i class="bi bi-plus-lg"></i>
           {{ t('adminCars.addCar') }}
      </router-link>

    </div>

    <!-- Loading -->
    <div
      v-if="loading"
      class="text-center py-5"
    >
      <div class="spinner-border text-primary"></div>

      <p class="mt-3">
          {{ t('adminCars.loading') }}
      </p>
    </div>

    <!-- Error -->
    <div
      v-else-if="error"
      class="alert alert-danger"
    >
      {{ error }}
    </div>

    <!-- Cars -->
    <div
      v-else
      class="card shadow-sm"
    >

      <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

          <thead class="table-light">

            <tr>
              <th>{{ t('adminCars.id') }}</th>
              <th>{{ t('adminCars.image') }}</th>
              <th>{{ t('adminCars.car') }}</th>
              <th>{{ t('adminCars.category') }}</th>
              <th>{{ t('adminCars.year') }}</th>
              <th>{{ t('adminCars.price') }}</th>
              <th>{{ t('adminCars.status') }}</th>
              <th>{{ t('adminCars.actions') }}</th>
            </tr>

          </thead>

          <tbody>

            <tr
              v-for="car in cars"
              :key="car.id"
            >

              <td>
                {{ car.id }}
              </td>

              <td>

                <img
                  v-if="car.images?.[0]?.image"
                  :src="getImageUrl(car.images[0].image)"
                  :alt="car.model"
                  width="90"
                  height="60"
                  class="rounded"
                  style="object-fit: cover;"
                >

                <span
                  v-else
                  class="text-muted"
                >
                  {{ t('adminCars.noImage') }}
                </span>

              </td>

              <td>

                <strong>
                  {{ car.brand?.name }}
                  {{ car.model }}
                </strong>

                <br>

                <small class="text-muted">
                  {{ car.color }}
                </small>

              </td>

              <td>
                {{ car.category?.name }}
              </td>

              <td>
                {{ car.year }}
              </td>

              <td>
                ${{ Number(car.price).toLocaleString() }}
              </td>

              <td>

                <span
                  class="badge"
                  :class="{
                    'bg-success': car.status === 'available',
                    'bg-danger': car.status === 'sold',
                    'bg-warning text-dark': car.status === 'reserved'
                  }"
                >
                      {{
                          car.status === 'available'
                              ? t('adminCars.available')
                              : car.status === 'reserved'
                                  ? t('adminCars.reserved')
                                  : car.status === 'sold'
                                      ? t('adminCars.sold')
                                      : car.status
                      }}
                </span>

              </td>

              <td>

                <router-link
                    :to="`/admin/cars/${car.id}/edit`"
                    class="btn btn-sm btn-warning"
                >
                    <i class="bi bi-pencil"></i>
                      {{ t('adminCars.edit') }}
                </router-link>
                  |
                <button
                        @click="deleteCar(car.id)"
                        class="btn btn-sm btn-danger"
                    >
                        <i class="bi bi-trash"></i>
                          {{ t('adminCars.delete') }}
                </button>
                |
                <router-link
                  :to="`/cars/${car.id}`"
                  class="btn btn-sm btn-outline-secondary"
                >
                  <i class="bi bi-eye"></i>
                </router-link>

              </td>

            </tr>

          </tbody>

        </table>

      </div>

    </div>


    <!-- Pagination -->
    <nav
      v-if="lastPage > 1"
      class="mt-4"
      aria-label="Admin cars pagination"
    >

      <ul class="pagination justify-content-center">

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

  </div>

</template>



<style scoped>

</style>


<script setup>
import { ref, onMounted } from 'vue'
import carsService from '../../services/cars'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const cars = ref([])
const loading = ref(true)
const error = ref(null)

const currentPage = ref(1)
const lastPage = ref(1)

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

    const baseUrl = import.meta.env.VITE_API_URL.replace('/api', '')

    return `${baseUrl}/storage/${imagePath}`
}

const loadCars = async (page = 1) => {
  loading.value = true
  error.value = null

  try {
    const response = await carsService.getAdminCars({
      page: page
    })

    const pagination = response.data.cars

    cars.value = pagination.data
    currentPage.value = pagination.current_page
    lastPage.value = pagination.last_page

  } catch (err) {
    console.error(err)

    error.value = t('adminCars.loadError')

  } finally {
    loading.value = false
  }
}
/* this for pagination */
const changePage = (page) => {

  if (page < 1 || page > lastPage.value) {
    return
  }

  loadCars(page)
}


const deleteCar = async (id) => {

    const confirmed = confirm(
        t('adminCars.deleteConfirmation')
    )

        if (!confirmed) {
            return
        }

        try {

            await carsService.deleteCar(id)

            await loadCars(currentPage.value)

        } catch (error) {

            console.error(error)

            alert(
                error.response?.data?.message ||
                t('adminCars.deleteError')
            )
        }
    }

onMounted(() => {
  loadCars()
})
</script>