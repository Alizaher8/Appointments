<script setup>
import axios from 'axios';
import { reactive, onMounted, ref } from 'vue';
import { useToastr } from '../../../../js/toastr.js';
import { useRoute, useRouter } from 'vue-router';
import { Form } from 'vee-validate';
import flatpickr from "flatpickr";
import 'flatpickr/dist/themes/light.css';

const toastr = useToastr();
const route = useRoute();
const router = useRouter();
const clients = ref();
const editMode = ref(false);

const form = reactive({

    'title': '',
    'client_id': '',
    'start_time': '',
    'end_time': '',
    'description': '',




});

const getAppointment = () => {

    axios.get(`/api/appointments/${route.params.id}/edit`)

      .then(({data}) => {

          form.title = data.title;
          form.client_id = data.client_id;
          form.start_time = data.formatted_start_time;
          form.end_time = data.formatted_end_time;
          form.description = data.description;

      })


};


const getClients = () => {

   axios.get('/api/clients')

       .then((response) => {

        clients.value = response.data;
        console.log(clients.value);

       })
       .catch((error) => {

          console.log(error);
       })


};

const updateAppointment = (values, actions) => {

    axios.put(`/api/appointments/${route.params.id}/update`, form)
    .then((response) => {
        toastr.success(' Appointment Updated Successfully!');
        router.push('/admin/appointments');
}).catch((error) => {

actions.setErrors(error.response.data.errors);
})


};

const createAppointment = (values, actions) => {

    axios.post('/api/appointments/create',form)

.then((response) => {
    console.log(router);
    toastr.success(' Appointment Added Successfully!');
    router.push('/admin/appointments');



})     .catch((error) => {
            if (error.response && error.response.data && error.response.data.errors) {
                actions.setErrors(error.response.data.errors);
            } else {
                // Handle the error when the response or data is undefined
                console.error('Error occurred:', error);
            }
        });

};

const handelSubmit = (values, actions) => {

    if(editMode.value)
    {
       updateAppointment(values, actions);
    }
    else
    {
        createAppointment(values, actions);

    }


};
onMounted(() => {

    if(route.name === 'admin.appointment.edit')
    {
           editMode.value = true;
           getAppointment();

    }
flatpickr(".flatpickr", {

    enableTime: true,
    dateFormat: 'Y-m-d h:i K',
    defaultHour: 10,

});
getClients();

})
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <span v-if="editMode">Edit</span>
                          <span v-else>Create</span>
                        Appointment</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/admin/dashboard">Home</router-link>
                        </li>
                        <li class="breadcrumb-item">
                            <router-link to="/admin/appointments">Appointments</router-link>
                        </li>
                        <li class="breadcrumb-item active">
                          <span v-if="editMode">Edit</span>
                          <span v-else>Create</span>

                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <Form @submit="handelSubmit" v-slot:default="{ errors }">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input v-model="form.title" type="text" :class="{'is-invalid':errors.title}" class="form-control" id="title" placeholder="Enter Title">
                                            <span class="invalid-feedback">{{ errors.title }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client">Client Name</label>
                                            <select v-model="form.client_id" id="client" :class="{'is-invalid':errors.client_id}" class="form-control">
                                                <option v-for="client in clients"  :value="client.id" :key="client.id">{{ client.first_name }} {{ client.last_name }}</option>
                                            </select>
                                            <span class="invalid-feedback">{{ errors.client_id }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_time">Star Time</label>
                                            <input type="text" v-model="form.start_time" class="form-control flatpickr" :class="{'is-invalid':errors.start_time}" id="start_time">
                                            <span class="invalid-feedback">{{ errors.start_time }}</span>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_time">End Time</label>
                                            <input type="text" v-model="form.end_time" class="form-control flatpickr"   :class="{'is-invalid':errors.end_time}" id="end_time">
                                            <span class="invalid-feedback">{{ errors.end_time }}</span>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea v-model="form.description" class="form-control" id="description" rows="3"
                                        placeholder="Enter Description" :class="{'is-invalid':errors.description}"></textarea>
                                        <span class="invalid-feedback">{{ errors.description }}</span>

                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </Form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
