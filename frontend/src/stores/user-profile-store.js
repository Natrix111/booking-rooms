import {defineStore} from "pinia";
import {ref} from "vue";
import { deleteProfileFromApi, getProfileFromApi} from "@/api/user.js";

export const useProfileStore = defineStore('user-profile-store', () => {
    const Profile = ref([])


    const getProfile = async () => {
        try {
            Profile.value = (await getProfileFromApi()).bookings;
            console.log(Profile.value)
        } catch (error) {
            console.error(error);
        }
    }

    const deleteProfile = async (id) => {
        try {
            await deleteProfileFromApi(id)
            await getProfile()
            console.log(id)
        }
        catch (e) {
            console.error(e)
        }

    }

    return { Profile, getProfile, deleteProfile }
})