<template>
    <div class="row">
        <div class="form-group">
            <router-link :to="{name: 'createCompany'}" class="btn btn-success">New</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Companies list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Short name</th>
                        <th>Active</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(company, index) in companies" v-bind:key="company.id" >
                        <td>{{ company.name }}</td>
                        <td>{{ company.short_name }}</td>
                        <td v-if="company.active == 'A'"> <i class="fa fa-eye text-green"></i></td>
                        <td v-else><i class="fa fa-eye-slash text-red"></i></td>
                        <td>
                            <div v-if="company.deleted_at === null">
                            <router-link :to="{name: 'editCompany', params: {id: company.id}}" class="btn btn-sm btn-info">
                                View
                            </router-link>
                            <router-link :to="{name: 'editCompany', params: {id: company.id}}" class="btn btn-sm btn-info">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(company.id, index)">
                                Delete
                            </a>
                            </div>
                            <div v-else>
                            <a href="#"
                                class="btn btn-sm btn-warning"
                                v-on:click="restoreEntry(company.id, index)">
                                Restore
                            </a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paginate
                    v-model="current_page"
                    :pageCount="pageCount"
                    :click-handler="fetchPaginate"
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
                companies: [],
                current_page: 1,
                pageCount: 0,
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
            fetchPaginate(page = 1){
                var app = this;
                axios.get('/api/companies',{
                        params: {
                            page
                        },
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer '+ app.token
                        }
                    })
                    .then(function (resp) {
                        app.companies = resp.data.data;
                        app.pageCount = resp.data.meta.last_page;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not load companies");
                    });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/companies/' + id,{
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer '+ app.token
                            }
                        })
                        .then(function (resp) {
                            app.companies.splice(index,1);
                            //app.fetchPaginate(app.current_page);
                        })
                        .catch(function (resp) {
                            alert("Could not delete company");
                        });
                }
            },
            restoreEntry(id,index) {
                if (confirm("Do you really want to restore it?")) {
                    var app = this;
                    axios.post('/api/companies/' + id + '/restore',null,{
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer '+ app.token
                            }
                        })
                        .then(function (resp){
                            app.fetchPaginate(app.current_page);
                        })
                        .catch(function (resp) {
                            alert("Could not restore company");
                        });
                    
                }
            }
        }
    }
</script>