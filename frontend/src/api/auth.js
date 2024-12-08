import {api} from "@/api/api.js";

export const getAuthFromApi = async (email, password) => {
    try {
        const {data} = await api.post('login', {email, password})
        return data.data?.user_token

    } catch (error) {
        console.error(error);
    }
}