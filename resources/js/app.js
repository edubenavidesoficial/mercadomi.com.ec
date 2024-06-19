import { createApp } from 'vue';
import DefaultComponent from "./components/DefaultComponent.vue"; // Asegúrate de tener la extensión .vue si es necesario
import SupermercadoComponent from './components/cat/SupermercadoComponent.vue';
import FerreteriaComponent from './components/cat/FerreteriaComponent.vue';
import HogarComponent from './components/cat/HogarComponent.vue';
import MascotasComponent from './components/cat/MascotasComponent.vue';
import router from './router';
import store from './store';
import axios from 'axios';
import i18n from "./i18n";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import VueSimpleAlert from "vue3-simple-alert";
import VueNextSelect from 'vue-next-select';
import 'vue-next-select/dist/index.css';
import ENV from './config/env';
import "../../public/themes/default/fonts/urbanist/urbanist.css";
import "../../public/themes/default/fonts/iconly/iconly.css";
import "../../public/themes/default/fonts/public/public.css";
import "../../public/themes/default/fonts/fontawesome/fontawesome.css";
import { createHead } from '@vueuse/head';

const head = createHead();

/* Start tooltip alert code */
const toastOptions = {
    timeout: 2000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false
};
/* End tooltip alert code */

/* Start axios code */
const API_URL = ENV.API_URL;
const API_KEY = ENV.API_KEY;

axios.defaults.baseURL = API_URL + '/api';

axios.interceptors.request.use(
    config => {
        config.headers['x-api-key'] = API_KEY;
        if (localStorage.getItem('vuex')) {
            const vuex = JSON.parse(localStorage.getItem('vuex'));
            const token = vuex.auth.authToken;
            config.headers['Authorization'] = token ? `Bearer ${token}` : '';

            if (vuex.globalState) {
                config.headers['x-localization'] = vuex.globalState.lists.language_code;
            }
        }
        return config;
    },
    error => Promise.reject(error),
);
/* End axios code */

const app = createApp({});
app.component('default-component', DefaultComponent);
app.component('supermercado-component', SupermercadoComponent);
app.component('ferreteria-component', FerreteriaComponent);
app.component('hogar-component', HogarComponent);
app.component('mascotas-component', MascotasComponent);
app.component('vue-select', VueNextSelect);
app.use(router);
app.use(store);
app.use(VueSimpleAlert);
app.use(Toast, toastOptions);
app.use(i18n);
app.use(head);
app.mount('#app');
