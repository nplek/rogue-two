<template>
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Goods Receipt</h3>
            </div>
            <form v-on:submit="saveForm()" >
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-4 form-group" :class="{ 'has-error': $v.goodsreceipt.ref1.$error }">
                            <label class="control-label">PO Number</label>
                            <input type="text" v-model.trim="$v.goodsreceipt.ref1.$model" class="form-control">
                            <div class="help-block" v-if="!$v.goodsreceipt.ref1.required">Field is required</div>
                        </div>
                        <div class="col-xs-4 form-group">
                            <label class="control-label">Ref</label>
                            <input type="text" v-model="goodsreceipt.ref2" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 form-group" >
                            <label class="control-label">Doc#</label>
                            <input type="text" v-model="goodsreceipt.docnum" class="form-control" disabled>
                        </div>

                        <div class="col-xs-4 form-group" :class="{ 'has-error': $v.goodsreceipt.docdate.$error }">
                            <label class="control-label">Doc date</label>
                            <date-picker v-model.trim="$v.goodsreceipt.docdate.$model" :config="{format: 'DD/MM/YYYY'}" disabled></date-picker>
                            <div class="help-block" v-if="!$v.goodsreceipt.docdate.required">Field is required</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 form-group" :class="{ 'has-error': $v.goodsreceipt.cardcode.$error }">
                            <label class="control-label">Supplier code</label>
                            <multiselect 
                                v-model.trim="$v.goodsreceipt.cardcode.$model"
                                @input="businesspartnerChange"
                                :options="bps" 
                                :custom-label="businesspartnerWithFullName" 
                                placeholder="Please select" 
                                label="name" 
                                track-by="card_code">
                            </multiselect>
                            <div class="help-block" v-if="!$v.goodsreceipt.cardcode.required">Field is required</div>
                        </div>
                        <div class="col-xs-4 form-group" :class="{ 'has-error': $v.goodsreceipt.shipdate.$error }">
                            <label class="control-label">Shipment date</label>
                            <date-picker v-model.trim="$v.goodsreceipt.shipdate.$model" :config="{format: 'DD/MM/YYYY'}"></date-picker>
                            <div class="help-block" v-if="!$v.goodsreceipt.shipdate.required">Field is required</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 form-group" :class="{ 'has-error': $v.goodsreceipt.warehouse.$error }">
                            <label class="control-label">Warehouse code</label>
                            <multiselect 
                                v-model.trim="$v.goodsreceipt.warehouse.$model"
                                @input="warehouseChange"
                                :options="whs" 
                                :custom-label="warehouseWithFullName" 
                                placeholder="Please select" 
                                label="name" 
                                track-by="whs_code">
                            </multiselect>
                            <div class="help-block" v-if="!$v.goodsreceipt.warehouse.required">Field is required</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 form-group" :class="{ 'has-error': $v.goodsreceipt.remark.$error }">
                            <label class="control-label">Remark</label>
                            <input type="text" v-model.trim="$v.goodsreceipt.remark.$model" class="form-control">
                            <div class="help-block" v-if="!$v.goodsreceipt.remark.maxLength">Field must have at most {{ $v.goodsreceipt.remark.$params.maxLength.max }} letters.</div>
                        </div>
                    </div>
                    <hr />
                    <h3> Transactions </h3>
                    <div class="form-group" :class="{ 'has-error': $v.goodsreceipt.transactions.$error }">
                        <label for="">Add Transaction:</label>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#transactionModal">
                            +
                        </button>
                        <div class="help-block" v-if="!$v.goodsreceipt.transactions.required">Transaction is required</div>
                        <!-- Modal -->
                        <div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Transaction</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="">Item code</label>
                                            <input type="hidden" id="txn_item_modal" class="form-control">
                                            <input type="hidden" id="txn_item_id_modal" class="form-control">
                                            <multiselect
                                                v-model="transactions.item"
                                                @input="itemChange"
                                                :options="items" 
                                                :custom-label="itemWithFullName" 
                                                placeholder="Please select" 
                                                label="name" 
                                                track-by="id">
                                            </multiselect>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Transaction name</label>
                                            <input type="text" id="txn_name_modal" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Unit Price</label>
                                            <input type="number" id="txn_price_modal" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Qty</label>
                                            <input type="number" id="txn_qty_modal" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Unit</label>
                                            <input type="hidden" id="txn_unit_modal" class="form-control">
                                            <input type="hidden" id="txn_unit_id_modal" class="form-control">
                                            <multiselect
                                                id="units"
                                                v-model="transactions.itemunit"
                                                @input="itemunitChange"
                                                :options="itemunits"
                                                :searchable="false"
                                                :custom-label="unitWithFullName" 
                                                placeholder="Please select" 
                                                label="name"
                                                track-by="id">
                                            </multiselect>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Discard Transaction</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="saveTransaction()">Save transaction</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Item code</th>
                            <th scope="col">Transaction Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Total Price</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td></td>
                                <td><b>{{ goodsreceipt.total_qty | toQty}}</b></td>
                                <td></td>
                                <td><b>{{ goodsreceipt.total_price | toCurrency }}</b></td>
                                <td></td>
                            </tr>
                        </tfoot>
                        <tbody>
                        <template v-for="txn in transactions">
                            <tr :key="txn.id">
                            <th>{{ txn.id }}</th>
                            <td>{{ txn.item_code }}</td>
                            <td>{{ txn.dscription }}</td>
                            <td>{{ txn.price | toCurrency}} </td>
                            <td>{{ txn.qty | toQty }}</td>
                            <td>{{ txn.unit }}</td>
                            <td>{{ txn.total_price | toCurrency}}</td>
                            <td><button type="button" class="btn btn-danger" v-on:click="deleteTransaction(txn.id)">X</button></td>
                            </tr>
                        </template>
                        </tbody>
                        
                    </table>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button v-if="auth.can.create" class="btn btn-success">Create</button>
                        </div>
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
</template>

