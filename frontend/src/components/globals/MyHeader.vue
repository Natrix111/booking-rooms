<template>
  <header class="bg-blue-500 text-white py-4 px-10">
    <div class="mx-auto flex justify-between items-center">
      <div class="flex-grow">
        <h1 class="text-xl font-bold">{{ mainIfo.title }}</h1>
        <p>{{ mainIfo.slogan }}</p>
      </div>
      <div class="flex space-x-20 flex-grow">
        <nav class="flex space-x-4 flex-grow">
          <router-link to="/">Главная</router-link>
          <router-link to="/catalog">Каталог</router-link>
          <a href="#">Контакты</a>
        </nav>
        <div class="flex space-x-4 ">
          <router-link to="/login">Вход</router-link>
          <router-link to="/register">Регистрация</router-link>
        </div>
        <div class="flex space-x-4">
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
