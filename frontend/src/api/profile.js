import {api} from "@/api/api.js";

export const getProfileFromApi = async (email, password) => {
    try {
        const {data} = await api.patch('profile', {email, password})
        data.data.email = changeData.email,
        data.data.password = changeData.password

    } catch (error) {
        console.error(error);
    }
}