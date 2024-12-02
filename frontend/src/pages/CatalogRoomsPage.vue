<template>
  <main>
    <div class="mx-auto flex">
      <aside class="w-1/4 bg-white p-4 mr-6">
        <h3 class="mb-4">Фильтры</h3>
        <form @submit.prevent="applyFilters" class="space-y-4">
          <div>
            <label for="minPrice">Минимальная цена</label>
            <input
                type="number"
                id="minPrice"
                v-model.number="filters.minPrice"
                :placeholder="filters.min_price"
                class="border rounded w-full px-3 py-2"
            />
          </div>
          <div>
            <label for="maxPrice">Максимальная цена</label>
            <input
                type="number"
                id="maxPrice"
                v-model.number="filters.maxPrice"
                :placeholder="filters.max_price"
                class="border rounded w-full px-3 py-2"
            />
          </div>
          <div>
            <h4 class="font-bold">Площадь номера</h4>
            <div class="space-y-2">
              <div v-for="area in filters.areas" :key="area">
                <label>
                  <input
                      type="checkbox"
                      :value="area"
                      class="mr-2"
                  />
                  {{ area }} м²
                </label>
              </div>
            </div>
          </div>
          <div>
            <h4 class="font-bold">Оснащение</h4>
            <div class="space-y-2">
              <div v-for="amenty in filters.amenities" :key="amenty">
                <label>
                  <input
                      type="checkbox"
                      :value="amenty"
                      class="mr-2"
                  />
                  {{ amenty }}
                </label>
              </div>
            </div>
          </div>
          <div class="flex flex-col space-y-4">
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
              Применить
            </button>
            <button
                type="reset"
                @click="resetFilters"
                class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300"
            >
              Сбросить фильтр
            </button>
          </div>
        </form>
      </aside>

      <section class="w-3/4">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold">Каталог номеров</h2>
          <select
              v-model="selectedSort"
              class="border rounded px-4 py-2"
          >
            <option value="priceAsc">Цена по возрастанию</option>
            <option value="priceDesc">Цена по убыванию</option>
          </select>
        </div>
        <CatalogRoomsList :rooms="sortedRooms"/>
      </section>
    </div>
  </main>
</template>

<script setup>
import {ref, computed, onMounted} from "vue";
import CatalogRoomsList from "@/components/catalogRooms/CatalogRoomsList.vue";
import {storeToRefs} from "pinia";
import {useCatalogRoomsStore} from "@/stores/CatalogRoomsStore.js";

const {rooms, filters} = storeToRefs(useCatalogRoomsStore())
const {getFilters} = useCatalogRoomsStore()

const selectedSort = ref("priceAsc")

const sortedRooms = computed(() => {
  if(selectedSort.value === "priceAsc") {
    return [...rooms.value].sort((a, b) => Number(a.price) - Number(b.price))
  }
  if(selectedSort.value === "priceDesc") {
    return [...rooms.value].sort((a, b) => Number(b.price) - Number(a.price))
  }
  return rooms.value
})

  onMounted(async () => {
  await getFilters()
})
</script>
