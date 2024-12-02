<script setup>
import MyHeader from "@/components/globals/MyHeader.vue";
import MyFooter from "@/components/globals/MyFooter.vue";
import {onMounted} from "vue";
import {useCatalogRoomsStore} from "@/stores/CatalogRoomsStore.js";

const {getRooms} = useCatalogRoomsStore()

onMounted(async () => {
  await getRooms()
})
</script>

<template>
<div class="bg-gray-100">
  <MyHeader/>
  <div class="container">
    <router-view class="py-8"></router-view>
  </div>
  <MyFooter/>
</div>
</template>

<style scoped>

</style>
