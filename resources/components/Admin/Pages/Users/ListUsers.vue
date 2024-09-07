<script setup>
import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { Form, Field, useResetForm } from 'vee-validate';
import * as yup from 'yup';
import { useToastr } from '../../../../js/toastr.js';
import { formatDate } from '../../../../js/helper.js';
import { debounce } from 'lodash';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import Preloader from '../preloader.vue';

const toastr = useToastr();
const users = ref({data : []});
const errors = ref({});
const success = ref('');
const editing = ref(false);
const formValues = ref({});
const form = ref(null);
const userBeingDeleted = ref(null);
const searchQuery = ref(null)
const selectedUser = ref([]);
const checkAllUser = ref(false);
const loading = ref(false);
const roles = ref([

    {
        name: 'ADMIN',
        value: 1
    },
    {
        name: 'USER',
        value: 2

    }


]);

const createUserSchema = yup.object({
    name: yup.string().required(),
    email: yup.string().email().required(),
    password: yup.string().required().min(8),
    phone: yup.number().required(),
});

const editUserSchema = yup.object({
    name: yup.string().required(),
    email: yup.string().email().required(),
    password: yup.string().min(8),
    phone: yup.number().required(),
});


const editUser = (user) => {
    editing.value = true;
    form.value.resetForm();

    $('#exampleModal').modal('show');
    formValues.value = {
        id: user.id,
        name: user.name,
        email: user.email,
        phone: user.phone,

    };
    form.value.setValues(formValues.value);
};



const toggleSelection = (user) => {

    const index = selectedUser.value.indexOf(user.id);

    if (index === -1 )
    {
        selectedUser.value.push(user.id);

    }
    else
    {
       selectedUser.value.splice(index,1);
    }

    console.log(selectedUser.value);


};

const selectAllUsers = () => {

if (checkAllUser.value)
{
    selectedUser.value = users.value.data.map(user => user.id);

}
else {

    selectedUser.value = [];
}
 console.log(selectedUser.value);

}

const bulkDelete = () => {

 axios.delete('/api/users/bulkDelete',{

   data :{ ids : selectedUser.value  }

 })
 .then (response => {
    users.value.data = users.value.data.filter(user => !selectedUser.value.includes(user.id));

    checkAllUser.value= false;
    toastr.success('Users Deleted Successfully!')
 })
 .catch(error => {

     console.log(error);

 })

};

const addUserModel = () => {
    editing.value = false;
    form.value.resetForm();

    $('#exampleModal').modal('show');

};

const handleSubmit = (values) => {
    if (editing.value) {
        updateUser(values);

    }
    else {

        addUser(values);
    }


};

