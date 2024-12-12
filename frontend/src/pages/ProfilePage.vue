<script setup>
import ProfileForm from "@/components/form/ProfileForm.vue";
import CatalogProfileListItem from "@/components/catalogProfile/CatalogProfileListItem.vue";
import {useBookingStore} from "@/stores/booking-store.js";
import {storeToRefs} from "pinia";
import {onMounted} from "vue";

const {bookings} = storeToRefs(useBookingStore());
const { getBookings } = useBookingStore()

onMounted(() => getBookings())
</script>

<template>

  <main>
    <h2>Профиль</h2>
    <div>
      <profile-form/>
    </div>
    <div class="grid-list my-6">
      <CatalogProfileListItem
          v-for="(book, index) in bookings"
          :key="index"
          :id="book.id"
          :price="book.price"
          :title="book.title"
      />
    </div>


  </main>
</template>

<style scoped>
.grid-list {
  @apply grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6;
}
</style>