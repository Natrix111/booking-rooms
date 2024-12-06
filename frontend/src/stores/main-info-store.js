import {defineStore} from "pinia";
import {ref} from "vue";

import {getContactsFromApi} from "@/api/contacts.js";
import {getReviewsFromApi} from "@/api/reviews.js";
import {getHeaderFromApi} from "@/api/header.js";

export const useMainInfoStore = defineStore('MainInfoStore', () => {
    const reviews = ref(JSON.parse(localStorage.getItem('reviews')) || [])
    const contacts = ref(JSON.parse(localStorage.getItem('contacts')) || {})
    const headerInfo = ref(JSON.parse(localStorage.getItem('headerInfo')) || {})

    const getReviews = async () => {
        try {
            reviews.value = await getReviewsFromApi()
            localStorage.setItem('reviews', JSON.stringify(reviews.value))

        } catch (error) {
            console.error(error);
        }
    }

    const getContacts = async () => {
        try {
            contacts.value = await getContactsFromApi()
            localStorage.setItem('contacts', JSON.stringify(contacts.value))

        } catch (error) {
            console.error(error);
        }
    }

    const getHeader = async () => {
        try {
            headerInfo.value = await getHeaderFromApi()
            localStorage.setItem('headerInfo', JSON.stringify(headerInfo.value))

        } catch (error) {
            console.error(error);
        }
    }

    return {reviews, contacts, headerInfo, getReviews, getContacts, getHeader};
})