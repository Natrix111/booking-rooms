import {defineStore} from "pinia";
import {computed, ref} from "vue";

import {getRoomsFromApi, getRoomByIdFromApi} from "@/api/rooms.js";
import {getFiltersFromApi} from "@/api/filters.js";

export const useCatalogRoomsStore = defineStore('CatalogRoomsStore', () => {
    const rooms = ref([])
    const filters = ref(JSON.parse(localStorage.getItem('filters')) || [])

    const getRooms = async () => {
        try {
            rooms.value = await getRoomsFromApi()

        } catch (error) {
            console.error(error);
        }
    }

    const getFilters = async () => {
        try {
            filters.value = await getFiltersFromApi()
            localStorage.setItem('filters', JSON.stringify(filters.value))

        } catch (error) {
            console.error(error);
        }
    }

    const getRoomsMainPage = computed(() => {
        return rooms.value.filter((room) => room.featured === true)
    })

    const getSortedAndFilteredRooms = async (filters) => {
        try {
            const data = await getRoomsFromApi(filters)

            return data
        } catch (error) {
            console.error(error)
        }
    }

    const getRoomById = async (roomId) => {
        try {
            const data = await getRoomByIdFromApi(roomId)

            return data
        } catch (error) {
          console.error(error)
        }
    }

    return {rooms, filters,  getRooms, getFilters, getRoomsMainPage, getSortedAndFilteredRooms, getRoomById}
})