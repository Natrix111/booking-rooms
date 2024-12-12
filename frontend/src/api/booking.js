import {api} from "@/api/api.js";

export const getBookFromApi = async () => {
    try {
        const {data} = await api.get('/bookings')
        console.log(data)
        return data
    } catch (error) {
        console.error(error);
    }
}