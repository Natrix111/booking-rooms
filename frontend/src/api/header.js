import {api} from "@/api/api.js";

export const getHeaderFromApi = async () => {
    try {
        const { data } = await api.get('info')

        return data[0]

    }catch(error) {
        console.error(error)
    }
}