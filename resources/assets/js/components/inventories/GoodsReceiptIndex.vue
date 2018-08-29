<template>
    <div class="row">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Goods receipt</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Doc#</th>
                        <th>Type</th>
                        <th>Itemcode</th>
                        <th>Name</th>
                        <th>Shipdate</th>
                        <th><span class="pull-right">Qty</span></th>
                        <th>Unit</th>
                        <th><span class="pull-right">Factor Qty</span></th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item) in goodsreceipts" v-bind:key="item.id">
                        <td>{{ item.docnum }}</td>
                        <template v-if="item.doctype === 'G'">
                            <td>
                                <i class="fa fa-sign-in text-success" alt="Goods receipt"></i>
                            </td>
                        </template>
                        <template v-else-if="item.doctype === 'P'">
                            <td>
                            <i class="fa fa-sign-out text-warning" alt="Goods receipt PO"></i>
                            </td>
                        </template>
                        <template v-else-if="item.doctype === 'I'">
                            <td>
                            <i class="fa fa-sign-out text-warning" alt="Goods Issue"></i>
                            </td>
                        </template>
                        <template v-else-if="item.doctype === 'R'">
                            <td>
                            <i class="fa fa-sign-out text-warning" alt="Goods Return"></i>
                            </td>
                        </template>
                        <template v-else-if="item.doctype === 'r'">
                            <td>
                            <i class="fa fa-sign-out text-warning" alt="Return Item"></i>
                            </td>
                        </template>
                        <template v-else-if="item.doctype === 'T'">
                            <td>
                            <i class="fa fa-sign-out text-warning" alt="Transfer"></i>
                            </td>
                        </template>
                        <template v-else>
                            <td>
                            <span class="text-danger">
                                Unknown
                            </span>
                            </td>
                        </template>
                        <td>{{ item.itemcode }}</td>
                        <td>{{ item.dscription }}</td>
                        <td>{{ item.shipdate }}</td>
                        <td ><span class="pull-right">{{ item.qty | toQty }}</span></td>
                        <td>{{ item.unit }}</td>
                        <td><span class="pull-right">{{ item.factor_qty | toQty}}</span></td>
                        <td>
                            <div>
                                <router-link :to="{name: 'showGoodsReceipt', params: {id: item.doc_id}}" class="btn btn-sm btn-info">
                                    Show
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
                goodsreceipts: [],
                item_id:'',
                whs_id:'',
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
                let item_id = app.$route.params.item_id;
                let whs_id = app.$route.params.whs_id;
                app.item_id = item_id;
                app.whs_id = whs_id;
                axios.get('/api/goodsreceipts/' + app.item_id + '/items/' + app.whs_id,{
                    params: {
                        page
                    },
                    headers: {
                        'Accept': 'application/json',
		                'Authorization': 'Bearer '+ app.token
                    }
                }).then(function (resp) {
                    app.goodsreceipts = resp.data.data;
                    app.pageCount = resp.data.meta.last_page;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load goodsreceipt");
                });
            },
        }
    }
</script>