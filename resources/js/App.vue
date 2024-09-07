<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import Navbar from '../components/Admin/Navbar.vue';
import LeftNavbar from '../components/Admin/LeftNavbar.vue';
import RightNavbar from '../components/Admin/RightNavbar.vue';
import AppFooter from '../components/Admin/AppFooter.vue';
import { useAuthUserStore } from '../stores/AuthUserStore';
import { useThemeStore } from '../stores/ThemeStore';


const settings = ref(null);
const user = ref(null);
const authUserStore = useAuthUserStore();
 authUserStore.getAuthUser();
const themeStore = useThemeStore();



const  getSettings = () => {

 axios.get('/api/settings')
     .then((response) => {

        settings.value = response.data;

     })


}

onMounted(() => {


  getSettings();

})
</script>

<template>
    <div :class="themeStore.theme === 'light' ? 'light-mode' : 'dark-mode'">
<Navbar />


<LeftNavbar :user ="user" :settings ="settings"/>
<div class="content-wrapper">

<router-view></router-view>
</div>


<RightNavbar/>

<AppFooter :settings="settings"/>
</div>
</template>
