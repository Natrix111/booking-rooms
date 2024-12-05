<script setup>
import {reactive, ref} from "vue";
import axios from "axios";


const loginData = reactive({
  email: '',
  password: ''
})

const login = async () => {
  try {
    const {data} = await axios.post('http://localhost:8080/api/login', {
      email: loginData.email,
      password: loginData.password
    })

    localStorage.token = data.data.user_token;

    console.log(localStorage)

  } catch(error) {
    console.error(error)
  }
}




</script>

<template>
  <form  class="flex flex-col gap-5 items-center	" @submit.prevent="login">
    <input type="email" v-model="loginData.email" class="text-xl p-5 size-6/12 border rounded px-3 py-2">
    <input type="password" v-model="loginData.password" class="text-xl p-5 size-6/12 border rounded px-3 py-2">
    <button class="form-button ">Login</button>
  </form>
</template>

<style scoped>
.form-button {
  @apply  p-2 text-2xl size-4/12 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600;
}
</style>