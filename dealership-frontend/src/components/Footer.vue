<script setup>
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
</script>
<template>
  <footer class="bg-dark text-light pt-5 pb-3">
    <div class="container">

      <div class="row">

        <!-- Company -->
        <div class="col-lg-4 col-md-6 mb-4">
          <h4 class="fw-bold">Dealership</h4>
          <p class="text-secondary">
           {{ t('footer.companyDescription') }}
          </p>
        </div>

        <!-- Quick Links -->
        <div class="col-lg-2 col-md-6 mb-4">
          <h5 class="fw-bold">
            {{ t('footer.quickLinks') }}
          </h5>

          <ul class="list-unstyled">
            <li class="mb-2">
              <RouterLink class="text-decoration-none text-secondary" to="/">
                {{ t('footer.home') }}
              </RouterLink>
            </li>

            <li class="mb-2">
              <RouterLink class="text-decoration-none text-secondary" to="/cars">
                {{ t('footer.cars') }}
              </RouterLink>
            </li>

            <li class="mb-2">
              <RouterLink class="text-decoration-none text-secondary" to="/about">
                {{ t('footer.about') }}
              </RouterLink>
            </li>

            <li class="mb-2">
              <RouterLink class="text-decoration-none text-secondary" to="/contact">
                 {{ t('footer.contact') }}
              </RouterLink>
            </li>
          </ul>
        </div>

        <!-- Contact -->
        <div class="col-lg-3 col-md-6 mb-4">
          <h5 class="fw-bold">{{ t('footer.contact') }}</h5>

          <p class="text-secondary mb-2">
            📍 Fes, Morocco
          </p>

          <p class="text-secondary mb-2">
            📞 +212 70 000 000
          </p>

          <p class="text-secondary">
            ✉ dealership@example.com
          </p>
        </div>

        <!-- Social -->
        <div class="col-lg-3 col-md-6 mb-4">
          <h5 class="fw-bold">
            {{ t('footer.followUs') }}
          </h5>

          <div class="d-flex gap-3 mt-3">

            <a href="#" class="text-light fs-4">
              <i class="bi bi-facebook"></i>
            </a>

            <a href="#" class="text-light fs-4">
              <i class="bi bi-instagram"></i>
            </a>

            <a href="#" class="text-light fs-4">
              <i class="bi bi-twitter-x"></i>
            </a>

            <a href="#" class="text-light fs-4">
              <i class="bi bi-linkedin"></i>
            </a>

          </div>
        </div>

      </div>

      <hr class="border-secondary">

      <div class="text-center text-secondary">
        © {{ new Date().getFullYear() }} Dealership. 
        {{ t('footer.allRightsReserved') }}
      </div>

    </div>
  </footer>
</template>

<script setup>
</script>

<style scoped>

footer {
  width: 100%;
}

a:hover {
  color: white !important;
  transition: 0.3s;
}

</style>
