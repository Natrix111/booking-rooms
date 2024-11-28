<template>
  <header class="bg-blue-500 text-white py-4 px-10">
    <div class="mx-auto flex justify-between items-center">
      <div>
        <h1 class="text-xl font-bold">{{ mainIfo.title }}</h1>
        <p>{{ mainIfo.slogan }}</p>
      </div>
      <div class="flex space-x-20">
        <nav class="flex space-x-4">
          <a href="/">Главная</a>
          <a href="/catalog">Каталог</a>
          <a href="#">Контакты</a>
        </nav>
        <div class="flex space-x-4">
          <a href="/">Вход / Регистрация</a>
          <p class="underline">{{ mainIfo.city }}</p>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";

const mainIfo = ref({
  title: 'Котейка',
  slogan: 'Слоган',
  city: 'Москва',
})

const getMainInfo = async () => {
  try {
    const { data } = await axios.get('http://localhost:8080/api/info')
    return data[0]
  }catch(error) {
    console.error(error)
  }
}

onMounted(async () => {
  mainIfo.value = await getMainInfo()
})
</script>

<style scoped>
</style>
