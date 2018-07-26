<template>
    <div class="row">
        <div class="form-group">
            <router-link :to="{name: 'createUser'}" class="btn btn-success">New</router-link>
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
                        <th>Last login</th>
                        <th>Last login ip</th>
                        <th>Last logout</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(user, index) in users" v-bind:key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.employee_id }} {{ user.first_name }} {{ user.last_name }}</td>
                        <td>{{ user.last_login_at }}</td>
                        <td>{{ user.last_login_ip }}</td>
                        <td>{{ user.last_logout_at }}</td>
                        <td>
                            <div v-if="user.deleted_at === null">
                            <router-link :to="{name: 'editUser', params: {id: user.id}}" class="btn btn-sm btn-info">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(user.id, index)">
                                Delete
                            </a>
                            </div>
                            <div v-else>
                            <a href="#"
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
        data: function () {
            return {
                users: [],
                current_page: 1,
                pageCount:0,
            }
        },
        mounted() {
            this.fetchPaginate();
            
        },
        methods: {
            fetchPaginate(page){
                var app = this;
                axios.get('/api/users',{
                    params: {
                        page
                    }
                }).then(function (resp) {
                    app.users = resp.data.data;
                    app.pageCount = resp.data.last_page;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load users");
                });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/users/' + id)
                        .then(function (resp) {
                            app.users.splice(index,1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete user" );
                        });
                }
            },
            restoreEntry(id,index) {
                if (confirm("Do you really want to restore it?")) {
                    var app = this;
                    axios.post('/api/users/restore/' + id)
                        .catch(function (resp) {
                            alert("Could not restore user");
                        });
                    axios.get('/api/users')
                        .then(function (resp) {
                            app.users = resp.data;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Could not load user");
                        });
                }
            }
        }
    }
</script>