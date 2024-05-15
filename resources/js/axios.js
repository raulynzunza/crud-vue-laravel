import axios from 'axios';
import { useRouter } from 'vue-router'; // Import your Vue router instance

const router = useRouter()

const instance = axios.create({
    baseURL: import.meta.env.VITE_APP_URL,
    headers: {
        Accept: 'application/json',
    },
});

// Add a request interceptor to set Authorization header
instance.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

instance.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        if (error.response.status === 401) {
            router.push('/');
        }
        return Promise.reject(error);
    }
);

export default instance;
