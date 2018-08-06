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
                            <input type="radio" id="active" value="A" v-model="user.active">
                            <label for="active">Active</label>
                            <input type="radio" id="inactive" value="I" v-model="user.active">
                            <label for="inactive">Inactive</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Employee ID</label>
                            <input type="text" v-model="user.employee_id" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">First Name</label>
                            <input type="text" v-model="user.first_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Last Name</label>
                            <input type="text" v-model="user.last_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Position</label>
                            <select v-model='user.position_id' class="form-control">
                                <option disabled value="">Please select ...</option>
                                <option v-for="position in positions" v-bind:key="position.id" v-bind:value="position.id">
                                    {{ position.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Mobile</label>
                            <input type="text" v-model="user.mobile" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Phone</label>
                            <input type="text" v-model="user.phone" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Location</label>
                            <select v-model='user.location_id' class="form-control">
                                <option disabled value="">Please select ...</option>
                                <option v-for="location in locations" v-bind:key="location.id" v-bind:value="location.id">
                                    {{ location.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Manager</label>
                            <select v-model='user.manager_id' class="form-control">
                                <option disabled value="">Please select ...</option>
                                <option v-for="manager in managers" v-bind:key="manager.id" v-bind:value="manager.id">
                                    {{ manager.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Role</label>
                            <div v-for="(role) in roles" v-bind:key="role.id"> 
                                <input type="checkbox" v-model="user.roles" :value="role.id">
                                {{ role.name }} 
                            </div>
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
            app.userId = id;
            axios.get('/api/users/' + id,{
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer '+ app.token
                    }
                })
                .then(function (resp) {
                    app.user = resp.data.data;
                    app.userRoles = [];
                    for (var index in resp.data.data.roles){
                        app.userRoles.push(resp.data.data.roles[index]['id']);
                    }
                    app.user.roles = app.userRoles;
                    
                })
                .catch(function () {
                    alert("Could not load your user")
                });
            this.getRolesList();
            this.getPositionsList();
            this.getLocationsList();
            this.getManagerList();
        },
        data: function () {
            return {
                errors: [],
                userRoles:[],
                userId: null,
                user: {
                    name: '',
                    email:'',
                    first_name:'',
                    last_name:'',
                    position_id:null,
                    location_id:null,
                    manager_id:null,
                    roles:[]
                },
                roles:[],
                positions:[],
                locations:[],
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
                        alert("Could not load your roles.")
                    });
            },
            getManagerList(){
                let app = this;
                axios.post('/api/users/manager/list',null,{
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