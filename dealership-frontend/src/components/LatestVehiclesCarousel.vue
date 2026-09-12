<template>
    <div class="latest-vehicles">

        <!-- Section Title 
        <div class="text-center mb-2">
            <h2 class="fw-bold">
                {{ t('home.latestVehicles') }}
            </h2>

            <p class="text-muted">
                {{ t('home.latestVehiclesSubtitle') }}
            </p>
        </div>-->

        <!-- Loading -->
        <div
            v-if="loading"
            class="text-center py-5"
        >
            <div class="spinner-border text-primary"></div>
        </div>

        <!-- Error -->
        <div
            v-else-if="error"
            class="alert alert-danger"
        >
            {{ error }}
        </div>

        <!-- Empty -->
        <div
            v-else-if="cars.length === 0"
            class="alert alert-secondary text-center"
        >
            {{ t('home.noLatestVehicles') }}
        </div>

        <!-- Carousel -->
        <div
            v-else
            id="latestVehiclesCarousel"
            class="carousel slide"
            data-bs-ride="carousel"
        >

            <!-- Indicators -->
            <div class="carousel-indicators">

                <button
                    v-for="(car, index) in cars"
                    :key="`indicator-${car.id}`"
                    type="button"
                    data-bs-target="#latestVehiclesCarousel"
                    :data-bs-slide-to="index"
                    :class="{ active: index === 1 }"
                    :aria-current="index === 1 ? 'true' : undefined"
                    :aria-label="`${t('home.slide')} ${index + 1}`"
                ></button>

            </div>

            <!-- Slides -->
            <div class="carousel-inner">

                <div
                    v-for="(car, index) in cars"
                    :key="car.id"
                    class="carousel-item"
                    :class="{ active: index === 1 }"
                >

                    <router-link
                        :to="`/cars/${car.id}`"
                        class="text-decoration-none"
                    >

                           <img
                                v-if="car.images && car.images.length > 0"
                                :src="getImageUrl(car.images[0].image)"
                                :alt="`${car.brand?.name ?? ''} ${car.model}`"
                                class="d-block w-100 carousel-image"
                            >

                        <div
                            v-else
                            class="carousel-image d-flex align-items-center justify-content-center bg-light"
                        >
                            <span class="text-muted">
                                {{ t('home.noImage') }}
                            </span>
                        </div>

                        <!-- Caption -->
                        <div class="carousel-caption">
                            <div class="caption-content">

                                <h3 class="fw-bold mb-2">
                                    {{ car.brand?.name }} {{ car.model }}
                                </h3>

                                <p class="mb-0">
                                    {{ car.description }}
                                </p>

                            </div>
                        </div>

                    </router-link>

                </div>

            </div>

            <!-- Previous -->
            <button
                class="carousel-control-prev"
                type="button"
                data-bs-target="#latestVehiclesCarousel"
                data-bs-slide="prev"
            >
                <span
                    class="carousel-control-prev-icon"
                    aria-hidden="true"
                ></span>

                <span class="visually-hidden">
                    {{ t('pagination.previous') }}
                </span>
            </button>

            <!-- Next -->
            <button
                class="carousel-control-next"
                type="button"
                data-bs-target="#latestVehiclesCarousel"
                data-bs-slide="next"
            >
                <span
                    class="carousel-control-next-icon"
                    aria-hidden="true"
                ></span>

                <span class="visually-hidden">
                    {{ t('pagination.next') }}
                </span>
            </button>

        </div>
        <hr>
    </div>
</template>

<script setup>
import { useI18n } from 'vue-i18n'

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

defineProps({
    cars: {
        type: Array,
        default: () => []
    },

    loading: {
        type: Boolean,
        default: false
    },

    error: {
        type: String,
        default: null
    }
})

const { t } = useI18n()
</script>

<style scoped>
.latest-vehicles {
    margin-bottom: 2rem;
}

.carousel-image {
    height: 450px;
    object-fit: cover;
}

.carousel-caption {
    left: 0;
    right: 0;
    bottom: 0;
    padding: 0;
}

.caption-content {
    background: rgba(0, 0, 0, 0.65);
    padding: 1.5rem 4rem;
}

.carousel-caption h3,
.carousel-caption p {
    color: #fff;
}

.carousel-caption p {
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
}

@media (max-width: 768px) {
    .carousel-image {
        height: 300px;
    }

    .caption-content {
        padding: 1rem 3rem;
    }

    .carousel-caption h3 {
        font-size: 1.25rem;
    }

    .carousel-caption p {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .carousel-image {
        height: 250px;
    }

    .caption-content {
        padding: 0.75rem 2.5rem;
    }

    .carousel-caption h3 {
        font-size: 1rem;
    }

    .carousel-caption p {
        font-size: 0.8rem;
    }
}
</style>