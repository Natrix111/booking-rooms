<template>
  <main class="min-h-screen">
    <div class="mx-auto py-8">
      <section>
        <h2>Популярные номера</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
              v-for="room in rooms"
              :key="room.id"
              class="bg-white p-4 hover:shadow-lg duration-300"
          >
            <img :src="room.image ? room.image : '/images/placeholder.jpg'" alt="Номер" class="w-full h-40 object-cover" />
            <h3>{{ room.name }}</h3>
            <p>Цена: {{ room.price }} руб/сутки</p>
          </div>
        </div>
      </section>

      <section class="mt-12">
        <h2>Отзывы</h2>
        <ul class="space-y-4">
          <li
              v-for="review in reviews"
              :key="review.id"
              class="bg-white p-4 hover:shadow-lg duration-300"
          >
            <p>"{{ review.content }}"</p>
            <p class="text-sm text-gray-500">— {{ review.author }}</p>
          </li>
        </ul>
      </section>

      <section class="mt-12">
        <h2>Контакты</h2>
        <div class="bg-white p-4 grid grid-cols-2">
          <div class="flex flex-col space-y-1">
            <h3>Основные данные</h3>
            <p>Адрес: {{ contacts.address || 'Загрузка...' }}</p>
            <p>Режим работы: {{ contacts.working_hours || 'Загрузка...' }}</p>
            <p>Телефон: {{ contacts.phone || 'Загрузка...' }}</p>
            <p>E-mail: {{ contacts.email || 'Загрузка...' }}</p>
          </div>
          <div class="flex flex-col space-y-1">
            <h3>Социальные сети</h3>
            <a
                class="text-black"
                v-for="[socialName, socialRef] in socials"
                :key="socialRef"
                :href="socialRef"
                target="_blank"
            >{{ socialName }}</a>
          </div>
        </div>
      </section>
    </div>
  </main>
</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from 'axios'

const rooms = [
  { id: 1, name: "Комфорт", price: 1500, image: "/images/room1.jpg" },
  { id: 2, name: "Люкс", price: 2500 },
]

const reviews = ref([])

const getReviews = async () => {
  try {
    const {data} = await axios.get('http://localhost:8080/api/reviews')
    reviews.value = data
        console.log(reviews)

  }catch (error) {

  }
}

const contacts = ref({})
const socials = ref([])

const getContacts = async () => {
  try {
    const {data} = await axios.get('http://localhost:8080/api/contact')
    contacts.value = data[0]

    socials.value = Object.entries(JSON.parse(data[0].social_links))
  } catch (error) {
    console.error(error);
  }
}

onMounted(async () => {
  await getContacts()
  await getReviews()
})

</script>

<style scoped>
</style>
