<template>
  <h2><slot></slot></h2>
  <div class="grid-list">
    <CatalogListItem
        v-for="room in rooms"
        :key="room.id"
        :room="room"/>
  </div>
</template>

<script setup>
import CatalogListItem from "@/components/catalogRooms/CatalogRoomsListItem.vue";

const props = defineProps({
  rooms: {
    type: Array,
    required: true,
  },
})

</script>

<style scoped>

.grid-list {
  @apply grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6;
}

</style>