<script>
import Multiselect from 'vue-multiselect'
import DatePicker from 'vue-bootstrap-datetimepicker';
import { required, minLength, maxLength } from 'vuelidate/lib/validators';
    export default {
        components: {
            'multiselect': Multiselect,
            'date-picker': DatePicker ,
        },
        data: function () {
            return {
                errors: [],
                goodsreceipt: {
                    docnum:'',
                    docdate:new Date(),
                    shipdate:new Date(),
                    card_id:'',
                    cardcode:'',
                    card_code:'',
                    card_name:'',
                    project:'',
                    project_code:'',
                    warehouse:'',
                    whs_code:'',
                    total_price: 0,
                    total_qty: 0,
                    remark:'',
                    ref1:'',
                    ref2:'',
                    transactions:[],
                },
                transactions: [],
                items: [],
                itemunits:[],
                projects: [],
                whs:[],
                bps:[],
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
        validations: {
            goodsreceipt: {
                docdate: {
                    required,
                },
                shipdate: {
                    required,
                },
                cardcode: {
                    required,
                },
                ref1: {
                    required,
                    maxLength: maxLength(20)
                },
                remark: {
                    maxLength: maxLength(200)
                },
                warehouse:{
                    required
                },
                transactions:{
                    required
                }
            }
        },
        beforeMount(){
            this.getAuthen();
        },
        mounted() {
            this.getDocNum();
            //this.getItemUnitsList();
            this.getItemsList();
            //this.getProjectsList();
            this.getBpsList();
            this.getWhsList();
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
            businesspartnerWithFullName({card_code,card_name}){
                return `${card_code} — ${card_name}`
            },
            businesspartnerChange(value,id){
                var app = this;
                app.goodsreceipt.card_id = value.id;
                app.goodsreceipt.card_code = value.card_code;
                app.goodsreceipt.card_name = value.card_name;
            },
            warehouseWithFullName({whs_code,whs_name}){
                return `${whs_code} — ${whs_name}`
            },
            warehouseChange(value,id){
                var app = this;
                app.goodsreceipt.whs_id = value.id;
                app.goodsreceipt.whs_code = value.whs_code;
            },
            projectWithFullName({project_id,name}){
                return `${project_id} — ${name}`
            },
            projectChange(value,id){
                var app = this;
                app.goodsreceipt.project_id = value.id;
                app.goodsreceipt.project_code = value.project_id;
            },
            itemWithFullName({item_code,name}){
                return `${item_code} — ${name}`
            },
            itemChange(value,id){
                document.getElementById("txn_item_modal").value = value.item_code;
                document.getElementById("txn_item_id_modal").value = value.id;
                document.getElementById("txn_name_modal").value = value.description;
                //this.itemunits=[];
                this.itemunits=null;
                this.itemunits = value.units;
                document.getElementById("units").selected = 0;
            },
            unitWithFullName({name,tname}){
                return `${name} — ${tname}`
            },
            itemunitChange(value,id){
                document.getElementById("txn_unit_modal").value = value.name;
                document.getElementById("txn_unit_id_modal").value = value.id;
            },
            getDocNum(){
                let app = this;
                axios.post('/api/goodsreceipts/docnum',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.goodsreceipt.docnum = resp.data.data.docnum;
                    })
                    .catch(function () {
                        alert("Could not load your docnum.")
                    });
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
            getItemsList(){
                let app = this;
                axios.post('/api/items/list',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.items = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your items.")
                    });
            },
            getProjectsList(){
                let app = this;
                axios.post('/api/projects/list',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.projects = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your projects.")
                    });
            },
            getBpsList(){
                let app = this;
                axios.post('/api/bps/list',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.bps = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your bps.")
                    });
            },
            getWhsList(){
                let app = this;
                axios.post('/api/whs/list',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.whs = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your whs.")
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
            saveForm() {
                event.preventDefault();
                var app = this;
                var newGoods = app.goodsreceipt;
                newGoods.transactions = app.transactions;
                app.$v.$touch();
                if (app.$v.$invalid){
                    return;
                } else {
                    axios.post('/api/goodsreceipts', newGoods,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + app.token
                        }
                    })
                    .then(function (resp) {
                        app.$router.push({path: '/'});
                        //goto show page.
                    })
                    .catch(function (resp) {
                        app.errors = [];
                        app.errors.push(resp.response.data.message);
                        for (var err in resp.response.data.errors){
                            app.errors.push( resp.response.data.errors[err].toString() );
                        }
                        alert("Could not create your goods reciept");
                    });
                }
            },
            saveTransaction() {
                // append data to the arrays
                let item_id = document.getElementById("txn_item_id_modal").value;
                let item_code = document.getElementById("txn_item_modal").value;
                let name = document.getElementById("txn_name_modal").value;
                let price = document.getElementById("txn_price_modal").value;
                let qty = document.getElementById("txn_qty_modal").value;
                let unit_id = document.getElementById("txn_unit_id_modal").value;
                let unit = document.getElementById("txn_unit_modal").value;
                let total_price = price * qty;
                
                if( name.length != 0 && price > 0 && qty > 0 && unit.length !=0){
                    this.transactions.push({
                        id: this.nextTxnId,
                        item_code: item_code,
                        dscription: name,
                        price: price,
                        qty: qty,
                        unit: unit,
                        total_price: total_price,
                        item_id: item_id,
                        unit_id: unit_id,
                    });
                    this.nextTxnId++;
                    this.calcTotal();
                    // clear their values
                    document.getElementById("txn_item_modal").value = "";
                    document.getElementById("txn_name_modal").value = "";
                    document.getElementById("txn_price_modal").value = "";
                    document.getElementById("txn_qty_modal").value = "";
                    document.getElementById("txn_unit_modal").value = "";
                }
            },
            deleteTransaction(id) {
                let newList = this.transactions.filter(function(el) {
                    return el.id !== id;
                });
                this.nextTxnId--;
                this.transactions = newList;
                this.updateTransaction();
                this.calcTotal();
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
            updateTransaction(){
                var app = this;
                app.nextTxnId = 1;
                var newList = [];
                app.transactions.forEach(function(value, key){
                    value.id = app.nextTxnId;
                    app.nextTxnId++;
                    newList.push(value);
                });
                this.transactions = newList;
            }
        }
    }
</script>