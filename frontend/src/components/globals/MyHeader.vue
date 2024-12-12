<template>
  <header class="bg-blue-500 text-white py-4 px-10">
    <div class="mx-auto flex justify-between items-center">
      <div class="flex-grow">
        <router-link to="/">
          <h1 class="text-xl font-bold">{{ headerInfo.title }}</h1>
          <p>{{ headerInfo.slogan }}</p>
        </router-link>
      </div>
      <div class="flex space-x-20 flex-grow">
        <nav class="flex space-x-4 flex-grow">
          <router-link to="/">Главная</router-link>
          <router-link to="/rooms">Каталог</router-link>
          <a href="#contacts">Контакты</a>
        </nav>
        <div>
          <div v-if="!isAuth" class="flex space-x-4">
            <router-link to="/login">Вход</router-link>
            <router-link to="/register">Регистрация</router-link>
          </div>
          <div v-if="isAuth" class="flex space-x-4">
            <router-link to="/profile">Профиль</router-link>
            <router-link to="/rooms/create">Создать комнату</router-link>
            <button @click="logout">Выйти</button>
          </div>
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
import {useAuthStore} from '@/stores/auth-store';
import {storeToRefs} from "pinia";

const {isAuth} = storeToRefs(useAuthStore());
const {logout} = useAuthStore();
const {headerInfo} = storeToRefs(useMainInfoStore())

</script>

<style scoped>
button {
  transition: all .3s;
}

button:hover {
  color: #cacaca;
}
</style>
