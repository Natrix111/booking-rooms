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

export const createRoom = async (roomData) => {
    try {
        const {data} = await api.post('rooms', roomData, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                'Content-Type': 'multipart/form-data'
            }
        })

        return data
    } catch (error) {
        console.error(error)
        isLoading.value = false
    }
}

export const bookingRooms = async (bookingData) => {
    try {
        const {data} = await api.post('bookings', bookingData, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                'Content-Type': 'multipart/form-data'
            }
        })

        return data

    } catch (error) {
        throw error
    }
}
