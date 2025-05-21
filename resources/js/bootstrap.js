import axios from 'axios';

axios.defaults.withCredentials = true
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// перехватчик 419
axios.interceptors.response.use(
    response => response,
    async error => {
        const { response, config } = error
        if (response?.status === 419 && !config._retry) {
            config._retry = true
            // получаем свежий CSRF‑cookie
            await axios.get('/sanctum/csrf-cookie')
            // Inertia автоматически подставит updated XSRF‑TOKEN в заголовок
            return axios(config)
        }
        return Promise.reject(error)
    }
)

window.axios = axios;
