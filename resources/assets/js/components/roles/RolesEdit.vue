<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Edit Role</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Name</label>
                            <input type="text" v-model="role.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Display name</label>
                            <input type="text" v-model="role.display_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Permissions</label>
                            <multiselect 
                                v-model="role.permissions" 
                                :options="permissions" 
                                :multiple="true" 
                                :close-on-select="false" 
                                :clear-on-select="false" 
                                :hide-selected="true" 
                                :preserve-search="true" 
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
                            <button v-if="auth.can.update" class="btn btn-success">Update</button>
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
import Multiselect from 'vue-multiselect'
    export default {
        components: {
            'multiselect': Multiselect
        },
        mounted() {
            this.getAuthen();
            let app = this;
            let id = app.$route.params.id;
            app.roleId = id;
            axios.get('/api/roles/' + id,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                .then(function (resp) {
                    app.role = resp.data.data;
                    /*app.rolePermissions = [];
                    for (var index in resp.data.data.permissions){
                        app.rolePermissions.push(resp.data.data.permissions[index]['id']);
                    }
                    app.role.permissions = app.rolePermissions;*/
                })
                .catch(function () {
                    alert("Could not load your role")
                });
            this.getPermissionsList();
            this.getTeamsList();
        },
        data: function () {
            return {
                errors: [],
                roleId: null,
                rolePermissions:[],
                role: {
                    name: '',
                    display_name:'',
                    description: '',
                    permissions:[],
                    team:null,
                    team_id:null,
                },
                permissions:[],
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
                app.role.team_id = value.id;
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
                        case 'create-role':
                            app.auth.can.create = true;
                            break;
                        case 'update-role':
                            app.auth.can.update = true;
                            break;
                        case 'delete-role':
                            app.auth.can.delete = true;
                            break;
                        case 'restore-role':
                            app.auth.can.restore = true;
                            break;
                        default:
                            break;
                    }
                }
            },
            getPermissionsList(){
                let app = this;
                axios.post('/api/permissions/list',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.permissions = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your permissions")
                    });
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
            saveForm() {
                event.preventDefault();
                var app = this;
                var newRole = app.role;
                axios.patch('/api/roles/' + app.roleId, newRole,{
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
                        alert("Could not update your role");
                    });
            }
        }
    }
</script>