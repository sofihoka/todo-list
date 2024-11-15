import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: "http://127.0.0.1:8000/", // ver despues como hacer desde la config en .env
  // Aquí puedes añadir más configuraciones como headers por defecto
});

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
export default axiosInstance;