import './bootstrap';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';
import { createApp} from 'vue';
import { createPinia } from 'pinia';
import { createRouter, createWebHistory } from 'vue-router';
import Routes from './routes';
import Login from '../components/Admin/Pages/auth/Login.vue';
import App from './App.vue';
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    components,
    directives,
  })

const pinia = createPinia();

const app = createApp(App);

const router = createRouter({
    routes:Routes,
    history: createWebHistory()
});

app.use(router);
app.use(pinia);
app.use(vuetify);

if(window.location.pathname === '/login')
{

   const newApp = createApp({});

   newApp.component('Login',Login);

   newApp.mount('#login');

}
else{

    app.mount('#app');


}

