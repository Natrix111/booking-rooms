<script setup>
import AuthorizationForm from "@/components/form/AuthorizationForm.vue";



// const token = localStorage.token
import { useAuthStore } from '@/stores/auth-store';
import { storeToRefs } from 'pinia';

const authStore = useAuthStore();

// Извлекаем свойства и методы через деструктуризацию
const { token, isAuth } = storeToRefs(authStore);
// const { setToken, clearToken } = authStore;

// // Логин
// function login() {
//   setToken('example-token'); // Устанавливаем токен
// }
//
// // Логаут
// function logout() {
//   clearToken(); // Удаляем токен
// }

</script>

<template>
  <main  class="rounded-2xl border-2 py-5 bg-white ">
    <div v-if="!isAuth">
      <h2 class="text-center my-4">Авторизация</h2>

      <AuthorizationForm />
    </div>
    <div v-if="isAuth" >
      <h1 class="text-center my-4">Вы авторизованы</h1>
    </div>
  </main>
</template>

<style scoped>

</style>