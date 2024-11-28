<script setup>
import MyHeader from "@/components/globals/MyHeader.vue";
import MyFooter from "@/components/globals/MyFooter.vue";
import MainPage from "@/pages/MainPage.vue";
</script>

<template>
<div class="bg-gray-100">
  <MyHeader/>
  <div class="container">
    <MainPage/>
  </div>
  <MyFooter/>
</div>
</template>

<style scoped>

</style>
