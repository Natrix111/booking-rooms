<script setup>
import CatalogProfileListItem from "@/components/catalogProfile/CatalogProfileListItem.vue";
import {useProfileStore} from "@/stores/user-profile-store.js";
import {storeToRefs} from "pinia";
import {onMounted} from "vue";

const {Profile} = storeToRefs(useProfileStore());
const { getProfile } = useProfileStore()

onMounted(() => getProfile())
</script>

<template>

  <main>
    <h2 class="flex items-center">Профиль <router-link to="/profile/edit" class="text-xs text-blue-700 ml-10">Редактировать профиль</router-link> </h2>
    <div class="grid-list my-6">
      <CatalogProfileListItem
          v-for="(user, index) in Profile"
          :key="index"
          :booking_id ="user.booking_id"
          :room="user.room"
          :pets="user.pets"
          :check_in="user.check_in"
          :check_out="user.check_out"
          :approved="user.approved"
      />
    </div>


  </main>
</template>

<style scoped>
.grid-list {
  @apply grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6;
}
</style>