<template>
  <main>
    <section v-if="isCreate">
      <h2 class="text-center">Номер успешно создан!</h2>
      <div class="button-list">
        <button @click="goToCreatedRoom" class="button button-blue">Просмотреть</button>
        <button @click="isCreate = false" class="button button-grey">Создать номер</button>
      </div>
    </section>
    <section v-else>
      <h2>Создание номера</h2>
      <form @submit.prevent='submitRoomForm' class='space-y-6'>
        <div>
          <label for='name'>Название</label>
          <input
              id='name'
              v-model='form.name'
              type='text'
              class='input'
              placeholder='Название номера'
          />
          <p v-if='errors.name' class='error'>{{ errors.name }}</p>
        </div>

        <div>
          <label>Размеры (Ширина x Длина x Высота)</label>
          <div class='flex space-x-4'>
            <input
                v-model.number='form.width'
                type='number'
                class='input'
                placeholder='Ширина'
            />
            <input
                v-model.number='form.length'
                type='number'
                class='input'
                placeholder='Длина'
            />
            <input
                v-model.number='form.height'
                type='number'
                class='input'
                placeholder='Высота'
            />
          </div>
          <p v-if='errors.dimensions' class='error'>{{ errors.dimensions }}</p>
        </div>

        <div>
          <label>Оснащение</label>
          <div class='flex flex-wrap gap-4'>
            <div v-for='amenity in filtersList.amenities' :key='amenity.id'>
                <input
                    type='checkbox'
                    :value='amenity.id'
                    v-model='form.amenities'
                />
                {{ amenity.name }}
            </div>
          </div>
        </div>

        <div>
          <label for='price'>Цена за сутки</label>
          <input
              id='price'
              v-model.number='form.price'
              type='number'
              class='input'
              placeholder='Цена'
          />
          <p v-if='errors.price' class='error'>{{ errors.price }}</p>
        </div>

        <div>
          <label for='photos'>Фото номера</label>
          <input
              id='photos'
              type='file'
              multiple
              accept='image/jpeg, image/png'
              class='input'
              @change='handlePhotoUpload'
          />
          <p class='text-sm text-gray-500 mt-1'>Можно загрузить до 5 фото, каждый не более 2 МБ</p>
          <p v-if='errors.photos' class='error'>{{ errors.photos }}</p>
          <div class='mt-4 flex gap-2'>
            <img
                v-for='(photo, index) in form.photos'
                :key='index'
                :src='photo.src'
                alt='Preview'
                class='w-20 h-20 object-cover rounded'
            />
          </div>
        </div>

        <div>
          <label class='flex items-center'>
            <input
                type='checkbox'
                v-model='form.featured'
                class='mr-2'
            />
            Отображать на главной
          </label>
        </div>

        <div class='flex space-x-4 items-center'>
          <my-button class="button-blue">Сохранить</my-button>
          <my-button @click='resetForm' class="button-grey">Сбросить</my-button>
          <LoadSpinner v-if="isLoading"/>
        </div>
      </form>
    </section>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import {storeToRefs} from 'pinia'
import {useCatalogRoomsStore} from '@/stores/catalog-rooms-store.js'
import {api} from "@/api/api.js";
import { useRouter } from 'vue-router'
import MyButton from "@/components/UI/MyButton.vue";
import LoadSpinner from "@/components/UI/LoadSpinner.vue";

const {filters: filtersList} = storeToRefs(useCatalogRoomsStore())
const {getRooms, getFilters} = useCatalogRoomsStore()

const form = ref({
  name: '',
  amenities: [],
  price: null,
  photos: [],
  width: null,
  height: null,
  length: null,
  featured: false
})

const errors = ref({})

const isLoading = ref(false)
const isCreate = ref(false)
const idCreatedRoom = ref(null)

const handlePhotoUpload = (event) => {
  errors.value.photos = ''
  const files = Array.from(event.target.files)

  if (files.length > 5) {
    errors.value.photos = 'Можно загрузить не более 5 фото.'
    event.target.value = ''
    form.value.photos = []

    return
  }

  const validFiles = files.filter((file) => file.size <= 2 * 1024 * 1024 && ['image/jpeg', 'image/png'].includes(file.type))

  if (validFiles.length !== files.length) {
    errors.value.photos = 'Некоторые файлы имеют недопустимый размер или формат.'
    event.target.value = ''
    form.value.photos = []

    return
  }

  validFiles.forEach((file) => file.src = URL.createObjectURL(file))
  form.value.photos = validFiles
}

const validateForm = () => {
  errors.value = {}
  if (!form.value.name) {
    errors.value.name = 'Название обязательно.'
  } else if (!/^[А-Яа-яЁё\s-]+$/.test(form.value.name)) {
    errors.value.name = 'Название должно содержать только кириллицу.'
  }

  if (!form.value.width || !form.value.height || !form.value.length) {
    errors.value.dimensions = 'Все размеры обязательны.'
  }

  if (!form.value.price || form.value.price <= 0) {
    errors.value.price = 'Цена обязательна и должна быть больше нуля.'
  }
  return Object.keys(errors.value).length === 0
}

const submitRoomForm = async () => {
  if (!validateForm()) return

  isLoading.value = 'true'

  const formData = new FormData()

  Object.entries(form.value).forEach(([key, value]) => {
    if (key === 'photos') {
      value.forEach((file) => {
        formData.append('photos[]', file)
      })
    } else if (key === 'amenities') {
      value.forEach((amenity) => {
        formData.append('amenities[]', amenity)
      })
    } else {
      console.log()
      formData.append(key, value)
    }
  })

  try {
    const {data} = await api.post('rooms', formData, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
        'Content-Type': 'multipart/form-data'
      }
    })

    await getRooms()

    idCreatedRoom.value = data.id

    isCreate.value = true
    resetForm()

  } catch (error) {
    console.error(error)
    isLoading.value = false
  } finally {
    isLoading.value = false
  }
}

const resetForm = () => {
  form.value = {
    name: '',
    amenities: [],
    price: null,
    photos: [],
    width: null,
    height: null,
    length: null,
    featured: false
  }

  errors.value = {}
}

const router = useRouter()

const goToCreatedRoom = () => {
  isCreate.value = false
  router.push(`/rooms/${idCreatedRoom.value}`)
}

onMounted(async () => {
  await getFilters()
})
</script>

<style scoped>
section {
  @apply bg-white shadow-lg p-6;
}

label {
  @apply block mb-2
}

.error {
  @apply text-red-500 text-sm mt-1
}

.button-list {
  @apply flex justify-center space-x-2 mt-6;
}
</style>
