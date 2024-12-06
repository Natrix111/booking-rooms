<template>
  <main>
    <div class="flex">
      <aside class="aside">
        <h3 class="mb-4">Фильтры</h3>
        <form @submit.prevent="applyFilters" class="space-y-4">
          <div>
            <label for="minPrice">Минимальная цена</label>
            <input
                type="number"
                id="minPrice"
                v-model.number="selectedFilters.minPrice"
                :placeholder="filtersList.min_price"
                class="input"
            />
          </div>
          <div>
            <label for="maxPrice">Максимальная цена</label>
            <input
                type="number"
                id="maxPrice"
                v-model.number="selectedFilters.maxPrice"
                :placeholder="filtersList.max_price"
                class="input"
            />
          </div>
          <div>
            <h4 class="font-bold mb-2">Площадь номера</h4>
            <div class="space-y-2">
              <div v-for="area in filtersList.areas" :key="area">
                <label>
                  <input
                      type="checkbox"
                      :value="area"
                      v-model="selectedFilters.areas"
                      class="mr-2"
                  />
                  {{ area }} м²
                </label>
              </div>
            </div>
          </div>
          <div>
            <h4 class="font-bold mb-2">Оснащение</h4>
            <div class="space-y-2">
              <div v-for="amenty in filtersList.amenities" :key="amenty">
                <label>
                  <input
                      type="checkbox"
                      :value="amenty"
                      v-model="selectedFilters.amenities"
                      class="mr-2"
                  />
                  {{ amenty }}
                </label>
              </div>
            </div>
          </div>
          <div class="buttons-list">
            <button
                type="submit"
                class="button button-blue"
            >
              Применить
            </button>
            <button
                type="reset"
                @click="resetFilters"
                class="button button-grey"
            >
              Сбросить фильтр
            </button>
          </div>
        </form>
      </aside>

      <section class="w-3/4">
        <div class="rooms-title-wrapper">
          <h2 class="font-bold">Каталог номеров</h2>
          <select
              v-model="selectedSort"
              class="sort-select"
          >
            <option value="priceAsc">Цена по возрастанию</option>
            <option value="priceDesc">Цена по убыванию</option>
          </select>
        </div>
        <CatalogRoomsList :rooms="sortedAndFilteredRooms"/>
      </section>
    </div>
  </main>
</template>

<script setup>
import {ref, computed, onMounted} from "vue";
import CatalogRoomsList from "@/components/catalogRooms/CatalogRoomsList.vue";
import {storeToRefs} from "pinia";
import {useCatalogRoomsStore} from "@/stores/catalog-rooms-store.js";

const {rooms, filters: filtersList} = storeToRefs(useCatalogRoomsStore())
const {getFilters} = useCatalogRoomsStore()

const selectedFilters = ref({
  minPrice: null,
  maxPrice: null,
  areas: [],
  amenities: [],
});

const appliedFilters = ref({...selectedFilters.value})

const selectedSort = ref("priceAsc")

const sortedRooms = computed(() => {
  switch (selectedSort.value) {
    case "priceAsc":
      return [...rooms.value].sort((a, b) => Number(a.price) - Number(b.price));
    case "priceDesc":
      return [...rooms.value].sort((a, b) => Number(b.price) - Number(a.price));
    default:
      return rooms.value;
  }
});

const sortedAndFilteredRooms = computed(() => {
  return sortedRooms.value
      .filter((room) => {
        if (appliedFilters.value.minPrice && room.price < appliedFilters.value.minPrice) return false

        if (appliedFilters.value.maxPrice && room.price > appliedFilters.value.maxPrice) return false

        if (appliedFilters.value.areas.length > 0 && !appliedFilters.value.areas.includes(room.area)) return false

        if (appliedFilters.value.amenities.length > 0 && !appliedFilters.value.amenities.every(feature => room.amenities.includes(feature))) return false

        return true
      })
})

const applyFilters = () => {
  appliedFilters.value = {...selectedFilters.value}
}

const resetFilters = () => {
  selectedFilters.value = {
    minPrice: null,
    maxPrice: null,
    areas: [],
    amenities: [],
  }

  applyFilters()
}

onMounted(async () => {
  await getFilters()
})
</script>

<style scoped>
.aside {
  @apply w-1/4 bg-white p-4 mr-6;
}

.buttons-list {
  @apply flex flex-col space-y-4;
}

.rooms-title-wrapper {
  @apply flex justify-between items-center mb-6
}

.sort-select {
  @apply border rounded px-4 py-2
}
</style>