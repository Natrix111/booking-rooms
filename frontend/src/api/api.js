import axios from "axios";

export const api = axios.create({
    baseURL: 'http://localhost:8080/api/',
    headers: {
        'Content-Type': 'Application/json'
    }
})

export const storageUrl = 'http://localhost:8080/storage/'
