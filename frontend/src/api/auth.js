import {api} from "@/api/api.js";

export const getAuthFromApi = async () => {
    try {
        const {data} = await api.post('login', { login: 'you-login', password: 'you-password' })
        console.log(getAuthFromApi)
        return data

    } catch (error) {
        console.error(error);
    }
}