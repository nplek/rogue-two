<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Edit Project</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Project code</label>
                            <input type="text" v-model="project.project_code" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Name</label>
                            <input type="text" v-model="project.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Short name</label>
                            <input type="text" v-model="project.short_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Budget</label>
                            <input type="number" v-model="project.budget" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Start date</label>
                            <date-picker type="date" 
                                
                                v-model="project.start_date" 
                                lang="en"
                                :first-day-of-week="7" 
                                :confirm="true"
                                >
                            </date-picker>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">End date</label>
                            <date-picker type="date" 
                                v-model="project.end_date" 
                                lang="en" 
                                :first-day-of-week="1"
                                :confirm="true"
                                >
                            </date-picker>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
                <p v-if="errors.length" class="text-red">
                    <b>Please correct the following error(s):</b>
                    <ul>
                    <li v-for="(error,index ) in errors" v-bind:key="index" >{{ error }}</li>
                    </ul>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker'
    export default {
        components: {
            'date-picker': DatePicker ,
        },
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.projectId = id;
            axios.get('/api/projects/' + id)
                .then(function (resp) {
                    app.project = resp.data.data;
                })
                .catch(function () {
                    alert("Could not load your project")
                });
        },
        data: function () {
            return {
                errors: [],
                projectId: null,
                project: {
                    project_code: '',
                    name: '',
                    short_name: '',
                    budget: '',
                    start_date: '',
                    end_date: ''
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newProject = app.project;
                axios.patch('/api/projects/' + app.projectId, newProject)
                    .then(function (resp) {
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        app.errors = [];
                        for (var err in resp.response.data.errors){
                            app.errors.push( resp.response.data.errors[err].toString() );
                        }
                        alert("Could not update your project");
                    });
            }
        }
    }
</script>