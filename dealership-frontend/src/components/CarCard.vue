<template>
  <div class="card h-100 shadow-sm">

    <img
      :src="getImageUrl(car.images?.[0]?.image)"
      class="card-img-top"
      :alt="car.brand?.name + ' ' + car.model"
      style="height: 220px; object-fit: cover;"
    />

    <div class="card-body">

      <h5 class="card-title">
        {{ car.brand?.name }} {{ car.model }}
      </h5>

      <p class="text-muted mb-2">
        {{ car.year }} • {{ car.mileage }} km
      </p>

      <p class="mb-2">
        {{ car.fuel_type }} • {{ car.transmission }}
      </p>

      <h5 class="text-primary">
        {{ Number(car.price).toLocaleString() }} MAD
      </h5>

      <span
        class="badge"
        :class="car.status === 'available'
          ? 'bg-success'
          : 'bg-danger'"
      >
        {{ car.status }}
      </span>

    </div>

    <div class="card-footer bg-white border-0">

      <RouterLink
        :to="`/cars/${car.id}`"
        class="btn btn-primary w-100"
      >
        {{ t('home.viewDetails') }}
      </RouterLink>

    </div>

  </div>
</template>

<script setup>
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

defineProps({
  car: {
    type: Object,
    required: true,
  },
})

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
</script>