<template>
  <article class="item">
    <img :src="props.room.photos ? props.room.photos[0] : defaultPreview"
         alt="Фото номера"
         class="item-image" />
    <h3>{{ room.name }}</h3>
    <p>Цена: {{ room.price }} руб/сутки</p>
    <p>Площадь: {{ room.area }} м²</p>
    <p>Оснащение: {{ room.amenities.join(', ') }} </p>
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
.item {
  @apply bg-white p-4 rounded hover:shadow-lg duration-300;
}

.item-image {
  @apply w-full h-40 object-cover;
}
</style>