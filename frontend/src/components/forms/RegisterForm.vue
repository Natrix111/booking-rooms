<script setup>
import {reactive, ref} from "vue";

const bigPenis = ref(40);

const model = reactive({
  name: '',
  tele: '',
  email: '',
  password: ''
})

const handleFileUpload = (event) => {
  event.preventDefault();

  console.log(event.target.files[0]);
}

const sendForm = () => {
  console.log(model);
  console.log(bigPenis.value)
}
</script>

<template>
  <form class="flex flex-col gap-5 px-10" @submit.prevent="sendForm">
    <input type="file" id="file" ref="file" @change="handleFileUpload"/>
    <input class="text-lg" v-model="model.name" type="text" placeholder="Введите Ваше имя">
    <input v-model="model.tele" type="text" placeholder="+X (XXX) XXX XX XX">
    <input v-model="model.email" type="email" placeholder="Ввелите Ваш e-mail">
    <input v-model="model.password" type="password" placeholder="Введите пароль">
    <button>Send</button>
  </form>
</template>

<style scoped>

</style>