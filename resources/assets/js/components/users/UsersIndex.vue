<template>
    <div class="row">
        <div class="form-group">
            <router-link v-if="auth.can.create" :to="{name: 'createUser'}" class="btn btn-success">New</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">User list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Full name</th>
                        <th>User Roles</th>
                        <th>Last login</th>
                        <th>Last login ip</th>
                        <th>Last logout</th>
                        <th>Active</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(user, index) in users" v-bind:key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td v-if="user.employee != null">{{ user.employee.employee_id }} {{ user.employee.first_name }} {{ user.employee.last_name }}</td>
                        <td v-else>-</td>
                        <td>
                            <div v-for="(rolelist,index) in user.userroles" v-bind:key="index" >
                                <span v-if="rolelist.team"  class="badge bg-green" > 
                                    {{ rolelist.role.name }} - {{ rolelist.team.name }}
                                </span>
                                <span v-else class="badge bg-red">
                                    {{ rolelist.role.name }}
                                </span>
                            </div>
                        </td>
                        <td>{{ user.last_login_at }}</td>
                        <td>{{ user.last_login_ip }}</td>
                        <td>{{ user.last_logout_at }}</td>
                        <td v-if="user.active == 'A'">
                            <a href="#" >
                                <span class="fa-stack">
                                <i class="fa fa-circle fa-stack-2x text-success"></i>
                                <i class="fa fa-user fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </td>
                        <td v-else>
                            <a href="#">
                            <span class="fa-stack">
                            <i class="fa fa-user fa-stack-1x"></i>
                            <i class="fa fa-ban fa-stack-2x text-danger"></i>
                            </span>
                            </a>
                        </td>
                        <td>
                            <div v-if="user.deleted_at === null">
                            <router-link :to="{name: 'editUser', params: {id: user.id}}" class="btn btn-sm btn-info">
                                Edit
                            </router-link>

                            <a v-if="auth.can.delete === true" href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(user.id, index)">
                                Delete
                            </a>
                            <a v-if="auth.can.update === true" href="#"
                               class="btn btn-sm btn-success"
                               v-on:click="passportEntry(user.id, index)">
                                Passport
                            </a>
                            </div>
                            <div v-else>
                            <a href="#"
                                v-if="auth.can.restore"
                                class="btn btn-sm btn-warning"
                                v-on:click="restoreEntry(user.id, index)">
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
        props: {
            tokenId: null,
        },
        data: function () {
            return {
                users: [],
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
                    app.pageCount = resp.data.meta.last_page;
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
            passportEntry(id,index){
                //users/passport
                if (confirm("Do you really want to reset it?")) {
                    var app = this;
                    axios.post('/api/users/passport/' + id ,null,{
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer '+ app.token
                            }
                        })
                        .then(function (resp) {
                            alert("Reset passport success.");
                        })
                        .catch(function (resp) {
                            alert("Could not reset passport");
                        });
                }
            }
        }
    }
</script>