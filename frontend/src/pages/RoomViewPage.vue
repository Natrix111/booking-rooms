<template>
  <main  v-if="isLoading">
    <h2 class="text-center">Загрузка</h2>
    <LoadSpinner class="m-auto h-10 w-10" />
  </main>
  <main v-else>
    <div>
      <section class="room">
        <div class="w-full md:w-1/2">
          <div class="slider">
            <img
                :src="currentImage ? `${storageUrl}${currentImage}` : defaultPreview"
                class="current-image"
                alt="Main Image"
            />
            <div class="slider-items">
              <img
                  v-for="(image, index) in room.room.photos"
                  :key="index"
                  :src="`${storageUrl}${image}`"
                  :class="{ 'active-image': currentImage === image }"
                  @click="setCurrentImage(image)"
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
          <p title="Ширина х Длина х Высота">
            <strong>Размеры:</strong>
            {{ room.room.dimensions[0] }}х{{ room.room.dimensions[1] }}х{{ room.room.dimensions[2] }}
          </p>
          <p class="pb-2">
            <strong>Оснащение:</strong>
            <ul class="amenities-list">
              <li
                  v-for="amenity in room.room.amenities"
                  :key="amenity.name"
                  class="amenities-item"
              >
                <img
                    :title="amenity.name"
                    :src="`${storageUrl}${amenity.img}`"
                    class="icon"
                />
                <span>&nbsp;- {{ amenity.name }}</span>
              </li>
            </ul>
          </p>
          <my-button @click="openBookingModal" class="button-blue w-1/2">
            Забронировать
          </my-button>
        </div>
      </section>

      <section>
        <h2 class="mb-4">Другие номера</h2>
        <CatalogRoomsList :rooms="room.otherRooms" />
      </section>

      <ModalBookingRoom v-model="isBookingModalOpen" />
    </div>
  </main>
</template>

<script setup>
import { useCatalogRoomsStore } from "@/stores/catalog-rooms-store.js";
import { onMounted, ref, watch } from "vue";
import CatalogRoomsList from "@/components/catalogRooms/CatalogRoomsList.vue";
import { useRoute } from "vue-router";
import defaultPreview from "@/assets/image/catalogRooms/default-preview.jpg"
import {storageUrl} from "@/api/api.js";
import LoadSpinner from "@/components/UI/LoadSpinner.vue";
import MyButton from "@/components/UI/MyButton.vue";
import ModalBookingRoom from "@/components/form/ModalBookingRoom.vue";

const { getRoomById } = useCatalogRoomsStore();

const room = ref({});
const currentImage = ref('')
const isLoading = ref(true)
const isBookingModalOpen = ref(false)

const route = useRoute()

const loadRoomData = async () => {
  room.value = await getRoomById(route.params.id)
  currentImage.value = room.value.room.photos[0]
}

const setCurrentImage = (image) => {
  currentImage.value = image
}

const openBookingModal = () => {
  isBookingModalOpen.value = true
}

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
  @apply w-full h-96 object-contain rounded;
}

.slider-items {
  @apply grid grid-cols-5 gap-2 mt-1;
}

.image {
  @apply h-20 object-cover cursor-pointer border rounded hover:border-blue-500 duration-300;
}

.active-image {
  @apply border-blue-500;
}

.room-info {
  @apply flex flex-col space-y-2 md:w-1/2 pl-6;
}

.amenities-list {
  @apply flex flex-col space-y-2 ml-2 mt-1;
}

.amenities-item {
  @apply flex
}

.icon {
  @apply h-7 w-7;
}
</style>