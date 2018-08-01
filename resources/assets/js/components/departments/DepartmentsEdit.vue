<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>
 
        <div class="panel panel-default">
            <div class="panel-heading">Edit department</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Department name</label>
                            <input type="text" v-model="department.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Short name</label>
                            <input type="text" v-model="department.short_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Company</label>
                            <select v-model='department.company_id' class="form-control">
                                <option disabled value="">Please select ...</option>
                                <option v-for="company in companies" v-bind:key="company.id" v-bind:value="company.id">
                                    {{ company.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <input type="radio" id="active" value="A" v-model="department.active">
                            <label for="active">Active</label>
                            <input type="radio" id="inactive" value="I" v-model="department.active">
                            <label for="inactive">Inactive</label>
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
 
<script>
    export default {
        mounted() {
            this.getAuthen();
            let app = this;
            let id = app.$route.params.id;
            app.departmentId = id;
            axios.post('/api/companies/list',null,{
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer '+ app.token
                    }
                })
                .then(function (resp) {
                    app.companies = resp.data.data;
                })
                .catch(function () {
                    alert("Could not load your companies")
                });
            axios.get('/api/departments/' + id,{
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer '+ app.token
                    }
                })
                .then(function (resp) {
                    app.department = resp.data.data;
                })
                .catch(function () {
                    alert("Could not load your department")
                });
        },
        data: function () {
            return {
                errors: [],
                departmentId: null,
                department: {
                    name: '',
                    short_name: '',
                    company_id: ''
                },
                companies: {
                    name: '',
                    short_name: ''
                },
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
                        case 'create-department':
                            app.auth.can.create = true;
                            break;
                        case 'update-department':
                            app.auth.can.update = true;
                            break;
                        case 'delete-department':
                            app.auth.can.delete = true;
                            break;
                        case 'restore-department':
                            app.auth.can.restore = true;
                            break;
                        default:
                            break;
                    }
                }
            },
            saveForm() {
                event.preventDefault();
                var app = this;
                var newDepartment = app.department;
                console.log(newDepartment);
                axios.patch('/api/departments/' + app.departmentId, newDepartment,{
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
                        alert("Could not update your department");
                    });
            }
        }
    }
</script>