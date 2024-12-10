import {api} from "@/api/api.js";

export const getRoomsFromApi = async (filters = null) => {
    try {
        const {data} = await api.get('rooms', filters
            ? {
                params: {
                    min_price: filters.minPrice,
                    max_price: filters.maxPrice,
                    areas: filters.areas.join(','),
                    amenities: filters.amenities.join(','),
                    sort_by: filters.sortBy,
                    sort_order: filters.sortOrder
                }
            }
            : {
                params: {
                    sort_by: 'price',
                    sort_order: 'asc',
                }
            });

        return data

    } catch (error) {
        console.error(error);
    }
}

export const getRoomByIdFromApi = async (roomId) => {
    try {
        const {data} = await api.get(`rooms/${roomId}`)

        return data

    } catch (error) {
        console.error(error);
    }
}
