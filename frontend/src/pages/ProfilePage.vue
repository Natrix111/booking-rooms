<script setup>
import {useAuthStore} from '@/stores/auth-store';
import {storeToRefs} from "pinia";
import {storageUrl} from "@/api/api.js";

const {user} = storeToRefs(useAuthStore());
</script>

<template>

  <main>
    <h2>Привет, {{user.name}}!</h2>
    <p>{{user.phone}}</p>
    <p>{{user.email}}</p>
    <img
        :src="`${storageUrl}${user.avatar}`"
        alt="Avatar">
  </main>

</template>

<style scoped>

</style>