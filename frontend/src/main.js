import { createApp } from 'vue'
import '@/assets/css/fonts.css'
import '@/assets/css/style.css'
import App from '@/App.vue'
import router from "@/router/router.js";
import { createPinia } from "pinia";
import {IMaskDirective} from "vue-imask";
import Vue3Toasity, {toast} from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const toastifyOptions = {
    autoClose: 3000,
    position: toast.POSITION.TOP_RIGHT,
}

const app = createApp(App)

app
    .directive('imask', IMaskDirective)
    .use(Vue3Toasity, toastifyOptions)
    .use(router)
    .use(createPinia())
    .mount('#app')
