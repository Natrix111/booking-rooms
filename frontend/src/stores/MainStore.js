import { defineStore } from "pinia";

export const useMainStore = defineStore("MainStore", () => {
    const api = "http://localhost:8080/api"

    return { api };
});
