import {api} from "@/api/api.js";

export const getReviews = async () => {
    try {
        const {data} = await api.get('reviews')

        return data

    }catch (error) {
        console.error(error)
    }
}