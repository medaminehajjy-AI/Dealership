import axios from 'axios'

const API_BASE = import.meta.env.VITE_API_URL || 'http://127.0.0.1:8000'

const api = axios.create({
    baseURL: `${API_BASE}/api`,
    headers: {
        //'Content-Type': 'application/json',  this line is commented out because axios automatically sets the Content-Type header for JSON requests And it can cause issues when sending FormData (like for file uploads)
        'Accept': 'application/json',
    },
})

// Automatically add the Bearer Token if it exists
api.interceptors.request.use((config) => {
    const token = localStorage.getItem('token')

    if (token) {
        config.headers.Authorization = `Bearer ${token}`
    }

    return config
})

export default api