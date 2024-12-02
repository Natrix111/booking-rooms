<template>
  <article class="bg-white p-4 hover:shadow-lg duration-300">
    <img :src="props.room.photos ? props.room.photos[0] : defaultPreview"
         alt="Фото номера"
         class="w-full h-40 object-cover" />
    <h3>{{ props.room.name }}</h3>
    <p>Цена: {{ props.room.price }} руб/сутки</p>
  </article>
</template>

<script setup>
import defaultPreview from "@/assets/image/catalogRooms/default-preview.jpg"

const props = defineProps({
  room: {
    required: true,
    type: Object,
  }
})
</script>

<style scoped>
</style>