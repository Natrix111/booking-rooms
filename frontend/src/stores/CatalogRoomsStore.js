import {defineStore} from "pinia";
import {computed, ref} from "vue";
import {api} from "@/api/api.js";

export const useCatalogRoomsStore = defineStore('CatalogRoomsStore', () => {
    const rooms = ref([])
    const filters = ref([])

    const getRooms = async () => {
        try {
            const {data} = await api.get('rooms')

            rooms.value = data
            rooms.value.forEach((room) => {room.area = room.dimensions[0] * room.dimensions[1]})

        } catch (error) {
            console.error(error);
        }
    }

    const getFilters = async () => {
        try {
            const {data} = await api.get('rooms/filters')

            filters.value = data

        } catch (error) {
            console.error(error);
        }
    }

    const getRoomsMainPage = computed(() => {
        return rooms.value.filter((room) => room.featured === true)
    })

    return {rooms, filters,  getRooms, getFilters, getRoomsMainPage}
})