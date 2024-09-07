<script setup>
import axios from "axios";
import { ref, onMounted } from 'vue';
import Preloader from "./Pages/preloader.vue";
const selectAppointmentValue = ref('all');
const appointmentsCount = ref(0);
const selectUsersValue = ref('today');
const usersCount = ref(0);
const loading = ref(false);

const getAppointmentsCount = () => {
loading.value = true;
axios.get('/api/stats/appointments',{

    params:{
        status : selectAppointmentValue.value,

    }
}).then((response)=> {
loading.value = false;
    appointmentsCount.value = response.data.appointmentsCount;

})
};

const getUsersCount = () => {

  axios.get('/api/stats/users',{

     params: {

        date_range : selectUsersValue.value,
     }
  })
   .then (response => {

         usersCount.value = response.data.usersCount;
   })

};

onMounted(() => {

   getAppointmentsCount();
   getUsersCount();
});
</script>
<template>
<div class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1 class="m-0">Dashboard</h1>
</div>
<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
<li class="breadcrumb-item active">Dashboard</li>
</ol>
</div>
</div>
</div>
</div>


<div class="content">
<div class="container-fluid">
    <div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <div class="d-flex justify-content-between">
                    <h3>{{ appointmentsCount }}</h3>
                    <select v-model="selectAppointmentValue" @change="getAppointmentsCount"
                        style="height: 2rem; outline: 2px solid transparent;" class="px-1 rounded border-0">
                        <option value="all">All</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>
                <p>Appointments</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <router-link to="/admin/appointments" class="small-box-footer">
                View Appointments
                <i class="fas fa-arrow-circle-right"></i>
            </router-link>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <div class="d-flex justify-content-between">
                    <h3>{{ usersCount }}</h3>
                    <select v-model="selectUsersValue" @change="getUsersCount"
                        style="height: 2rem; outline: 2px solid transparent;" class="px-1 rounded border-0">
                        <option value="today">Today</option>
                        <option value="7_days">Week</option>
                        <option value="30_days">30 days</option>
                        <option value="60_days">60 days</option>
                        <option value="360_days">360 days</option>
                        <option value="month_to_date">Month to Date</option>
                        <option value="year_to_date">Year to Date</option>
                    </select>
                </div>
                <p>Users</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <router-link to="/admin/listUsers" class="small-box-footer">
                View Users
                <i class="fas fa-arrow-circle-right"></i>
            </router-link>
        </div>
    </div>
</div>
</div>
</div>
<Preloader :loading="loading" />
</template>
