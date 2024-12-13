import {api} from "@/api/api.js";
import {useAuthStore} from "@/stores/auth-store.js";

export const getProfileFromApi = async () => {
    const { token } = useAuthStore()
    try {
        const {data} = await api.get('/user', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })
        // console.log(data)
        return data;
    } catch (error) {
        console.error(error);
    }
}

export const deleteProfileFromApi = async (id) => {
    const { token } = useAuthStore()
    try {
        await api.delete(`/user/bookings/${id}`, {
            headers: {
                Authorization: `Bearer ${token}`
            }

        })
    } catch (error) {
        console.error(error);
    }
}