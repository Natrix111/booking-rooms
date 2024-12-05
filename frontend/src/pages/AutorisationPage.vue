<script setup>

import AutorisationForm from "@/components/form/AutorisationForm.vue";
console.log(localStorage.token)

const token = localStorage.token
</script>

<template>
  <main  class="rounded-2xl border-2 py-5 bg-white ">
    <div v-if="!token">
      <h2 class="text-center my-4">Авторизация</h2>

      <AutorisationForm />
    </div>
    <div>
      <h1 class="text-center my-4">Вы авторизованы</h1>
    </div>
  </main>
</template>

<style scoped>

</style>