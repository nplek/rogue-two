<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link :to="{name: 'showRoleTeam', params: {id: userId}}" class="btn btn-default">
                Back
            </router-link>
        </div>
 
        <div class="panel panel-default">
            <div class="panel-heading">Update Role Team</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Role</label>
                            <multiselect 
                                v-model="userRole.role"
                                @input="roleChange"
                                :options="roles" 
                                placeholder="Please select" 
                                label="name" 
                                track-by="id">
                            </multiselect>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Team</label>
                            <multiselect 
                                v-model="userRole.team"
                                @input="teamChange"
                                :options="teams" 
                                placeholder="Please select" 
                                label="name" 
                                track-by="id">
                            </multiselect>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button v-if="auth.can.update" class="btn btn-success">Create</button>
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
        mounted() {
            this.getAuthen();
            let app = this;
            let uid = app.$route.params.uid;
            app.userId = uid;
            this.getRolesList();
            this.getTeamsList();
        },
        data: function () {
            return {
                errors: [],
                userRole:{
                    user_id:null,
                    user: null,
                    role_id:null,
                    role: null,
                    team_id:null,
                    team:null,
                },
                userId: null,
                roles:[],
                teams:[],
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
            teamChange(value,id){
                var app = this;
                app.userRole.team_id = value.id;
            },
            roleChange(value,id){
                var app = this;
                app.userRole.role_id = value.id;
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
            getTeamsList(){
                let app = this;
                axios.post('/api/teams/list',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.teams = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your permissions")
                    });
            },
            getRolesList(){
                let app = this;
                axios.post('/api/roles/list',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.roles = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your permissions")
                    });
            },
            saveForm() {
                event.preventDefault();
                var app = this;
                var newUser = app.userRole;
                axios.post('/api/users/roles/' + app.userId , newUser,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        //app.$router.replace('/');
                        app.$router.replace({name: 'showRoleTeam', params: {id: app.userId}});
                        //app.$route.go(-1);
                    })
                    .catch(function (resp) {
                        app.errors = [];
                        for (var err in resp.response.data.errors){
                            app.errors.push( resp.response.data.errors[err].toString() );
                        }
                        alert("Could not update your role");
                    });
            }
        }
    }
</script>