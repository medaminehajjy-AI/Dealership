<script setup>
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
</script>

<template>
    <div class="container py-5">

        <!-- Hero Section -->
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">
                {{ t('about.title') }}
            </h1>

            <p class="lead text-muted mt-3">
                {{ t('about.subtitle') }}
            </p>
        </div>

        <!-- Introduction -->
        <div class="row align-items-center mb-5">

            <div class="col-md-6">
                <h2 class="mb-3">
                    {{ t('about.trustedTitle') }}
                </h2>

                <p>
                    {{ t('about.trustedText1') }}
                </p>

                <p>
                    {{ t('about.trustedText2') }}
                </p>

                <p>
                    {{ t('about.trustedText3') }}
                </p>
            </div>

            <div class="col-md-6 mt-4 mt-md-0">
                <div class="bg-light rounded p-5 text-center">
                    <i class="bi bi-car-front display-1 text-primary"></i>

                    <h3 class="mt-3">
                        {{ t('about.qualityTitle') }}
                    </h3>
                </div>
            </div>

        </div>

        <!-- Why Choose Us -->
        <div class="mb-5">

            <div class="text-center mb-4">
                <h2>{{ t('about.whyChoose') }}</h2>

                <p class="text-muted">
                    {{ t('about.whyChooseSubtitle') }}
                </p>
            </div>

            <div class="row g-4">

                <!-- Quality Vehicles -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">

                            <i class="bi bi-car-front-fill display-5 text-primary"></i>

                            <h4 class="mt-3">
                                {{ t('about.qualityVehicles') }}
                            </h4>

                            <p class="text-muted">
                                {{ t('about.qualityVehiclesText') }}
                            </p>

                        </div>
                    </div>
                </div>

                <!-- Transparent Service -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">

                            <i class="bi bi-shield-check display-5 text-primary"></i>

                            <h4 class="mt-3">
                                {{ t('about.transparentService') }}
                            </h4>

                            <p class="text-muted">
                                {{ t('about.transparentServiceText') }}
                            </p>

                        </div>
                    </div>
                </div>

                <!-- Customer Support -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">

                            <i class="bi bi-headset display-5 text-primary"></i>

                            <h4 class="mt-3">
                                {{ t('about.customerSupport') }}
                            </h4>

                            <p class="text-muted">
                                {{ t('about.customerSupportText') }}
                            </p>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Mission & Vision -->
        <div class="row g-4 mb-5">

            <div class="col-md-6">
                <div class="card h-100 border-0 bg-light">
                    <div class="card-body p-4">

                        <h3>
                            <i class="bi bi-bullseye text-primary me-2"></i>
                            {{ t('about.mission') }}
                        </h3>

                        <p class="mt-3 mb-0">
                            {{ t('about.missionText') }}
                        </p>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 border-0 bg-light">
                    <div class="card-body p-4">

                        <h3>
                            <i class="bi bi-eye text-primary me-2"></i>
                            {{ t('about.vision') }}
                        </h3>

                        <p class="mt-3 mb-0">
                            {{ t('about.visionText') }}
                        </p>

                    </div>
                </div>
            </div>

        </div>

        <!-- Call To Action -->
        <div class="text-center bg-primary text-white rounded p-5">

            <h2>
                {{ t('about.findNextCar') }}
            </h2>

            <p class="lead mt-3">
                {{ t('about.findNextCarText') }}
            </p>

            <RouterLink
                to="/cars"
                class="btn btn-light btn-lg mt-2"
            >
                {{ t('about.browseCars') }}
            </RouterLink>

        </div>

    </div>
</template>

