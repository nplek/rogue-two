<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>
 
        <div class="panel panel-default">
            <div class="panel-heading">Update user</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Name</label>
                            <input type="text" v-model="user.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Email</label>
                            <input type="email" v-model="user.email" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Employee</label>
                            <multiselect 
                                v-model="user.employee"
                                @input="employeeChange"
                                :options="employees" 
                                :custom-label="nameWithFullName" 
                                placeholder="Please select" 
                                label="name" 
                                track-by="id">
                            </multiselect>
                        </div>
                        <div class="col-xs-12 form-group">
                            <router-link v-if="auth.can.create" :to="{name: 'createEmployee'}" class="btn btn-info">New Employee</router-link>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <input type="radio" id="active" value="A" v-model="user.active">
                            <label for="active">Active</label>
                            <input type="radio" id="inactive" value="I" v-model="user.active">
                            <label for="inactive">Inactive</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Roles : </label>
                            <div v-for="(rolelist,index) in user.userroles" v-bind:key="index" >
                                <span v-if="rolelist.team"  class="badge bg-green" > 
                                    {{ rolelist.role.name }} - {{ rolelist.team.name }}
                                </span>
                                <span v-else class="badge bg-red">
                                    {{ rolelist.role.name }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <router-link :to="{name: 'showRoleTeam', params: {userId: userId}}" class="btn btn-sm btn-warning">
                                Roles
                            </router-link>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button v-if="auth.can.update" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
                <p v-if="errors.length" class="text-red">
                    <b>Please correct the following error(s):</b>
                    <ul>
                    <li v-for="(error,index) in errors" v-bind:key="index" >{{ error }}</li>
                    </ul>
                </p>
            </div>
        </div>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import Multiselect from 'vue-multiselect'
    export default {
        components: {
            'multiselect': Multiselect
        },
        beforeMount(){
            this.getAuthen();
        },
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.userId = id;
            axios.get('/api/users/' + id,{
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer '+ app.token
                    }
                })
                .then(function (resp) {
                    app.user = resp.data.data;
                })
                .catch(function () {
                    alert("Could not load your user")
                });
            this.getEmployeesList();
        },
        data: function () {
            return {
                errors: [],
                userId: null,
                user: {
                    name: '',
                    email:'',
                    first_name:'',
                    last_name:'',
                    employee_id:'',
                },
                employees:[],
                token:null,
                auth: {
                    name: '',
                    isAdmin: false,
                    can: {
                        view: false,
                        create: false,
                        update: false,
                        delete: false,
                        restore: false,
                    },
                },
            }
        },
        methods: {
            nameWithFullName({employee_id,first_name,last_name}){
                return `${employee_id} — [${first_name} ${last_name}]`
            },
            employeeChange(value,id){
                var app = this;
                app.user.employee_id = value.id;
            },
            getAuthen(){
                var app = this;
                let token = document.head.querySelector('meta[name="token"]'); 
                let user = document.head.querySelector('meta[name="user"]');
                let isAdmin = document.head.querySelector('meta[name="isAdmin"]');
                let permissions = document.head.querySelector('meta[name="permissions"]');
                app.token = token.content;
                app.auth.name = user.content;
                app.auth.isAdmin = isAdmin.content;
                let content = permissions.content;
                var objs = JSON.parse(content);
                for (var index in objs){
                    var permission = objs[index].name;
                    switch(permission) {
                        case 'create-user':
                            app.auth.can.create = true;
                            break;
                        case 'update-user':
                            app.auth.can.update = true;
                            break;
                        case 'delete-user':
                            app.auth.can.delete = true;
                            break;
                        case 'restore-user':
                            app.auth.can.restore = true;
                            break;
                        default:
                            break;
                    }
                }
            },
            getEmployeesList(){
                let app = this;
                axios.post('/api/employees/list',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.employees = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your employees.")
                    });
            },
            saveForm() {
                event.preventDefault();
                var app = this;
                var newUser = app.user;
                axios.patch('/api/users/' + app.userId, newUser,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        app.errors = [];
                        for (var err in resp.response.data.errors){
                            app.errors.push( resp.response.data.errors[err].toString() );
                        }
                        alert("Could not update your user");
                    });
            }
        }
    }
</script>