<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Edit User</div>
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
                                <option disabled value="">Please select ...</option>
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
            app.userId = id;
            axios.get('/api/users/' + id)
                .then(function (resp) {
                    app.user = resp.data.data;
                    app.userRoles = [];
                    for (var index in resp.data.data.roles){
                        app.userRoles.push(resp.data.data.roles[index]['id']);
                    }
                    app.user.roles = app.userRoles;
                    app.userPositions = [];
                    for (var index in resp.data.data.positions){
                        app.userPositions.push(resp.data.data.positions[index]['id']);
                    }
                    app.user.positions = app.userPositions;
                })
                .catch(function () {
                    alert("Could not load your user")
                });
            this.getLocationsList();
            this.getRolesList();
            this.getPositionsList();
        },
        data: function () {
            return {
                errors: [],
                userId: null,
                userRoles:[],
                userPositions:[],
                user: {
                    name: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                    location_id: '',
                    active:'',
                    roles:[],
                    positions:[]
                },
                locations:[],
                roles: [],
                positions:[]
            }
        },
        methods: {
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
                axios.patch('/api/users/' + app.userId, newUser)
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