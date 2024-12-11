<script setup>
import {reactive} from "vue"

// const router = useRouter()
const changeData = reactive({
  email: '',
  password: ''
})
</script>

<template>
  <form class="flex flex-col gap-5 items-center" @submit.prevent="">
    <input v-model="changeData.email" type="email"  class="text-xl p-5 size-6/12 border rounded px-3 py-2">
    <input v-model="changeData.password" type="password"  class="text-xl p-5 size-6/12 border rounded px-3 py-2">
    <button class="form-button ">Редактировать</button>
  </form>
</template>

<style scoped>
.form-button {
  @apply p-2 text-2xl size-4/12 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600;
}
</style>