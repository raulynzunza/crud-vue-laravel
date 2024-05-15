import './bootstrap';
import { createApp } from "vue";
import vuetify from "./vuetify";
import App from './App.vue'
import router from './router/index.js'

createApp(App)
    .use(router)
    .use(vuetify)
    .mount("#app");