<template>
    <div class="row">
        <div class="form-group">
            <router-link :to="{name: 'createRole'}" class="btn btn-success">New</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Role list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Display name</th>
                        <th>Permissions</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(role, index) in roles" v-bind:key="role.id">
                        <td>{{ role.name }}</td>
                        <td>{{ role.display_name }}</td>
                        <td>
                            <span  v-for="(permission) in role.permissions" v-bind:key="permission.id" class="badge bg-green" > {{ permission.display_name }} </span>
                        </td>
                        <td>
                            <router-link :to="{name: 'editRole', params: {id: role.id}}" class="btn btn-sm btn-info">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(role.id, index)">
                                Delete
                            </a>
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
                roles: [],
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
                axios.get('/api/roles',{
                    params: {
                        page
                    }
                }).then(function (resp) {
                    app.roles = resp.data.data;
                    app.pageCount = resp.data.meta.last_page;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load roles");
                });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/roles/' + id)
                        .then(function (resp) {
                            app.roles.splice(index,1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete role" );
                        });
                }
            }
        }
    }
</script>