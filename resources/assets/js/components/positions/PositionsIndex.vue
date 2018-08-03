<template>
    <div class="row">
        <div class="form-group">
            <router-link v-if="auth.can.create" :to="{name: 'createPosition'}" class="btn btn-success">New</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Position list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Short name</th>
                        <th>Parent</th>
                        <th>Active</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(position, index) in positions" v-bind:key="position.id">
                        <td>{{ position.name }}</td>
                        <td>{{ position.short_name }}</td>
                        <td v-if="position.parent === null">-</td>
                        <td v-else>{{ position.parent.name }}</td>
                        <td v-if="position.active == 'A'"> <i class="fa fa-eye text-green"></i></td>
                        <td v-else><i class="fa fa-eye-slash text-red"></i></td>
                        <td>
                            <div v-if="position.deleted_at === null">
                            <router-link v-if="auth.can.update" :to="{name: 'editPosition', params: {id: position.id}}" class="btn btn-sm btn-info">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-sm btn-danger"
                               v-if="auth.can.delete"
                               v-on:click="deleteEntry(position.id, index)">
                                Delete
                            </a>
                            </div>
                            <div v-else>
                            <a href="#"
                                class="btn btn-sm btn-warning"
                                v-if="auth.can.restore"
                                v-on:click="restoreEntry(position.id, index)">
                                Restore
                            </a>
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
                positions: [],
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
                        case 'create-position':
                            app.auth.can.create = true;
                            break;
                        case 'update-position':
                            app.auth.can.update = true;
                            break;
                        case 'delete-position':
                            app.auth.can.delete = true;
                            break;
                        case 'restore-position':
                            app.auth.can.restore = true;
                            break;
                        default:
                            break;
                    }
                }
            },
            fetchPaginate(page){
                var app = this;
                axios.get('/api/positions',{
                    params: {
                        page
                    },
                    headers: {
                        'Accept': 'application/json',
		                'Authorization': 'Bearer '+ app.token
                    }
                }).then(function (resp) {
                    app.positions = resp.data.data;
                    app.pageCount = resp.data.meta.last_page;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load positions");
                });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/positions/' + id,{
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer '+ app.token
                            }
                        })
                        .then(function (resp) {
                            app.fetchPaginate(app.current_page);
                        })
                        .catch(function (resp) {
                            alert("Could not delete position" );
                        });
                }
            },
            restoreEntry(id,index) {
                if (confirm("Do you really want to restore it?")) {
                    var app = this;
                    axios.post('/api/positions/' + id + '/restore',null,{
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer '+ app.token
                            }
                        })
                        .then(function (resp) {
                            app.fetchPaginate(app.current_page);
                        })
                        .catch(function (resp) {
                            alert("Could not restore position");
                        });
                }
            }
        }
    }
</script>