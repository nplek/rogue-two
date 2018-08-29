<template>
    <div class="row">
        <div class="form-group">
            <router-link v-if="btn_create" :to="{name: 'createUser'}" class="btn btn-success">New</router-link>
            <button v-if="btn_edit" @click="editClick()" class="btn btn-info">Edit</button>
            <button v-if="btn_delete" @click="deleteClick()" class="btn btn-danger">Delete</button>
            <button v-if="btn_restore" v-on:click="restoreClick()" class="btn btn-warning">Restore</button>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">User list [select : {{current_name}}]</div>
            <div class="panel-body">
                <ag-grid-vue style="height: 600px;"
                    class="ag-theme-material"
                    :columnDefs="columnDefs"
                    :rowData="rowData"
                    rowSelection='single'

                    :enableColResize="true"
                    :enableSorting="true"
                    :enableFilter="true"
                    :groupHeaders="true"
                    :suppressRowClickSelection="true"
                    :toolPanelSuppressGroups="true"
                    :toolPanelSuppressValues="true"
                    :gridReady="onReady"
                    :pagination="true"
                    :paginationPageSize="meta.per_page"

                    :rowClicked="onRowClicked"
                    >
                </ag-grid-vue>
            </div>
        </div>
    </div>
</template>

<script>
//import VuejsPaginate from 'vuejs-paginate'
import {AgGridVue} from "ag-grid-vue";
import MomentVue from "vue-moment";
    export default {
        components: {
            //'paginate': VuejsPaginate,
            'ag-grid-vue': AgGridVue,
            'moment': MomentVue
        },
        props: {
            tokenId: null,
        },
        data: function () {
            return {
                users: [],
                rowcount: null,
                current_id: null,
                current_name:null,
                btn_edit:false,
                btn_delete:false,
                btn_restore:false,
                gridOptions: null,
                current_page: 1,
                pageCount:0,
                token:null,
                columnDefs: null,
                rowData: null,
                meta:{
                    per_page:0
                },
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
            this.gridOptions = {};
            this.getAuthen();
            //this.gridOptions.dateComponentFramework = DateComponent;

            this.columnDefs = [
                {headerName: 'Name', field: 'name',filter: 'text'},
                {headerName: 'Email', field: 'email',filter: 'text'},
                {
                    headerName: 'User Roles', 
                    field: 'user_roles',
                    suppressSorting: true,
                    cellRenderer: rolesCellRenderer,
                },
                {headerName: 'Last login', field: 'last_login_at'},
                {headerName: 'Last login IP', field: 'last_login_ip',filter: 'text'},
                {headerName: 'Last logout', field: 'last_logout_at'},
                {
                    headerName: 'Active', 
                    field: 'active',
                    cellRenderer: activeCellRenderer,
                },
                {
                    headerName: 'Deleted',
                    field: 'deleted_at.date',
                    suppressFilter: true,
                    cellRenderer: deletedCellRenderer
                },
            ];
        },
        mounted() {
            this.fetchPaginate();
        },
        methods: {
            activeField(){
                return "A";
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
            fetchPaginate(page){
                var app = this;
                axios.get('/api/users',{
                    params: {
                        page
                    },
                    headers: {
                        'Accept': 'application/json',
		                'Authorization': 'Bearer '+ app.token
                    }
                }).then(function (resp) {
                    app.users = resp.data.data;
                    app.rowData = resp.data.data;
                    app.pageCount = resp.data.meta.last_page;
                    app.meta = resp.data.meta;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load users");
                });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/users/' + id,{
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
                            alert("Could not delete user" );
                        });
                }
            },
            restoreEntry(id,index) {
                if (confirm("Do you really want to restore it?")) {
                    var app = this;
                    axios.post('/api/users/' + id + '/restore',null,{
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer '+ app.token
                            }
                        })
                        .then(function (resp) {
                            app.fetchPaginate(app.current_page);
                        })
                        .catch(function (resp) {
                            alert("Could not restore user");
                        });
                }
            },
            editClick(){
                var app = this;
                app.$router.replace('/admin/users/edit/' + this.current_id);
            },
            deleteClick(){
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/users/' + app.current_id,{
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer '+ app.token
                            }
                        })
                        .then(function (resp) {
                            //app.users.splice(index,1);
                            //app.fetchPaginate(app.current_page);
                            app.fetchPaginate();
                            app.current_id=null;
                            app.current_name=null;
                            app.btn_edit=false;
                            app.btn_delete=false;
                            app.btn_restore=false;
                        })
                        .catch(function (resp) {
                            alert("Could not delete user" );
                        });
                }
            },
            restoreClick(){
                if (confirm("Do you really want to restore it?")) {
                    var app = this;
                    axios.post('/api/users/' + app.current_id + '/restore',null,{
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer '+ app.token
                            }
                        })
                        .then(function (resp) {
                            app.fetchPaginate();
                            app.current_id=null;
                            app.current_name=null;
                            app.btn_edit=false;
                            app.btn_delete=false;
                            app.btn_restore=false;
                        })
                        .catch(function (resp) {
                            alert("Could not restore user");
                        });
                }
            },
            onReady() {
                //this.calculateRowCount();
            },
            onCellClicked(event) {
                //console.log('onCellClicked: ' + event.rowIndex + ' ' + event.colDef.field);
            },
            onRowClicked(event) {
                //console.log('onRowClicked: ' + event.node.data.name + ' id:' + event.node.data.id);
                this.current_id = event.node.data.id;
                this.current_name = event.node.data.name;
                this.btn_edit = false;
                this.btn_delete = false;
                this.btn_restore = false;
                if (this.auth.can.restore == true && event.node.data.deleted_at != null){
                    this.btn_restore = true;
                } else {
                    this.btn_restore = false;
                    if (this.auth.can.update == true && this.current_id != null) {
                        this.btn_edit = true;
                    } else {
                        this.btn_edit = false;
                    }
                    if (this.auth.can.delete == true && this.current_id != null){
                        this.btn_delete = true;
                    } else {
                        this.btn_delete = false;
                    }
                }
                
            },
            calculateRowCount() {
                if (this.gridOptions.api && this.rowData) {
                    let model = this.gridOptions.api.getModel();
                    let totalRows = this.rowData.length;
                    let processedRows = model.getRowCount();
                    this.rowCount = processedRows.toLocaleString() + ' / ' + totalRows.toLocaleString();
                }
            },
        }
    }

    function deletedCellRenderer(params){
        let data = params.data;
        let result= [];
        if (data.deleted_at != null){
            result.push('<span class="badge bg-red">',
                '<i class="fa fa-clock"></i>',
                data.deleted_at.date,
                '</span>');
            return result.join(' ');
        }
    }

    function rolesCellRenderer(params) {
        let data = params.data;
        let result = [];
        result.push('<div>');
        for(var index in data.userroles){
            if (data.userroles[index].team != null){
                result.push('<span class="badge bg-green">' + data.userroles[index].role.name + '-' + data.userroles[index].team.name + '</span>' );
            } else {
                result.push('<span class="badge bg-red">' + data.userroles[index].role.name + '</span>' );
            }
        }
        result.push('</div>');
        return result.join(' ');
    }
    function activeCellRenderer(params) {
        let data = params.data;
        let result = [];
        if (data.active == 'A'){
            result.push('<a href="#">',
            '<span class="fa-stack">',
            '<i class="fa fa-circle fa-stack-2x text-success"></i>',
            '<i class="fa fa-user fa-stack-1x fa-inverse"></i>',
            '</span></a>');
        } else {
            result.push('<a href="#">',
            '<span class="fa-stack">',
            '<i class="fa fa-user fa-stack-1x"></i>',
            '<i class="fa fa-ban fa-stack-2x text-danger"></i>',
            '</span></a>');
        }
        return result.join(' ');
    }
</script>