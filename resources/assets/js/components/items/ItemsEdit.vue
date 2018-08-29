<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Edit Item</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Item code</label>
                            <input type="text" v-model="item.item_code" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Name</label>
                            <input type="text" v-model="item.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Description</label>
                            <input type="text" v-model="item.description" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Unit</label>
                        <multiselect
                            v-model="item.mainunit"
                            @input="itemunitChange"
                            :options="itemunits"
                            :custom-label="unitWithFullName" 
                            placeholder="Please select" 
                            label="name" 
                            track-by="id">
                        </multiselect>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <router-link :to="{name: 'showItemUOM', params: {id: itemId}}" class="btn btn-warning">
                                UOM
                            </router-link>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group" >
                            <label class="control-label">UOM : </label>
                            <div v-for="(unit,index) in item.units" v-bind:key="index" >
                                <span v-if="unit.name !=null"  class="badge bg-orange" > 
                                    {{ unit.name }}
                                </span>
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
            'multiselect': Multiselect,
        },
        mounted() {
            this.getAuthen();
            this.getItemUnitsList();
            let app = this;
            let id = app.$route.params.id;
            app.itemId = id;
            axios.get('/api/items/' + id,{
                    headers: {
                        'Accept': 'application/json',
		                'Authorization': 'Bearer '+ app.token
                    }
                })
                .then(function (resp) {
                    app.item = resp.data.data;
                })
                .catch(function () {
                    alert("Could not load your item")
                });
        },
        data: function () {
            return {
                errors: [],
                itemId: null,
                item: {
                    item_code: '',
                    name: '',
                    description: '',
                    main_unit:'',
                    unit_id:'',
                },
                itemunits:[],
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
            unitWithFullName({name,tname}){
                return `${name} — ${tname}`
            },
            itemunitChange(value,id){
                this.item.unit_id = value.id;
                this.item.main_unit = value.name;
            },
            getItemUnitsList(){
                let app = this;
                axios.post('/api/itemunits/list',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.itemunits = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your itemunits.")
                    });
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
                        case 'create-item':
                            app.auth.can.create = true;
                            break;
                        case 'update-item':
                            app.auth.can.update = true;
                            break;
                        case 'delete-item':
                            app.auth.can.delete = true;
                            break;
                        case 'restore-item':
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
                var newItem = app.item;
                axios.patch('/api/items/' + app.itemId, newItem,{
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
                        alert("Could not update your item");
                    });
            }
        }
    }
</script>