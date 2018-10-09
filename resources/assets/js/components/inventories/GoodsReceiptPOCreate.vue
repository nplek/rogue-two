<template>
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Goods Receipt PO</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-4 form-group" >
                        <label class="control-label">PO Number</label>
                        <div class="input-group">
                            <input type="text" v-model="docnum" class="form-control" v-on:keyup.enter="findPO">
                            <div class="input-group-addon">
                                <a href="#" @click.prevent="findPO"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <form  >
                <div class="box-body" v-if="gpo.ref1">
                    <div class="row">
                        <div class="col-xs-4 form-group" >
                            <label class="control-label">Doc#</label>
                            <input type="text" v-model="gpo.docnum" class="form-control" disabled>
                        </div>

                        <div class="col-xs-4 form-group">
                            <label class="control-label">Doc date</label>
                            <input type="hidden" v-model="gpo.docdate" class="form-control">
                            <date-picker v-model.trim="$v.gpo.docdate.$model" :config="{format: 'DD/MM/YYYY'}" disabled></date-picker>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 form-group" >
                            <label class="control-label">Supplier code</label>
                            <input type="hidden" v-model="gpo.card_code" class="form-control" disabled>
                            <div v-if="gpo.card_name" class="form-control">{{ gpo.card_code + ' ' + gpo.card_name }}</div>
                        </div>
                        <div class="col-xs-4 form-group" :class="{ 'has-error': $v.gpo.shipdate.$error }">
                            <label class="control-label">Shipment date</label>
                            <date-picker v-model.trim="$v.gpo.shipdate.$model" :config="{format: 'DD/MM/YYYY'}"></date-picker>
                            <div class="help-block" v-if="!$v.gpo.shipdate.required">Field is required</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 form-group" :class="{ 'has-error': $v.gpo.warehouse.$error }">
                            <label class="control-label">Warehouse code</label>
                            <multiselect 
                                v-model.trim="$v.gpo.warehouse.$model"
                                @input="warehouseChange"
                                :options="whs" 
                                :custom-label="warehouseWithFullName" 
                                placeholder="Please select" 
                                label="name" 
                                track-by="whs_code">
                            </multiselect>
                            <div class="help-block" v-if="!$v.gpo.warehouse.required">Field is required</div>
                        </div>
                        <div class="col-xs-4 form-group" :class="{ 'has-error': $v.gpo.ref2.$error }">
                            <label class="control-label">Ref</label>
                            <input type="text" v-model.trim="$v.gpo.ref2.$model" class="form-control">
                            <div class="help-block" v-if="!$v.gpo.ref2.required">Field is required</div>
                            <div class="help-block" v-if="!$v.gpo.ref2.maxLength">Field must have at most {{ $v.gpo.ref2.$params.maxLength.max }} letters.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 form-group" :class="{ 'has-error': $v.gpo.remark.$error }">
                            <label class="control-label">Remark</label>
                            <input type="text" v-model.trim="$v.gpo.remark.$model" class="form-control">
                            <div class="help-block" v-if="!$v.gpo.remark.maxLength">Field must have at most {{ $v.gpo.remark.$params.maxLength.max }} letters.</div>
                        </div>
                    </div>
                    <hr />

                    <h3> Transactions </h3>
                    <div class="form-group" >
                    </div>

                    <div class="col-md-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Item code</th>
                            <th scope="col">Transaction Name</th>
                            <th scope="col">Order Qty</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Unit</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="txn in transactions">
                            <tr :key="txn.id">
                            <th>{{ txn.id }}</th>
                            <td>{{ txn.item_code }}</td>
                            <td>{{ txn.dscription }}</td>
                            <td>{{ txn.qty | toQty }}</td>
                            <td><input type="number" v-model="txn.rqty" class="form-control" /></td>
                            <td>{{ txn.unit }}</td>
                            <td>
                                <button type="button" class="btn btn-danger" v-on:click="deleteTransaction(txn.id)">X</button>
                            </td>
                            </tr>
                        </template>
                        </tbody>
                        
                    </table>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button v-if="auth.can.create" class="btn btn-success" v-on:click="saveForm()">Create</button>
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
import Moment from 'moment'
import Multiselect from 'vue-multiselect';
import DatePicker from 'vue-bootstrap-datetimepicker';
import { required, minLength, maxLength } from 'vuelidate/lib/validators';
    export default {
        components: {
            'multiselect': Multiselect,
            'date-picker': DatePicker ,
            'moment': Moment,
            //'autocomplete': Autocomplete,
        },
        data: function () {
            return  {
                purchaseorder: '',
                gpo: {
                    docnum:'',
                    docdate:new Date(),
                    shipdate:new Date(),
                    cardcode:'',
                    card_code:'',
                    card_name:'',
                    warehouse:'',
                    whs_code:'',
                    total_price: 0,
                    total_qty: 0,
                    remark:'',
                    ref1:'',
                    ref2:'',
                    transactions:[],
                },
                dummy:'',
                docnum:'',
                whs:[],
                items:[],
                itemunits:[],
                transactions:[],
                nextTxnId: 1,
                errors: [],
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
        validations: {
            gpo: {
                docdate: {
                    required,
                },
                shipdate: {
                    required,
                },
                card_code: {
                    required,
                },
                ref1: {
                    required,
                    maxLength: maxLength(20)
                },
                ref2: {
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
            toDateTime: function(value){
                if (typeof value !== "date"){
                    return value;
                }
                var formatter = new Intl.DateTimeFormat('th-TH');
                return formatter.format(value);
            },
            toDate: function(value){
                if (value) {
                    return moment(String(value)).format('DD/MM/YYYY')
                }
            }
        },
        beforeMount(){
            this.getAuthen();
            this.getWhsList();
            this.getDocNum();
        },
        methods: {
            unitWithFullName({name,tname}){
                return `${name} — ${tname}`
            },
            itemunitChange(value,id){
                document.getElementById("txn_unit_modal").value = value.name;
                document.getElementById("txn_unit_id_modal").value = value.id;
            },
            warehouseWithFullName({whs_code,whs_name}){
                return `${whs_code} — ${whs_name}`
            },
            warehouseChange(value,id){
                var app = this;
                app.gpo.whs_id = value.id;
                app.gpo.whs_code = value.whs_code;
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
            getDocNum(){
                let app = this;
                axios.post('/api/goodspos/docnum',null,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.dummy = resp.data.data.docnum;
                    })
                    .catch(function () {
                        alert("Could not load your docnum.")
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
            findPO(){
                let app = this;
                axios.get('/api/purchaseorders/docnum/' + app.docnum,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.purchaseorder = resp.data.data;
                        app.gpo.docnum = app.dummy;
                        app.gpo.ref1 = app.purchaseorder.docnum;
                        app.gpo.ref2 = '';
                        app.gpo.remark = app.purchaseorder.pr_no + ' : ' + app.purchaseorder.comments;
                        app.gpo.card_code = app.purchaseorder.cardcode;
                        app.gpo.card_name = app.purchaseorder.cardName;
                        app.gpo.address = app.purchaseorder.address;
                        app.gpo.docdate = new Date();
                        app.gpo.shipdate = new Date();
                        app.gpo.total_price = app.purchaseorder.DocTotal;
                        app.gpo.total_qty = 0;

                        app.nextTxnId = 1;
                        app.transactions=[];
                        app.purchaseorder.items.forEach(function(value, key){
                            value.id = app.nextTxnId;
                            app.transactions.push({
                                id: app.nextTxnId,
                                item_code: value.ItemCode,
                                dscription: value.Dscription,
                                price: value.Price,
                                qty: value.Quantity,
                                rqty: value.Quantity,
                                unit: value.unitMsr2,
                                total_price: value.TotalSumSy,
                                item_id: 0,
                                unit_id: 0,
                            });
                            app.gpo.total_qty = (value.Quantity) + app.gpo.total_qty;
                            app.nextTxnId++;
                        });
                        
                    })
                    .catch(function () {
                        app.gpo =  {
                            docnum:'',
                            docdate:new Date(),
                            shipdate:new Date(),
                            cardcode:'',
                            card_code:'',
                            card_name:'',
                            warehouse:'',
                            whs_code:'',
                            total_price: 0,
                            total_qty: 0,
                            remark:'',
                            ref1:'',
                            ref2:'',
                            transactions:[],
                        };
                        app.transactions=[];
                        alert("PO " +  app.docnum + " not found.")
                    });
            },
            saveForm(){
                this.calcTotal();
                //console.log('Save');
                //console.log(this.gpo);
                //console.log(this.transactions);
                event.preventDefault();
                var app = this;
                var newGoods = app.gpo;
                newGoods.transactions = app.transactions;
                app.$v.$touch();
                if (app.$v.$invalid){
                    return;
                } else {
                    axios.post('/api/goodspos', newGoods,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + app.token
                        }
                    })
                    .then(function (resp) {
                        app.$router.push({path: '/'});
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
                    q_total += parseInt(element.rqty);
                    total += parseInt(element.total_price);
                });
                this.gpo.total_price = total;
                this.gpo.total_qty = q_total;
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