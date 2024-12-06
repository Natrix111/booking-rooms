import {api} from "@/api/api.js";

export const getFiltersFromApi = async () => {
    try {
        const {data} = await api.get('rooms/filters')

        return data

    } catch (error) {
        console.error(error);
    }
}