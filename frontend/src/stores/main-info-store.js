import {defineStore} from "pinia";
import {ref} from "vue";

import {getContactsFromApi} from "@/api/contacts.js";
import {getReviewsFromApi} from "@/api/reviews.js";
import {getHeaderFromApi} from "@/api/header.js";

export const useMainInfoStore = defineStore('MainInfoStore', () => {
    const reviews = ref([])
    const contacts = ref({})
    const headerInfo = ref({})

    const getReviews = async () => {
        try {
            reviews.value = await getReviewsFromApi()

        } catch (error) {
            console.error(error);
        }
    }

    const getContacts = async () => {
        try {
            contacts.value = await getContactsFromApi()

        } catch (error) {
            console.error(error);
        }
    }

    const getHeader = async () => {
        try {
            headerInfo.value = await getHeaderFromApi()

        } catch (error) {
            console.error(error);
        }
    }

    return {reviews, contacts, headerInfo, getReviews, getContacts, getHeader};
})