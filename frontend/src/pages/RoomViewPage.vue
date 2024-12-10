<template>
  <h2
      v-if="isLoading"
      class="text-center">Загрузка....</h2>
  <main v-else>
    <div>
      <section class="room">
        <div class="w-full md:w-1/2">
          <div class="slider">
            <img
                :src="room.room.photos[0] ?`${storageUrl}${room.room.photos[0]}` : defaultPreview"
                class="current-image">
            <div class="slider-items">
              <img
                  v-for="image in room.room.photos"
                  :src="`${storageUrl}${image}`"
                  alt="Room Image"
                  class="image"
              />
            </div>
          </div>
        </div>
        <div class="room-info">
          <h2 class="mb-2">{{ room.room.name }}</h2>
          <p><strong>Цена:</strong> {{ room.room.price }} руб/сутки</p>
          <p><strong>Площадь:</strong> {{ room.room.area }} м²</p>
          <p title="Ширина х Длина х Высота"><strong>Размеры:</strong> {{ room.room.dimensions[0] }}х{{room.room.dimensions[1]}}х{{room.room.dimensions[2]}}</p>
          <p class="pb-2">
            <strong>Оснащение: </strong>
            <span v-for="(amenity, index) in room.room.amenities" :key="index">
              {{ amenity.name }}<span v-if="index < room.room.amenities.length - 1">, </span>
            </span>
          </p>
          <button class="button button-blue w-1/2 mt-8">Забронировать</button>
        </div>
      </section>

      <section>
        <h2 class="mb-4">Другие номера</h2>
        <CatalogRoomsList :rooms="room.otherRooms"/>
      </section>
    </div>

  </main>
</template>

<script setup>
import { useCatalogRoomsStore } from "@/stores/catalog-rooms-store.js";
import { onMounted, ref, watch } from "vue";
import CatalogRoomsList from "@/components/catalogRooms/CatalogRoomsList.vue";
import { useRoute } from "vue-router";
import defaultPreview from "@/assets/image/catalogRooms/default-preview.jpg"

const { getRoomById } = useCatalogRoomsStore();

const storageUrl = import.meta.env.VITE_API_STORAGE

const room = ref({});
const isLoading = ref(true)

const route = useRoute();

const loadRoomData = async () => {
  room.value = await getRoomById(route.params.id);
};

onMounted(async () => {
  isLoading.value = true;

  await loadRoomData();

  isLoading.value = false;

});

watch(() => route.params.id,
    async () => {
      isLoading.value = true;
      await loadRoomData();
      isLoading.value = false;
    }
);
</script>

<style scoped>
.room {
  @apply flex flex-wrap md:flex-nowrap bg-white p-6 mb-8;
}

.current-image {
  @apply w-full h-96 object-contain;
}

.slider-items {
  @apply grid grid-cols-4 gap-4;
}

.image {
  @apply h-16 object-cover;
}

.room-info {
  @apply flex flex-col space-y-2 md:w-1/2 pl-6;
}
</style>