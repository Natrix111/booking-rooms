<template>
  <header class="bg-blue-500 text-white py-4 px-10">
    <div class="mx-auto flex justify-between items-center">
      <div class="flex-grow">
        <h1 class="text-xl font-bold">{{ headerInfo.title }}</h1>
        <p>{{ headerInfo.slogan }}</p>
      </div>
      <div class="flex space-x-20 flex-grow">
        <nav class="flex space-x-4 flex-grow">
          <router-link to="/">Главная</router-link>
          <router-link to="/rooms">Каталог</router-link>
          <a href="#">Контакты</a>
        </nav>
        <div class="flex space-x-4 ">
          <router-link to="/login">Вход</router-link>
          <router-link to="/register">Регистрация</router-link>
        </div>
        <div class="flex space-x-4">
          <p class="underline">{{ headerInfo.city }}</p>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import {useMainInfoStore} from "@/stores/main-info-store.js";
import {storeToRefs} from "pinia";

const {headerInfo} = storeToRefs(useMainInfoStore())

</script>

<style scoped>
</style>
