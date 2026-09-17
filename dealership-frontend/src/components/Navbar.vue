<template>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">

    <div class="container-fluid">
     <div class="dealershipAdmin">
        <RouterLink
          class="navbar-brand"
          to="/admin/dashboard"
        >
        <i class="bi bi-car-front-fill"></i>
          {{ t('navbar.dealershipAdmin') }} 
        </RouterLink>

        <!-- Hamburger -->

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#adminNavbar"
          aria-controls="adminNavbar"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <!-- Menu -->

      <div class="collapse navbar-collapse" id="adminNavbar">

        <div class="navbar-nav ms-auto">

          <RouterLink
            class="nav-link"
            to="/"
          >
            {{ t('navbar.viewWebsite') }}
          </RouterLink>
           
           <!-- Language Dropdown -->
              <div class="nav-item dropdown ms-lg-2 mt-2 pt-2 mt-lg-0">

                  <button
                      class="language-btn dropdown-toggle"
                      type="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false"
                      :title="t('navbar.language')"
                  >
                      <i class="bi bi-globe"></i>

                      <span class="language-code">
                          {{ locale.toUpperCase() }}
                      </span>
                  </button>

                  <ul class="dropdown-menu dropdown-menu-end language-menu">

                      <!-- English -->
                      <li>
                          <button
                              type="button"
                              class="dropdown-item language-option"
                              :class="{ active: locale === 'en' }"
                              @click="changeLanguage('en')"
                          >
                              <span class="language-flag">🇬🇧</span>

                              <span class="language-name">
                                  {{ t('navbar.english') }}
                              </span>

                              <i
                                  v-if="locale === 'en'"
                                  class="bi bi-check2 language-check"
                              ></i>
                          </button>
                      </li>

                      <!-- French -->
                      <li>
                          <button
                              type="button"
                              class="dropdown-item language-option"
                              :class="{ active: locale === 'fr' }"
                              @click="changeLanguage('fr')"
                          >
                              <span class="language-flag">🇫🇷</span>

                              <span class="language-name">
                                  {{ t('navbar.french') }}
                              </span>

                              <i
                                  v-if="locale === 'fr'"
                                  class="bi bi-check2 language-check"
                              ></i>
                          </button>
                      </li>

                      <!-- Arabic -->
                      <li>
                          <button
                              type="button"
                              class="dropdown-item language-option"
                              :class="{ active: locale === 'ar' }"
                              @click="changeLanguage('ar')"
                          >
                              <span class="language-flag">🇲🇦</span>

                              <span class="language-name">
                                  {{ t('navbar.arabic') }}
                              </span>

                              <i
                                  v-if="locale === 'ar'"
                                  class="bi bi-check2 language-check"
                              ></i>
                          </button>
                      </li>

                  </ul>

              </div>
          <!--end of translation dropdown-->
          <!-- Admin User Dropdown -->

          <div class="nav-item dropdown ms-lg-2 mt-2 mt-lg-0">

            <a
              class="nav-link dropdown-toggle d-flex align-items-center justify-content-center gap-2 fixingpadding"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >

              <img
                v-if="authStore.user?.profile_picture"
                :src="getImageUrl(authStore.user.profile_picture)"
                alt="Profile"
                class="navbar-avatar"
              >

              <span
                v-else
                class="navbar-avatar default-avatar"
              >
                <i class="bi bi-person-fill"></i>
              </span>

              <span class="fixingmargin">
                {{ authStore.user?.name }}
              </span>

            </a>

            <ul class="dropdown-menu dropdown-menu-end">

              <li>
                <RouterLink
                  class="dropdown-item"
                  to="/profile"
                >
                  <i class="bi bi-person me-2"></i>
                  {{ t('navbar.myProfile') }}
                </RouterLink>
              </li>

              <li>
                <hr class="dropdown-divider">
              </li>

              <li>
                <button
                  class="dropdown-item text-danger"
                  @click="logout"
                >
                  <i class="bi bi-box-arrow-right me-2"></i>
                  {{ t('navbar.logout') }}
                </button>
              </li>

            </ul>

          </div>

        </div>

      </div>

    </div>

  </nav>

</template>


<script setup>

import { useRouter } from 'vue-router'
import authService from '../services/auth'
import { useAuthStore } from '../stores/auth'
import { useI18n } from 'vue-i18n'

const router = useRouter()
const authStore = useAuthStore()

const { t, locale } = useI18n()
/* Language change section*/
const changeLanguage = (language) => {
    /* saving the choosen language */
    locale.value = language
    localStorage.setItem('language', language)

    /* this is for changing the direction of the text  */ 
    document.documentElement.lang = language
    document.documentElement.dir = language === 'ar' ? 'rtl' : 'ltr'
}
/* end Language change section*/

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


const logout = async () => {

  try {

    await authService.logout()

  } catch (error) {

    console.log(error)

  }

  authStore.logout()

  router.push('/login')

}

</script>


<style scoped>

.navbar {
  z-index: 1030;
}

.navbar-avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  object-fit: cover;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.default-avatar {
  background-color: #6c757d;
  color: white;
  font-size: 18px;
}

.dropdown-menu {
  min-width: 180px;
}

.fixingpadding{
        padding-top: 4px;
}
.fixingmargin{
        margin-top: -3px;
}
.dealershipAdmin{
  margin-left: 60px;
}

@media (max-width: 991.98px) {

  .navbar-nav {
    text-align: center;
  }

  .navbar-avatar {
    width: 32px;
    height: 32px;
  }

}




/* ================================
   Language Selector
================================ */

.language-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.15);

    color: #adb5bd;

    padding: 6px 10px;

    border-radius: 8px;

    font-size: 0.85rem;
    font-weight: 500;

    line-height: 1;

    transition: all 0.2s ease;
}

.language-btn:hover,
.language-btn:focus,
.language-btn.show {
    color: #ffffff;
    background-color: rgba(255, 255, 255, 0.08);
    border-color: rgba(255, 255, 255, 0.25);

    box-shadow: none;
}

.language-btn i {
    font-size: 1rem;
}

.language-btn::after {
    margin-left: 2px;
    vertical-align: middle;
}


.language-code {
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}


/* Dropdown */

.language-menu {
    min-width: 190px;

    padding: 6px;

    margin-top: 8px !important;

    background-color: #ffffff;

    border: 1px solid #e9ecef;

    border-radius: 10px;

    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);

    animation: languageDropdown 0.15s ease-out;
}


@keyframes languageDropdown {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}


/* Language option */

.language-option {
    display: flex;
    align-items: center;

    width: 100%;

    padding: 9px 10px;

    border: none;

    border-radius: 7px;

    color: #343a40;

    background: transparent;

    font-size: 0.9rem;

    text-align: left;

    transition:
        background-color 0.15s ease,
        color 0.15s ease;
}

.language-option:hover {
    background-color: #f5f7fa;
    color: #212529;
}

.language-option.active {
    background-color: #eef5ff;
    color: #0d6efd;
    font-weight: 500;
}

.language-flag {
    width: 28px;
    margin-right: 8px;

    font-size: 1.15rem;

    text-align: center;
}

.language-name {
    flex: 1;
}

.language-check {
    font-size: 1rem;
    color: #0d6efd;
}





/* Flag */

.language-flag {
    width: 28px;

    font-size: 1.15rem;

    margin-right: 8px;

    text-align: center;
}


/* Language name */

.language-name {
    flex: 1;
}


/* Check icon */

.language-check {
    font-size: 1rem;

    color: #0d6efd;
}

</style>