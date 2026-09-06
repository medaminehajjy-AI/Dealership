<script setup>
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
</script>

<template>
  <aside class="sidebar">

    <nav class="sidebar-nav">

      <!-- Section title -->
      <div class="nav-section-title">
        {{ t('adminSidebar.management') }}
      </div>


      <!-- Dashboard -->
      <RouterLink
        to="/admin/dashboard"
        class="nav-link"
      >
        <span class="nav-icon">
          <i class="bi bi-speedometer2"></i>
        </span>

        <span class="nav-text">
          {{ t('adminSidebar.dashboard') }}
        </span>
      </RouterLink>
      
      <!-- Statistics -->
      <RouterLink
        to="/admin/statistics"
        class="nav-link"
      >
        <span class="nav-icon">
          <i class="bi bi-bar-chart-line"></i>
        </span>

        <span class="nav-text">
          {{ t('adminSidebar.statistics') }}
        </span>
      </RouterLink>

      <!-- Cars -->
      <RouterLink
        to="/admin/cars"
        class="nav-link"
      >
        <span class="nav-icon">
          <i class="bi bi-car-front-fill"></i>
        </span>

        <span class="nav-text">
          {{ t('adminSidebar.cars') }}
        </span>
      </RouterLink>


      <!-- Customers -->
      <RouterLink
        to="/admin/customers"
        class="nav-link"
      >
        <span class="nav-icon">
          <i class="bi bi-people-fill"></i>
        </span>

        <span class="nav-text">
          {{ t('adminSidebar.customers') }}
        </span>
      </RouterLink>


      <!-- Purchase Requests -->
      <RouterLink
        to="/admin/purchase-requests"
        class="nav-link"
      >
        <span class="nav-icon">
          <i class="bi bi-clipboard-check-fill"></i>
        </span>

        <span class="nav-text">
          {{ t('adminSidebar.purchaseRequests') }}
        </span>
      </RouterLink>

      <!-- Bookings -->
      <RouterLink
        to="/admin/bookings"
        class="nav-link"
      >
        <span class="nav-icon">
          <i class="bi bi-calendar-check-fill"></i>
        </span>

        <span class="nav-text">
          {{ t('adminSidebar.testDriveBookings') }}
        </span>
      </RouterLink>

      <!-- Messages -->
      <RouterLink
        to="/admin/messages"
        class="nav-link"
      >
        <span class="nav-icon">
          <i class="bi bi-chat-dots-fill"></i>
        </span>

        <span class="nav-text">
          {{ t('adminSidebar.messages') }}
        </span>
      </RouterLink>


    </nav>


    <!-- Footer -->
    <div class="sidebar-footer">
       
      <!-- Account -->
      <div class="nav-section-title mt-4">
        {{ t('adminSidebar.account') }}
      </div>

      <RouterLink
        to="/profile"
        class="nav-link"
      >
        <span class="nav-icon">
          <i class="bi bi-person-circle"></i>
        </span>

        <span class="nav-text">
          {{ t('adminSidebar.profile') }}
        </span>
      </RouterLink>
      
      <small>
        {{ t('adminSidebar.administration') }}
      </small>
    </div>

  </aside>
</template>


<style scoped>

.sidebar {
  position: sticky;

  top: 0;

  width: 193px;
  min-width: 193px;
  max-width: 193px;

  min-height: calc(100vh - 70px);

  box-sizing: border-box;

  background: #111827;
  color: #ffffff;

  z-index: 1020;

  display: flex;
  flex-direction: column;

  overflow-y: auto;
  overflow-x: hidden;
}


/* =========================
   NAVIGATION
   ========================= */

.sidebar-nav {
  padding: 24px 12px;
}


/* Section title */

.nav-section-title {
  padding: 0 12px;
  margin-bottom: 10px;

  color: #6b7280;

  font-size: 11px;
  font-weight: 600;

  letter-spacing: 0.08em;
}


/* Navigation link */

.nav-link {
  display: flex;
  align-items: center;

  gap: 12px;

  width: 100%;

  box-sizing: border-box;

  padding: 11px 12px;
  margin-bottom: 4px;

  border-radius: 7px;

  color: #d1d5db;

  text-decoration: none;

  font-size: 14px;
  font-weight: 500;

  transition:
    background-color 0.15s ease,
    color 0.15s ease;
}


/* Hover */

.nav-link:hover {
  background: #1f2937;
  color: #ffffff;
}


/* Active */

.nav-link.router-link-active {
  background: #2563eb;
  color: #ffffff;
}


/* Icon */

.nav-icon {
  width: 22px;
  min-width: 22px;

  display: flex;
  align-items: center;
  justify-content: center;

  text-align: center;

  font-size: 18px;
}


/* Text */

.nav-text {
  white-space: nowrap;
}


/* =========================
   SIDEBAR FOOTER
   ========================= */

.sidebar-footer {
  margin-top: auto;

  padding: 18px 20px;

  border-top: 1px solid rgba(255, 255, 255, 0.08);

  color: #6b7280;
}


/* =========================
   MOBILE
   ========================= */

@media (max-width: 991.98px) {

  .sidebar {

    width: 70px !important;
    min-width: 70px !important;
    max-width: 70px !important;

    flex: 0 0 70px;

    min-height: calc(100vh - 70px);

    background: #111827;

    overflow-x: hidden;
  }


  /* Navigation */

  .sidebar-nav {
    padding: 15px 8px;
  }


  /* Hide MANAGEMENT */

  .nav-section-title {
    display: none;
  }


  /* Menu item */

  .nav-link {

    width: 54px;

    height: 54px;

    padding: 0;

    margin: 0 auto 8px auto;

    display: flex;

    align-items: center;
    justify-content: center;

    gap: 0;

    border-radius: 8px;
  }


  /* Hide text */

  .nav-text {
    display: none;
  }


  /* Icon */

  .nav-icon {

    width: 100%;
    min-width: 100%;

    display: flex;

    align-items: center;
    justify-content: center;

    font-size: 22px;
  }


  /* Hide footer */

  .sidebar-footer {
    display: none;
  }

}

</style>
