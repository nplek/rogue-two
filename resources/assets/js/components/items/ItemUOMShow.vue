<template>
    <div class="row">
        <div class="form-group">
            <router-link :to="{name: 'editItem', params: {itemId: itemId}}" class="btn btn-default">
                Back
            </router-link>
            <router-link :to="{name: 'createItemUOM', params: {id: itemId}}" class="btn btn-success">
                Add
            </router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">UOM</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>Unit</th>
                        <th>Factor Qty</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(uom, index) in item_uoms" v-bind:key="index">
                        <td>{{ uom.item.name }}</td>
                        <td>{{ uom.unit.name }}</td>
                        <td>{{ uom.main_qty }}</td>
                        <td>
                            <a v-if="auth.can.update === true" href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(uom, index)" >
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        components: {
        },
        props: {
            tokenId: null,
        },
        data: function () {
            return {
                itemId:null,
                item_uoms: [],
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
        beforeMount(){
            this.getAuthen();
        },
        mounted() {
            var app = this;
            let id = app.$route.params.id;
            app.itemId = id;
            this.fetchPaginate();
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
            fetchPaginate(){
                var app = this;
                axios.get('/api/items/uom/' + app.itemId,{
                    headers: {
                        'Accept': 'application/json',
		                'Authorization': 'Bearer '+ app.token
                    }
                }).then(function (resp) {
                    app.item_uoms = resp.data.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load UOMs");
                });
            },
            deleteEntry(uom,index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    console.log(uom);
                    var item_id = uom.item.id;
                    var unit_id = uom.unit.id;
                    
                    axios.delete('/api/items/uom/' + item_id + '/' + unit_id ,{
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer '+ app.token
                            }
                        })
                        .then(function (resp) {
                            app.item_uoms.splice(index,1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete UOM" );
                        });
                }
            },
        }
    }
</script>