import {defineStore} from "pinia";
import {useMainStore} from "./MainStore.js";
import {computed, ref} from "vue";
import axios from "axios";

export const useCatalogRoomsStore = defineStore('CatalogRoomsStore', () => {
    const {api} = useMainStore()
    const rooms = ref([])
    const filters = ref([])

    const getRooms = async () => {
        try {
            const {data} = await axios.get(`${api}/rooms`)

            rooms.value = data

        } catch (error) {
            console.error(error);
        }
    }

    const getFilters = async () => {
        try {
            const {data} = await axios.get(`${api}/rooms/filters`)

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