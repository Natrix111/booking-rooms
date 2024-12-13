<script setup>
import {useProfileStore} from "@/stores/user-profile-store.js";
import {array} from "yup";

defineProps({
  booking_id: {
    type: Number,
    default: null
  },
  room: {
    type: String,
    default: ''
  },
  pets: {
    type: array,
    default: ''
  },
  check_in: {
    type: String,
    default: ''
  },
  check_out: {
    type: String,
    default: ''
  },
  approved: {
    type: Boolean,
    default: false
  }


})

const { deleteProfile } = useProfileStore()


</script>

<template>
  <article class="item">
    <h3>{{ room }}</h3>
    <p>питомцы: <p v-for="(pet, index) in pets" >{{++index}} {{ pet }}</p> </p>
    <p>Дата въезда: {{ check_in }}</p>
    <p>Дата выезда: {{ check_out }}</p>
    <button class="button button-blue" v-if="!approved" @click="deleteProfile(booking_id)">Удалить</button>
  </article>
</template>

<style scoped>
.item {
  @apply bg-white p-4 rounded hover:shadow-lg duration-300;
}
</style>