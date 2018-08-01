<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>
 
        <div class="panel panel-default">
            <div class="panel-heading">Create new User</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">User name</label>
                            <input type="text" v-model="user.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Email</label>
                            <input type="text" v-model="user.email" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Password</label>
                            <input type="password" v-model="user.password" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Confirm Password</label>
                            <input type="password" v-model="user.password_confirmation" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">First name</label>
                            <input type="text" v-model="user.first_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Last name</label>
                            <input type="text" v-model="user.last_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Location</label>
                            <select v-model='user.location_id' class="form-control">
                                <option value="">Please select ...</option>
                                <option v-for="location in locations" v-bind:key="location.id" v-bind:value="location.id">
                                    {{ location.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Positions</label>
                            <div v-for="(position) in positions" v-bind:key="position.id"> 
                                <input type="checkbox" v-model="user.positions" :value="position.id">
                                {{ position.name }} 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-grop" >
                            <label class="control-label">Roles</label>
                                <div v-for="(role) in roles" v-bind:key="role.id"> 
                                    <input type="checkbox" v-model="user.roles" :value="role.id">
                                    {{ role.display_name }} 
                                </div>
                            <br/>
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
            console.log("User Create");
            $this.getAuthen();
            /*this.getLocationsList();
            this.getRolesList();
            this.getPositionsList();*/
        },
        data: function () {
            return {
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
                errors: [],
                user: {
                    name: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                    location_id: '',
                    active:'',
                    roles:[],
                },
                locations:[],
                roles: [],
                positions: [],
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
                            app.auth.can.update = true;
                            break;
                        case 'restore-user':
                            app.auth.can.update = true;
                            break;
                        default:
                            break;
                    }
                }
            },
            getLocationsList(){
                let app = this;
                axios.post('/api/locations/list')
                    .then(function (resp) {
                        app.locations = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your location")
                    });
            },
            getRolesList(){
                let app = this;
                axios.post('/api/roles/list')
                    .then(function (resp) {
                        app.roles = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your roles")
                    });
            },
            getPositionsList(){
                let app = this;
                axios.post('/api/positions/list')
                    .then(function (resp) {
                        app.positions = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your roles")
                    });
            },
            saveForm() {
                event.preventDefault();
                var app = this;
                var newUser = app.user;
                axios.post('/api/users', newUser)
                    .then(function (resp) {
                        app.$router.push({path: '/'});
                    })
                    .catch(function (resp) {
                        app.errors = [];
                        for (var err in resp.response.data.errors){
                            app.errors.push( resp.response.data.errors[err].toString() );
                        }
                        alert("Could not create your user");
                    });
            }
        }
    }
</script>