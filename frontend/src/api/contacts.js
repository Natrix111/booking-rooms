import {api} from "@/api/api.js";

export const getContactsFromApi = async () => {
    try {
        const {data} = await api.get('contact')

        return data[0]

    } catch (error) {
        console.error(error);
    }
}