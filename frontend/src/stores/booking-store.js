import {defineStore} from "pinia";
import {ref} from "vue";
import {deleteBookFromApi, getBookFromApi} from "@/api/booking.js";
import {getContactsFromApi} from "@/api/contacts.js";

export const useBookingStore = defineStore('booking-store', () => {
    const bookings = ref([
        { id: 1, title: 'ЫВЩАЫВЗЛА', price: 12321 },
        { id: 12, title: 'ЫВЩАЫВЗЛАsafssa', price: 12321 },
    ])


    const getBookings = async () => {
        try {
            bookings.value = await getBookFromApi();

        } catch (error) {
            console.error(error);
        }
    }

    const deleteBook = async (id) => {
        try {
            await deleteBookFromApi(id)
            await getBookings()
        }
        catch (e) {
            console.error(e)
        }

    }

    return { bookings, getBookings, deleteBook }
})