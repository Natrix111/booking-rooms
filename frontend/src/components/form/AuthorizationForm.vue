<script setup>
import {reactive} from "vue";
import {useAuthStore} from '@/stores/auth-store'
import {useRouter} from "vue-router";
import MyButton from "@/components/UI/MyButton.vue";
import {toast} from "vue3-toastify";

const router = useRouter()

const loginData = reactive({
  email: '',
  password: ''
})

const {getAuth} = useAuthStore()

</script>

<template>
  <form class="flex flex-col gap-5 items-center	"
        @submit.prevent="getAuth(loginData.email, loginData.password).then(async (bool) => {
          if (bool) {
            await router.push('/profile')
            toast.success('Вы успешно вошли в аккаунт!')
          }
        })">
    <input type="email" v-model="loginData.email" class="text-xl p-5 size-6/12 border rounded px-3 py-2">
    <input type="password" v-model="loginData.password" class="text-xl p-5 size-6/12 border rounded px-3 py-2">
    <my-button class="form-button">Войти</my-button>
  </form>
</template>

<style scoped>
.form-button {
  @apply p-2 text-2xl size-4/12 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600;
}
</style>