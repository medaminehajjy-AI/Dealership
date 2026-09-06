<template>

  <Navbar />

  <main class="content">
    <RouterView />
  </main>

  <Footer />

</template>

<script setup>
import Navbar from '@/views/Navbar.vue'
import Footer from '@/views/Footer.vue'
</script>

<style scoped>
.content{
  background-color: #f5f7fa;
}
</style>