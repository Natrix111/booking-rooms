import { createApp } from 'vue'
import '@/assets/css/fonts.css'
import '@/assets/css/style.css'
import App from '@/App.vue'
import router from "@/router/router.js";
import { createPinia } from "pinia";
import {IMaskDirective} from "vue-imask";

const app = createApp(App)

app
    .directive('imask', IMaskDirective)
    .use(router)
    .use(createPinia())
    .mount('#app')
