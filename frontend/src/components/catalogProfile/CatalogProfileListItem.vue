<script setup>
import {useBookingStore} from "@/stores/booking-store.js";

defineProps({
  id: {
    type: Number,
    default: null
  },
  title: {
    type: String,
    default: ''
  },
  price: {
    type: Number,
    default: 0
  }
})

const { deleteBook } = useBookingStore()
</script>

<template>
  <article class="item">
    <h3>{{ title }}</h3>
    <p>Цена: {{ price }} </p>
    <button @click="deleteBook(id)">Удалить</button>
  </article>
</template>

<style scoped>
.item {
  @apply bg-white p-4 rounded hover:shadow-lg duration-300;
}
</style>