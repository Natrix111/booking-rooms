import {api} from "@/api/api.js";

export const getProfileFromApi = async (email, password) => {
    try {
        const {data} = await api.patch('profile', {email, password})
        email: changeData.email,
        password: changeData.password
        return data.data?.user_token

    } catch (error) {
        console.error(error);
    }
}