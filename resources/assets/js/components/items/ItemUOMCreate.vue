<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link :to="{name: 'showItemUOM', params: {id: itemId}}" class="btn btn-default">
                Back
            </router-link>
        </div>
 
        <div class="panel panel-default">
            <div class="panel-heading">Update UOM</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="form-group">
                        <label for="">Unit</label>
                        <multiselect
                            v-model="uom.mainunit"
                            @input="itemunitChange"
                            :options="itemunits"
                            placeholder="Please select" 
                            label="name" 
                            track-by="id">
                        </multiselect>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Factor Quantity</label>
                            <input type="number" v-model="uom.main_qty" class="form-control">
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
        beforeMount() {
            let app = this;
            let id = app.$route.params.id;
            app.itemId = id;
            app.uom.item_id = id;
        },
        mounted() {
            this.getAuthen();
            this.getItemUnitsList();
        },
        data: function () {
            return {
                errors: [],
                uom:{
                    item_id:'',
                    unit_id:'',
                    main_qty:'',
                },
                itemId: null,
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
            itemunitChange(value,id){
                this.uom.unit_id = value.id;
                this.uom.main_unit = value.name;
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
                var newUOM = app.uom;
                axios.post('/api/items/uom/' + app.itemId , newUOM,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.$router.replace({name: 'showItemUOM', params: {id: app.itemId}});
                    })
                    .catch(function (resp) {
                        app.errors = [];
                        for (var err in resp.response.data.errors){
                            app.errors.push( resp.response.data.errors[err].toString() );
                        }
                        alert("Could not update your UOM");
                    });
            }
        }
    }
</script>