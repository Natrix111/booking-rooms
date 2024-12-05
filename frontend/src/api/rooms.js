import {api} from "@/api/api.js";

export const getRoomsFromApi = async () => {
    try {
        const {data} = await api.get('rooms')

        return data

    } catch (error) {
        console.error(error);
    }
}