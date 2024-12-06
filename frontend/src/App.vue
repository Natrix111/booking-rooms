<script setup>
import MyHeader from "@/components/globals/MyHeader.vue";
import MyFooter from "@/components/globals/MyFooter.vue";
import {onMounted} from "vue";

import {useCatalogRoomsStore} from "@/stores/catalog-rooms-store.js";
import {useMainInfoStore} from "@/stores/main-info-store.js";

const {getRooms} = useCatalogRoomsStore()
const {getReviews, getContacts, getHeader} = useMainInfoStore()

onMounted(() => {
  getRooms()
  getReviews()
  getContacts()
  getHeader()
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
