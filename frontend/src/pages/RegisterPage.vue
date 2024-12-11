<template>
  <main>
    <section v-if="isAuth">
      <h2 class="text-center">Вы уже авторизованы</h2>
    </section>
    <section v-if="!isAuth">
      <h2 class="text-center">Регистрация</h2>
      <RegisterForm/>
    </section>
  </main>
</template>

<script setup>
import {storeToRefs} from "pinia";
import {useAuthStore} from '@/stores/auth-store';
import RegisterForm from "../components/form/RegisterForm.vue";

const {isAuth} = storeToRefs(useAuthStore());

</script>

<style scoped>
section {
  @apply bg-white shadow-lg p-6;
}
</style>
