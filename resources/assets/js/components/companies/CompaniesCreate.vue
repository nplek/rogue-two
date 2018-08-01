<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>
 
        <div class="panel panel-default">
            <div class="panel-heading">Create new company</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Company name</label>
                            <input type="text" v-model="company.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Short name</label>
                            <input type="text" v-model="company.short_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <input type="radio" id="active" value="A" v-model="company.active">
                            <label for="active">Active</label>
                            <input type="radio" id="inactive" value="I" v-model="company.active">
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
 
<script>
    export default {
        data: function () {
            return {
                errors: [],
                company: {
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
        mounted() {
            this.getAuthen();
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
                        case 'create-company':
                            app.auth.can.create = true;
                            break;
                        case 'update-company':
                            app.auth.can.update = true;
                            break;
                        case 'delete-company':
                            app.auth.can.delete = true;
                            break;
                        case 'restore-company':
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
                var newCompany = app.company;
                axios.post('/api/companies', newCompany,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
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
                        alert("Could not create your company");
                    });
            }
        }
    }
</script>