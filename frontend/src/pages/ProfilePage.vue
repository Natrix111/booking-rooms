<script setup>
import {useAuthStore} from '@/stores/auth-store';
import {storeToRefs} from "pinia";
import {storageUrl} from "@/api/api.js";

const {user} = storeToRefs(useAuthStore());
import ProfileForm from "@/components/form/ProfileForm.vue";
import CatalogProfileListItem from "@/components/catalogProfile/CatalogProfileListItem.vue";
</script>

<template>

  <main>
    <h2>Профиль</h2>
    <div>
      <profile-form />
    </div>
    <div class="grid-list my-6">
      <CatalogProfileListItem />
    </div>


  </main>
</template>

<style scoped>
.grid-list {
  @apply grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6;
}
</style>