const updateUser = (values) => {

    axios
        .post('/api/updateUser' + formValues.value.id, values, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then(response => {
            const index = users.value.data.findIndex(user => user.id === response.data.id);
            users.value.data[index] = response.data;
            $('#exampleModal').modal('hide');
            toastr.success('User Updated Successfully!')

            fileInput.value.reset();
        })
        .catch((error) => {
            if (error.response.data.errors) {
                // form.value.setFieldError('email',error.response.data.errors.email[0]);
                form.value.setErrors(error.response.data.errors);
            }
        })

};

const addUser = (values) => {
    axios
        .post('/api/addUser', values)
        .then(response => {
            users.value.data.unshift(response.data.user);
            form.value.resetForm();
            $('#exampleModal').modal('hide');
            toastr.success('User Added Successfully!')


        })
        .catch((error) => {
            if (error.response.data.errors) {
                // form.value.setFieldError('email',error.response.data.errors.email[0]);
                form.value.setErrors(error.response.data.errors);
            }
        })
};

const deleteUser = () => {

    axios.delete(`/api/deleteUser${userBeingDeleted.value}`)

        .then(() => {

            $('#deleteModal').modal('hide');
            users.value.data = users.value.data.filter(user => user.id !== userBeingDeleted.value);
            toastr.success('User Deleted Successfully!');

        })


};
const changeRole = (user, role) => {

    axios.patch(`/api/users/${user.id}/change-role`, {
        role: role,

    })
        .then(() => {

            toastr.success('Role Changed Successfully!');

        })

};

const getUsers = (page = 1) => {
    loading.value = true;
    axios
        .get(`/api/users?page=${page}`,{
    params: {
        query: searchQuery.value,
    }

    })
        .then((response) => {
            loading.value = false;
            users.value = response.data;
            selectedUser.value=[];
            checkAllUser.value = false;

        })
        .catch((error) => {
            console.error('Error fetching users:', error);
        });
};

const confirmUserDeletion = (user) => {
    userBeingDeleted.value = user.id;
    $('#deleteModal').modal('show');


};

watch(searchQuery, debounce(()=>{

    getUsers();
},300))

onMounted(() => {
    getUsers();
});
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex">
                        <button @click="addUserModel()" type="button" class="btn btn-secondary mb-2 mr-2">
                            <i class="fa fa-plus-circle mr-1"></i>
                            Add New User
                        </button>
                        <div v-if="selectedUser.length > 0">
                        <button  type="button" @click="bulkDelete" class="btn btn-danger mb-2">
                            <i class="fa fa-trash mr-1"></i>
                            Delete Selected
                        </button>
                        <span> Select {{ selectedUser.length }} User </span>
                        </div>
                        </div>
                        <div>
                            <input type="text" class="form-control"
                                placeholder="search...." v-model="searchQuery">


                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                   <thead>
                        <tr>
                            <th scope="col"> <input  type="checkbox" v-model="checkAllUser" @change="selectAllUsers" ></th>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Register Date</th>
                            <th scope="col">Role</th>
                            <th scope="col">Option</th>

                        </tr>
                    </thead>
                    <tbody  v-if="users.data.length > 0">
                        <tr v-for="(user, index) in users.data" :key="user.id">
                            <th scope="row"> <input  type="checkbox" @change="toggleSelection(user)" :checked="checkAllUser" ></th>
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.phone }}</td>
                            <td>{{ user.formatted_time }}</td>
                            <td>
                                <select class="form-control" @change="changeRole(user, $event.target.value)">

                                    <option v-for="role in roles" :key="role.id" :value="role.value"
                                        :selected="(user.role === role.name)">{{ role.name }}</option>
                                </select>
                            </td>
                            <td>
                                <a href="#" @click.prevent="editUser(user)"><i class="fa fa-edit"></i></a>
                                <a href="#" @click.prevent="confirmUserDeletion(user)"><i
                                        class="fa fa-trash text-danger ml-2"></i></a>

                            </td>
                        </tr>

                    </tbody>
                    <tbody v-else>
                    <tr>

                        <td class="text-center" colspan="6"> No Result Found.....</td>
                    </tr>

                    </tbody>
                </table>
                        </div>
                        </div>
                 </div>

        <Bootstrap5Pagination :data="users" @pagination-change-page="getUsers" />

    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span v-if="editing">Edit User</span>
                        <span v-else> Add New User</span>


                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form ref="form" @submit="handleSubmit" :validation-schema="editing ? editUserSchema : createUserSchema"
                    v-slot="{ errors }" :initial-values="formValues">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="name" class="col-form-label">Name</label>
                            <Field type="text" name="name" class="form-control" :class="{ 'is-invalid': errors.name }" />
                            <span class="invalid-feedback">{{ errors.name }}</span>

                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email</label>
                            <Field type="email" name="email" class="form-control"
                                :class="{ 'is-invalid': errors.email }" />
                            <span class="invalid-feedback">{{ errors.email }}</span>

                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-form-label">Phone</label>
                            <Field type="number" name="phone" class="form-control"
                                :class="{ 'is-invalid': errors.phone }" />
                            <span class="invalid-feedback">{{ errors.phone }}</span>

                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Password</label>
                            <Field type="password" name="password" class="form-control"
                                :class="{ 'is-invalid': errors.password }" />
                            <span class="invalid-feedback">{{ errors.password }}</span>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </Form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&ggg;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are You Sure You Want To Delete This User ...?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" @click.prevent="deleteUser" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
       <Preloader :loading="loading" />
   </template>
