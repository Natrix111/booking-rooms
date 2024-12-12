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
          <button @click="openBookingModal" class="button button-blue w-1/2">
            Забронировать
          </button>
        </div>
      </section>

      <section>
        <h2 class="mb-4">Другие номера</h2>
        <CatalogRoomsList :rooms="room.otherRooms" />
      </section>

      <div
          v-if="isBookingModalOpen"
          class="booking-modal"
      >
        <div class="bg-white p-6 rounded shadow-lg w-1/2">
          <h3 class="text-center mb-4">Бронирование номера</h3>
          <Form @submit="submitBookingForm" :validation-schema="bookingSchema" class="space-y-4">
            <div v-for="(pet, index) in pets" :key="index" class="space-y-4">
              <label>Имя питомца</label>
<!--              <Field-->
<!--                  v-model="pet.name"-->
<!--                  name="petName"-->
<!--                  placeholder="Имя питомца"-->
<!--                  class="input"-->
<!--              />-->
<!--              <ErrorMessage name="petName" class="error" />-->
              <input
                  v-model="pet.name"
                  type="text"
                  placeholder="Имя питомца"
                  @input="validatePetName(pet.name, index)"
                  class="input">
              <span v-if="petsErrors[index]" class="error">
                {{ petsErrors[index] }}
              </span>
            </div>
            <my-button @click.prevent="addPet" v-if="pets.length < 4" class="button-grey">
              Добавить питомца
            </my-button>
            <div class="space-y-4">
              <label for="startDate">Дата заезда</label>
              <Field
                  name="startDate"
                  type="date"
                  v-model="booking.startDate"
                  class="input"
              />
              <ErrorMessage name="startDate" class="error" />
            </div>
            <div class="space-y-4">
              <label for="endDate">Дата выезда</label>
              <Field
                  name="endDate"
                  type="date"
                  v-model="booking.endDate"
                  class="input"
              />
              <ErrorMessage name="endDate" class="error" />
            </div>
            <div class="flex space-x-4 items-center">
              <my-button class="button-blue">Отправить заявку</my-button>
              <my-button @click="closeBookingModal" class="button-grey">
                Отмена
              </my-button>
              <LoadSpinner v-if="isLoadingBookingRooms" />
            </div>
          </Form>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { Form, Field, ErrorMessage } from "vee-validate"
import { object, string, mixed } from "yup"
import { useCatalogRoomsStore } from "@/stores/catalog-rooms-store.js";
import { onMounted, ref, watch } from "vue";
import CatalogRoomsList from "@/components/catalogRooms/CatalogRoomsList.vue";
import { useRoute } from "vue-router";
import defaultPreview from "@/assets/image/catalogRooms/default-preview.jpg"
import {storageUrl} from "@/api/api.js";
import LoadSpinner from "@/components/UI/LoadSpinner.vue";
import MyButton from "@/components/UI/MyButton.vue";
import {bookingRooms} from "@/api/rooms.js";

const { getRoomById } = useCatalogRoomsStore();

const room = ref({});
const currentImage = ref('')
const isLoading = ref(true)
const isLoadingBookingRooms = ref(false)
const isBookingModalOpen = ref(false)
const booking = ref({ startDate: "", endDate: "" })

const pets = ref([{ name: "" }])
const petsErrors = ref([])

const route = useRoute()

const bookingSchema = object({
  startDate: mixed()
      .test("is-valid-date", "Дата заезда обязательна", (value) => {
        if (!value) return false
        const date = new Date(value)
        return !isNaN(date.getTime())
      })
      .test("is-after-today", "Дата заезда должна быть не раньше текущей", (value) => {
        if (!value) return false
        const date = new Date(value)
        return date >= new Date()
      }),
  endDate: mixed()
      .test("is-valid-date", "Дата выезда обязательна", (value) => {
        if (!value) return false
        const date = new Date(value)
        return !isNaN(date.getTime())
      })
      .test("is-after-start", "Дата выезда должна быть позже даты заезда", function (value) {
        const { startDate } = this.parent
        if (!value || !startDate) return false
        const start = new Date(startDate)
        const end = new Date(value)
        return end > start
      }),
})

const openBookingModal = () => {
  isBookingModalOpen.value = true
}

const closeBookingModal = () => {
  isBookingModalOpen.value = false
}

const submitBookingForm = async () => {
  try {
    if(petsErrors.length > 0) return
    isLoadingBookingRooms.value = true

    const formData = {
      pets: pets.value.map(el => el.name),
      check_in: booking.value.startDate,
      check_out: booking.value.endDate,
      room_id: route.params.id,
    }

    console.log("Booking form submitted", formData)
    const data = await bookingRooms(formData)
    console.log(data)

    closeBookingModal()

  } catch (error) {
    console.error(error.response.data)
  } finally {
    isLoadingBookingRooms.value = false
  }
}

const addPet = () => {
  if (pets.value.length < 4) pets.value.push({ name: "" })
}

const validatePetName = (value, index) => {
  const namePattern = /^[A-Za-zА-Яа-яёЁ\s-]+$/
  let errorMessage = null;

  if(!value) errorMessage = 'Имя питомца обязательно'
  else if(!namePattern.test(value)) errorMessage = 'Допустимы только буквы, пробелы и тире'

  petsErrors.value[index] = errorMessage
}

const loadRoomData = async () => {
  room.value = await getRoomById(route.params.id)
  currentImage.value = room.value.room.photos[0]
}

const setCurrentImage = (image) => {
  currentImage.value = image
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

.booking-modal {
  @apply fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center;
}

.error {
  @apply text-red-500 text-sm mt-1
}
</style>