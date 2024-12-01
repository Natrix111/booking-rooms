<template>
  <h2><slot>Номера</slot></h2>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <CatalogListItem
        v-for="room in rooms"
        :key="room.id"
        :room="room"
        :isMainPage="isMainPage"/>
  </div>
</template>

<script setup>
import CatalogListItem from "@/components/catalogRooms/CatalogRoomsListItem.vue";

const props = defineProps({
  isMainPage : {
    type: Boolean
  }
})

const rooms = [
  { id: 1, name: "Комфорт", price: 1500, image: "/images/room1.jpg", mainPage: "true" },
  { id: 2, name: "Люкс", price: 2500 },
  { id: 3, name: "Люкс", price: 2200, mainPage: false },
  { id: 4, name: "Президентский", price: 15000, image: "/images/room2.jpg", mainPage: "true" },
  { id: 5, name: "Эконом", price: 500,  mainPage: "true" },
]
</script>

<style scoped>
</style>