import {api} from "@/api/api.js";
import {useAuthStore} from "@/stores/auth-store.js";

export const getBookFromApi = async () => {
    const { token } = useAuthStore()
    try {
        const {data} = await api.get('/bookings', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })
        return data.data;
    } catch (error) {
        console.error(error);
    }
}

export const deleteBookFromApi = async (id) => {
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