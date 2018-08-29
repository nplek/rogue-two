<template>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>Inventories list</h4></div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Whs</th>
                        <th>Itemcode</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item) in inventories" v-bind:key="item.id">
                        <td>{{ item.warehouse.whs_code }}-{{ item.warehouse.whs_name }}</td>
                        <td>{{ item.itemcode }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.dscription }}</td>
                        <td ><span class="pull-right">{{ item.remain_qty | toQty }}</span></td>
                        <td>{{ item.unit_name }}</td>
                        <td>
                            <div>
                                <router-link :to="{name: 'indexGoodsReceipt', params: {item_id: item.item_id,whs_id: item.warehouse.id}}" class="btn btn-sm btn-info">
                                    View
                                </router-link>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paginate
                    v-model="current_page"
                    :click-handler="fetchPaginate"
                    :pageCount="pageCount"
                    :prev-text="'Prev'"
                    :next-text="'Next'"
                    :container-class="'pagination'"
                    :page-class="'page-item'">
                </paginate>
            </div>
        </div>
    </div>
</template>

<script>
import VuejsPaginate from 'vuejs-paginate'
    export default {
        components: {
            'paginate': VuejsPaginate
        },
        data: function () {
            return {
                inventories: [],
                current_page: 1,
                pageCount:0,
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
        filters: {
            toQty: function(value){
                if (typeof value !== "number") {
                    return value;
                }
                var formatter = new Intl.NumberFormat("th-TH",{
                    style: 'decimal',
                    minimumFractionDigits: 0
                });
                return formatter.format(value);
            },
        },
        mounted() {
            this.getAuthen();
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
                        case 'create-inventory':
                            app.auth.can.create = true;
                            break;
                        case 'update-inventory':
                            app.auth.can.update = true;
                            break;
                        case 'delete-inventory':
                            app.auth.can.delete = true;
                            break;
                        case 'restore-inventory':
                            app.auth.can.restore = true;
                            break;
                        default:
                            break;
                    }
                }
            },
            fetchPaginate(page){
                var app = this;
                axios.get('/api/inventories',{
                    params: {
                        page
                    },
                    headers: {
                        'Accept': 'application/json',
		                'Authorization': 'Bearer '+ app.token
                    }
                }).then(function (resp) {
                    app.inventories = resp.data.data;
                    app.pageCount = resp.data.meta.last_page;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load itemunits");
                });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/inventories/' + id,{
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer '+ app.token
                            }
                        })
                        .then(function (resp) {
                            //app.users.splice(index,1);
                            app.fetchPaginate(app.current_page);
                        })
                        .catch(function (resp) {
                            alert("Could not delete inventory" );
                        });
                }
            },
            restoreEntry(id,index) {
                if (confirm("Do you really want to restore it?")) {
                    var app = this;
                    axios.post('/api/inventories/' + id + '/restore',null,{
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer '+ app.token
                            }
                        })
                        .then(function (resp) {
                            app.fetchPaginate(app.current_page);
                        })
                        .catch(function (resp) {
                            alert("Could not restore inventories");
                        });
                }
            }
        }
    }
</script>