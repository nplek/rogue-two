<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Edit Permission</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Name</label>
                            <input type="text" v-model="permission.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Display name</label>
                            <input type="text" v-model="permission.display_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Description</label>
                            <input type="text" v-model="permission.description" class="form-control">
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
    export default {
        mounted() {
            this.getAuthen();
            let app = this;
            let id = app.$route.params.id;
            app.permissionId = id;
            axios.get('/api/permissions/' + id,{
                    headers: {
                        'Accept': 'application/json',
		                'Authorization': 'Bearer '+ app.token
                    }
                })
                .then(function (resp) {
                    app.permission = resp.data.data;
                })
                .catch(function () {
                    alert("Could not load your permission")
                });
        },
        data: function () {
            return {
                errors: [],
                permissionId: null,
                permission: {
                    name: '',
                    display_name:'',
                    description: '',
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
                        case 'create-permission':
                            app.auth.can.create = true;
                            break;
                        case 'update-permission':
                            app.auth.can.update = true;
                            break;
                        case 'delete-permission':
                            app.auth.can.delete = true;
                            break;
                        case 'restore-permission':
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
            saveForm() {
                event.preventDefault();
                var app = this;
                var newPermission = app.permission;
                axios.patch('/api/permissions/' + app.permissionId, newPermission,{
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
                        alert("Could not update your permission");
                    });
            }
        }
    }
</script>