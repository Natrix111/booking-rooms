<template>
  <article
      @click="$router.push(`/rooms/${room.id}`)"
      class="item">
      <img
          :src="room.photos[0] ? `${storageUrl}${props.room.photos[0]}` : defaultPreview"
          alt="Фото номера"
          class="item-image" />
    <div class="item-wrapper">
      <h3>{{ room.name }}</h3>
      <p>Цена: {{ room.price }} руб/сутки</p>
      <p>Площадь: {{ room.area }} м²</p>
      <div class="icons-wrapper">
        <img
            v-for="amenity in room.amenities"
            :key="amenity.name"
            :title="amenity.name"
            :src="`${storageUrl}${amenity.img}`"
            class="icon">
      </div>
    </div>
  </article>
</template>

<script setup>
import defaultPreview from "@/assets/image/catalogRooms/default-preview.jpg"
import {storageUrl} from "@/api/api.js";

const props = defineProps({
  room: {
    required: true,
    type: Object,
  }
})
</script>

<style scoped>
.item {
  @apply bg-white rounded hover:shadow-lg duration-300 cursor-pointer overflow-hidden;
}

.item-wrapper {
 padding: 0.5rem 1rem 1rem;
}

.item-image {
  @apply w-full h-40 object-cover;
}

.icons-wrapper {
  @apply flex items-center space-x-3 mt-1.5;
}

.icon {
  @apply h-6 w-6;
}
</style>