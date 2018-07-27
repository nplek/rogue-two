<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>
 
        <div class="panel panel-default">
            <div class="panel-heading">Create new department</div>
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
                            <button class="btn btn-success">Create</button>
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
            let app = this;
            let id = app.$route.params.id;
            app.departmentId = id;
            axios.post('/api/companies/list')
                .then(function (resp) {
                    app.companies = resp.data.data;
                })
                .catch(function () {
                    alert("Could not load your companies")
                });
        },
        data: function () {
            return {
                errors: [],
                department: {
                    name: '',
                    short_name: '',
                    company_id: ''
                },
                companies: {
                    name: '',
                    short_name: ''
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newDepartment = app.department;
                axios.post('/api/departments', newDepartment)
                    .then(function (resp) {
                        app.$router.push({path: '/'});
                    })
                    .catch(function (resp) {
                        app.errors = [];
                        for (var err in resp.response.data.errors){
                            app.errors.push( resp.response.data.errors[err].toString() );
                        }
                        alert("Could not create your department");
                    });
            }
        }
    }
</script>