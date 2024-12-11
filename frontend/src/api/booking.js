import {api} from "@/api/api.js";

export const getBookFromApi = async () => {
    try {
        const {data} = await api.post('/bookings', {})


    } catch (error) {
        console.error(error);
    }
}