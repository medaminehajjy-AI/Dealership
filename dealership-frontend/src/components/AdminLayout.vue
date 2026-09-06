<template>
  <div class="admin-page">

    <!-- Navbar -->
    <Navbar />

    <!-- Admin area -->
    <div class="admin-layout">

      <!-- Sidebar -->
      <Sidebar />

      <!-- Main content -->
      <main class="admin-content">
        <RouterView />
      </main>

    </div>

    <!-- Footer -->
    <Footer />

  </div>
</template>

<script setup>
import Navbar from './Navbar.vue'
import Sidebar from './Sidebar.vue'
import Footer from './Footer.vue'
</script>

<style scoped>

.admin-page {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

/* Sidebar + Content */
.admin-layout {
  display: flex;
  flex: 1;
  min-width: 0;
  align-items: stretch;
}

/* Main content */
.admin-content {
  flex: 1;
  min-width: 0;
  padding: 30px;
  background: #ffffff;
}

/* Mobile */
@media (max-width: 991.98px) {

  .admin-layout {
    display: flex;
    flex-direction: row;
    align-items: stretch;
  }

  .admin-content {
    flex: 1;
    min-width: 0;
    padding: 20px 15px;
  }

}

</style>
