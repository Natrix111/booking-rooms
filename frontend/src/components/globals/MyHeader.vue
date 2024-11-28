<template>
  <header class="bg-blue-500 text-white py-4 px-10">
    <div class="mx-auto flex justify-between items-center">
      <div>
        <h1 class="text-xl font-bold">{{ headerData.siteName }}</h1>
        <p>{{ headerData.slogan }}</p>
      </div>
      <div class="flex space-x-20">
        <nav class="flex space-x-4">
          <a href="/">Главная</a>
          <a href="/catalog">Каталог</a>
          <a href="#">Контакты</a>
        </nav>
        <div class="flex space-x-4">
          <a href="/">Вход / Регистрация</a>
          <p class="underline">{{ headerData.city }}</p>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
const headerData = {
  siteName: "Котейка",
  city: "Томск",
  slogan: "Лучший отель для вашего питомца"
}
</script>

<style scoped>
</style>
