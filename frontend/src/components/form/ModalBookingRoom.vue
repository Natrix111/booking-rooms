<template>
  <div
      @click="closeBookingModal"
      v-if="isBookingModalOpen"
      class="booking-modal"
  >
    <div @click.stop class="booking-modal-content">
      <h3 class="text-center mb-4">Бронирование номера</h3>
      <Form @submit="submitBookingForm" :validation-schema="bookingSchema" class="space-y-4">
        <div v-for="(pet, index) in pets" :key="index" class="space-y-4">
          <label>Имя питомца</label>
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
        <div v-if="Object.keys(errorsFromApi).length > 0">
          <p v-for="error in errorsFromApi" class="error">{{ error }}</p>
        </div>
        <div class="flex space-x-4 items-center">
          <my-button class="button-blue">Отправить заявку</my-button>
          <my-button @click.prevent="closeBookingModal" class="button-grey">
            Отмена
          </my-button>
          <LoadSpinner v-if="isLoadingBookingRooms" />
        </div>
      </Form>
    </div>
  </div>
</template>

<script setup>
import { Form, Field, ErrorMessage } from "vee-validate"
import { object, mixed } from "yup"
import { ref } from "vue";
import LoadSpinner from "@/components/UI/LoadSpinner.vue";
import MyButton from "@/components/UI/MyButton.vue";
import {bookingRooms} from "@/api/rooms.js";
import {useRoute} from "vue-router";

const isLoadingBookingRooms = ref(false)
const isBookingModalOpen = defineModel()
const booking = ref({ startDate: "", endDate: "" })

const pets = ref([{ name: "" }])
const petsErrors = ref([])
const errorsFromApi = ref([])

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

const closeBookingModal = () => {
  isBookingModalOpen.value = false
  resetForm()
}

const submitBookingForm = async () => {
  try {
    pets.value.forEach((pet, index) => validatePetName(pet.name, index))
    if(petsErrors.value.filter(error => error !== null).length > 0) return

    isLoadingBookingRooms.value = true

    const formData = {
      pets: pets.value.map(el => el.name),
      check_in: booking.value.startDate,
      check_out: booking.value.endDate,
      room_id: route.params.id,
    }

    const data = await bookingRooms(formData)
    closeBookingModal()

  } catch (error) {
    console.error(error)
    errorsFromApi.value = error.response?.data
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

  petsErrors.value[index] = errorMessage ? errorMessage : null
}

const resetForm = () => {
  pets.value = [{ name: "" }]
  petsErrors.value = []
  booking.value = { startDate: "", endDate: "" }
}
</script>

<style scoped>
.booking-modal {
  @apply fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center;
}

.booking-modal-content {
  @apply bg-white p-6 rounded shadow-lg w-1/2;
}

.error {
  @apply text-red-500 text-sm mt-1
}
</style>