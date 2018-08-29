<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>
 
        <div class="panel panel-default">
            <div class="panel-heading">Create new Employee</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">                    
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Employee ID</label>
                            <input type="text" v-model="employee.employee_id" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">First Name</label>
                            <input type="text" v-model="employee.first_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Last Name</label>
                            <input type="text" v-model="employee.last_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <input type="radio" id="Staff" value="S" v-model="employee.type">
                            <label for="staff">Staff</label>
                            <input type="radio" id="Manager" value="M" v-model="employee.type">
                            <label for="manager">Manager</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Position</label>
                            <multiselect 
                                v-model="employee.positions" 
                                :options="positions" 
                                :multiple="true" 
                                :close-on-select="false" 
                                :clear-on-select="false" 
                                :hide-selected="true" 
                                :preserve-search="true" 
                                :custom-label="nameWithShortName" 
                                placeholder="Please select" 
                                label="name" 
                                track-by="id" 
                                :preselect-first="true">
                                <template 
                                    slot="tag" 
                                    slot-scope="props">
                                    <span class="btn btn-danger btn-xs">
                                        <span> {{ props.option.name }}</span>
                                        <i class="fa fa-close" @click="props.remove(props.option)"></i> 
                                    </span>
                                </template>
                            </multiselect>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Department</label>
                            <multiselect 
                                v-model="employee.department"
                                @input="departmentChange"
                                :options="departments" 
                                :custom-label="nameWithShortName" 
                                placeholder="Please select" 
                                label="name" 
                                track-by="id">
                            </multiselect>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Mobile</label>
                            <input type="text" v-model="employee.mobile" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Phone</label>
                            <input type="text" v-model="employee.phone" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Location</label>
                            <multiselect 
                                v-model="employee.location"
                                @input="locationChange"
                                :options="locations" 
                                :custom-label="nameWithShortName" 
                                placeholder="Please select" 
                                label="name" 
                                track-by="id">
                            </multiselect>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Manager</label>
                            <multiselect 
                                v-model="employee.manager"
                                @input="managerChange"
                                :options="managers" 
                                :custom-label="nameWithFullName" 
                                placeholder="Please select" 
                                label="name" 
                                track-by="id">
                            </multiselect>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <input type="radio" id="active" value="A" v-model="employee.active">
                            <label for="active">Active</label>
                            <input type="radio" id="inactive" value="I" v-model="employee.active">
                            <label for="inactive">Inactive</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button v-if="auth.can.create" class="btn btn-success">Create</button>
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
        data: function () {
            return {
                errors: [],
                employee: {
                    employee_id:'',
                    first_name:'',
                    last_name:'',
                    positions:[],
                    position_id:null,
                    location_id:null,
                    manager_id:null,
                    department_id:null,
                    type:'',
                },
                positions:[],
                locations:[],
                departments:[],
                managers:[],
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
        beforeMount(){
            this.getAuthen();
        },
        mounted() {
            this.getPositionsList();
            this.getLocationsList();
            this.getDepartmentsList();
            this.getManagerList();
        },
        methods: {
            nameWithShortName({short_name,name}){
                return `${short_name} — [${name}]`
            },
            nameWithFullName({employee_id,first_name,last_name}){
                return `${employee_id} — [${first_name} ${last_name}]`
            },
            locationChange(value,id){
                var app = this;
                app.employee.location_id = value.id;
            },
            departmentChange(value,id){
                var app = this;
                app.employee.department_ = value.id;
            },
            managerChange(value,id){
                var app = this;
                app.employee.manager_id = value.id;
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
                        case 'create-employee':
                            app.auth.can.create = true;
                            break;
                        case 'update-employee':
                            app.auth.can.update = true;
                            break;
                        case 'delete-employee':
                            app.auth.can.delete = true;
                            break;
                        case 'restore-employee':
                            app.auth.can.restore = true;
                            break;
                        default:
                            break;
                    }
                }
            },
            getPositionsList(){
                let app = this;
                axios.post('/api/positions/list',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.positions = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your positions.")
                    });
            },
            getLocationsList(){
                let app = this;
                axios.post('/api/locations/list',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.locations = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your locations.")
                    });
            },
            getDepartmentsList(){
                let app = this;
                axios.post('/api/departments/list',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.departments = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your departments.")
                    });
            },
            getManagerList(){
                let app = this;
                axios.post('/api/employees/manager/list',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.managers = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your managers.")
                    });
            },
            saveForm() {
                event.preventDefault();
                var app = this;
                var newemployee = app.employee;
                axios.post('/api/employees', newemployee,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + app.token
                        }
                    })
                    .then(function (resp) {
                        app.$router.push({path: '/'});
                    })
                    .catch(function (resp) {
                        app.errors = [];
                        for (var err in resp.response.data.errors){
                            app.errors.push( resp.response.data.errors[err].toString() );
                        }
                        alert("Could not create your employee");
                    });
            }
        }
    }


    /*====================*/

</script>