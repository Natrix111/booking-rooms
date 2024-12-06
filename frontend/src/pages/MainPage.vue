<template>
  <main>
    <div class="mx-auto">
      <section>
        <catalog-list :rooms="getRoomsMainPage">Популярные номера</catalog-list>
      </section>

      <section class="mt-12">
        <h2>Отзывы</h2>
        <ul class="space-y-4">
          <li
              v-for="review in reviews"
              :key="review.id"
              class="review-item"
          >
            <p>"{{ review.content }}"</p>
            <p class="review-author">— {{ review.author }}</p>
          </li>
        </ul>
      </section>

      <section class="mt-12">
        <h2>Контакты</h2>
        <div class="contacts-wrapper">
          <div class="contacts-details">
            <h3>Основные данные</h3>
            <p>Адрес: {{ contacts.address || 'Загрузка...' }}</p>
            <p>Режим работы: {{ contacts.working_hours || 'Загрузка...' }}</p>
            <p>Телефон: {{ contacts.phone || 'Загрузка...' }}</p>
            <p>E-mail: {{ contacts.email || 'Загрузка...' }}</p>
          </div>
          <div class="contacts-socials">
            <h3>Социальные сети</h3>
            <a
                class="social-link"
                v-for="(socialRef, socialName) in contacts.social_links"
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
import CatalogList from "@/components/catalogRooms/CatalogRoomsList.vue";

import {useCatalogRoomsStore} from "@/stores/catalog-rooms-store.js";
import {useMainInfoStore} from "@/stores/main-info-store.js";
import {storeToRefs} from "pinia";

const {getRoomsMainPage} = storeToRefs(useCatalogRoomsStore())
const {reviews, contacts} = storeToRefs(useMainInfoStore())

</script>

<style scoped>
.review-item {
  @apply bg-white p-4 hover:shadow-lg duration-300;
}

.review-author {
  @apply text-sm text-gray-500;
}

.contacts-wrapper {
  @apply bg-white p-4 grid grid-cols-2;
}

.contacts-details,
.contacts-socials {
  @apply flex flex-col space-y-1;
}

.social-link {
  @apply text-black;
}
</style>
