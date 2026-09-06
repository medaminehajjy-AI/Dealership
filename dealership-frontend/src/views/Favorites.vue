<template>
  <div class="container py-5">

    <h1 class="mb-4">
      {{ t('favorites.title') }}
    </h1>

    <!-- Loading -->
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status"></div>
      <p class="mt-3">
          {{ t('favorites.loading') }}
      </p>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <!-- Empty -->
    <div v-else-if="favorites.length === 0" class="text-center py-5">
      <h4>
          {{ t('favorites.emptyTitle') }}
      </h4>

      <p class="text-muted">
          {{ t('favorites.emptyText') }}
      </p>

      <router-link to="/cars" class="btn btn-primary">
          {{ t('favorites.browseCars') }}
      </router-link>
    </div>

    <!-- Favorites -->
    <div v-else class="row g-4">

      <div
        v-for="favorite in favorites"
        :key="favorite.id"
        class="col-md-6 col-lg-4"
      >

        <CarCard :car="favorite.car" />

      </div>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import carsService from '../services/cars'
import CarCard from '../components/CarCard.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const favorites = ref([])
const loading = ref(true)
const error = ref(null)

const loadFavorites = async () => {
  try {
    const response = await carsService.getFavorites()

    favorites.value = response.data.favorites

  } catch (err) {
    error.value = t('favorites.error')
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadFavorites()
})
</script>