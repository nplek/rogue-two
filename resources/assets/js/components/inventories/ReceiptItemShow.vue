<template>
    <div class="col-xs-12">
        <div>
            <router-link to="/" class="btn btn-sm btn-default">
                Back
            </router-link>
        </div>
        <section class="invoice">
            <div class="row">
                <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> Company, pbl. Warehouse [00000]
                    <small class="pull-right">Doc Date: {{ goodsreceipt.docdate }}</small>
                </h2>
                </div>
                <!-- /.col -->
            </div>
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    From
                    <address>
                        <strong>{{ goodsreceipt.cardcode }}</strong><br>
                        {{ goodsreceipt.cardname }}
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong>{{ goodsreceipt.warehouse.whs_code }}</strong><br>
                        {{ goodsreceipt.warehouse.whs_name }}
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                <b>Doc#: </b> {{ goodsreceipt.docnum }} <br>
                <b>Ref1: </b> {{ goodsreceipt.ref1 }}<br>
                <b>Ref2: </b> {{ goodsreceipt.ref2 }}<br>
                <b>Ref3: </b> {{ goodsreceipt.ref3 }}<br>
                <b>Shipment date: </b> {{ goodsreceipt.shipdate }}<br>
                <b>Remark: </b> {{ goodsreceipt.remark }}<br>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Item code</th>
                            <th scope="col">Transaction Name</th>
                            <th scope="col">Price</th>
                            <th scope="col"><span class="pull-right">Qty</span></th>
                            <th scope="col">Unit</th>
                            <th scope="col">Total Price</th>
                        </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td>Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>{{ goodsreceipt.total_price | toCurrency }}</b></td>
                                <td></td>
                            </tr>
                        </tfoot>
                        <tbody>
                        <template v-for="txn in goodsreceipt.items">
                            <tr :key="txn.id">
                            <td>{{ txn.itemcode }}</td>
                            <td>{{ txn.dscription }}</td>
                            <td>{{ txn.unit_price | toCurrency}}</td>
                            <td><span class="pull-right">{{ txn.qty | toQty }} </span></td>
                            <td>{{ txn.unit }}</td>
                            <td>{{ txn.total_price | toCurrency}}</td>
                            </tr>
                        </template>
                        </tbody>
                        
                    </table>
                </div>
            </div>
            <div class="row no-print">
                <div class="col-xs-12">
                <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                    <i class="fa fa-download"></i> Generate PDF
                </button>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        components: {
        },
        data: function () {
            return {
                errors: [],
                goodsreceipt: {
                    docnum:'',
                    transactions:[],
                },
                transactions: [],
                nextTxnId: 1,
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
                date: new Date(),
                options: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                }
            }
        },
        beforeMount(){
            this.getAuthen();
        },
        mounted() {
            this.getData();
        },
        filters: {
            toCurrency: function(value){
                if (typeof value !== "number") {
                    return value;
                }
                var formatter = new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB',
                    minimumFractionDigits: 2
                });
                return formatter.format(value);
            },
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
            toDateTime: function(value){
                if (typeof value !== "date"){
                    return value;
                }
                var formatter = new Intl.DateTimeFormat('th-TH');
                return formatter.format(value);
            }
        },
        methods: {
            getData(){
                let app = this;
                let id = app.$route.params.id;
                app.goodsId = id;
                axios.get('/api/goodsreceipts/' + id,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.goodsreceipt = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your goodsreceipt")
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
            calcTotal(){
                let q_total = 0;
                let total = 0;
                this.transactions.forEach(element => {
                    q_total += parseInt(element.qty);
                    total += parseInt(element.total_price);
                });
                this.goodsreceipt.total_price = total;
                this.goodsreceipt.total_qty = q_total;
            },
        }
    }
</script>