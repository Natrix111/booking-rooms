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
import axios from "axios";
import {onMounted, ref} from "vue";

const props = defineProps({
  isMainPage : {
    type: Boolean
  }
})

const rooms = ref([])

const getRooms = async () => {
  try {
    const {data} = await axios.get('http://localhost:8080/api/rooms')

    return data
  } catch (error) {
    console.error(error);
  }
}

onMounted(async () => {
  rooms.value = await getRooms()
})
</script>

<style scoped>
</style>