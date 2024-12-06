import {defineStore} from "pinia";
import {computed, ref} from "vue";

import {getRoomsFromApi} from "@/api/rooms.js";
import {getFiltersFromApi} from "@/api/filters.js";

export const useCatalogRoomsStore = defineStore('CatalogRoomsStore', () => {
    const rooms = ref([])
    const filters = ref([])

    const getRooms = async () => {
        try {
            rooms.value = await getRoomsFromApi()
            rooms.value.forEach((room) => {room.area = room.dimensions[0] * room.dimensions[1]})

        } catch (error) {
            console.error(error);
        }
    }

    const getFilters = async () => {
        try {
            filters.value = await getFiltersFromApi()

        } catch (error) {
            console.error(error);
        }
    }

    const getRoomsMainPage = computed(() => {
        return rooms.value.filter((room) => room.featured === true)
    })

    return {rooms, filters,  getRooms, getFilters, getRoomsMainPage}
})