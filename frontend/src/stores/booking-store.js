import {defineStore} from "pinia";
import {ref} from "vue";
import {getBookFromApi} from "@/api/booking.js";
import {getContactsFromApi} from "@/api/contacts.js";

export const useBookingStore = defineStore('MainInfoStore', () => {
    const hyi = ref(JSON.parse(localStorage.getItem('reviews')) || [])


    const getBookings = async () => {
        try {


        } catch (error) {
            console.error(error);
        }
    }

})