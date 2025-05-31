import router from '@/router';
import axios, { type AxiosResponse, type InternalAxiosRequestConfig } from 'axios';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
});

api.interceptors.request.use(function (config: InternalAxiosRequestConfig) {
  const token = localStorage.getItem('token') || ''

  config.headers.Authorization = `Bearer ${token}`

  return config
});

api.interceptors.response.use((response: AxiosResponse) => response, function (error: any) {
  if (error.status === 401) {
    localStorage.removeItem('token')
    localStorage.removeItem('token_expires_at')
    localStorage.removeItem('user')

    return router.push('/login')
  }

  return Promise.reject(error)
})

export default api;