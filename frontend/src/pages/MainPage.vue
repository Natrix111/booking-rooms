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
            <h3 class="text-lg font-semibold mt-2">{{ room.name }}</h3>
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
            <p>"{{ review.text }}"</p>
            <p class="text-sm text-gray-500">— {{ review.author }}</p>
          </li>
        </ul>
      </section>

      <section class="mt-12">
        <h2>Контакты</h2>
        <div class="bg-white p-4">
          <p>Адрес: {{ contacts.address }}</p>
          <p>Режим работы: {{ contacts.schedule }}</p>
          <p>Телефон: {{ contacts.phone }}</p>
          <p>E-mail: {{ contacts.email }}</p>
        </div>
      </section>
    </div>
  </main>
</template>

<script setup>
const rooms = [
  { id: 1, name: "Комфорт", price: 1500, image: "/images/room1.jpg" },
  { id: 2, name: "Люкс", price: 2500 },
];

const reviews = [
  { id: 1, text: "Прекрасное место!", author: "Анна" },
  { id: 2, text: "Мой кот доволен!", author: "Иван" },
];

const contacts = {
  address: "ул. Ленина, д. 1",
  schedule: "Пн-Вс: 9:00 - 20:00",
  phone: "+7 (900) 123-45-67",
  email: "info@koteyka.ru",
};
</script>

<style scoped>
</style>
