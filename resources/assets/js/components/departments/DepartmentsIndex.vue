<template>
    <div class="row">
        <div class="form-group">
            <router-link :to="{name: 'createDepartment'}" class="btn btn-success">New</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Department list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Short name</th>
                        <th>Company</th>
                        <th>Active</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(department, index) in departments" v-bind:key="department.id">
                        <td>{{ department.name }}</td>
                        <td>{{ department.short_name }}</td>
                        <td>{{ department.company.name }}</td>
                        <td v-if="department.active == 'A'"> <i class="fa fa-eye text-green"></i></td>
                        <td v-else><i class="fa fa-eye-slash text-red"></i></td>
                        <td>
                            <div v-if="department.deleted_at === null">
                            <router-link :to="{name: 'editDepartment', params: {id: department.id}}" class="btn btn-sm btn-info">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(department.id, index)">
                                Delete
                            </a>
                            </div>
                            <div v-else>
                            <a href="#"
                                class="btn btn-sm btn-warning"
                                v-on:click="restoreEntry(department.id, index)">
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
                departments: [],
                current_page: 1,
                pageCount:0,
            }
        },
        mounted() {
            this.fetchPaginate();
        },
        methods: {
            fetchPaginate(page = 1){
                var app = this;
                axios.get('/api/departments/', {
                    params: {
                        page
                    }
                }).then((resp) => {
                    app.departments = resp.data.data;
                    app.pageCount = resp.data.meta.last_page;
                });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/departments/' + id)
                        .then(function (resp) {
                            //app.departments.splice(index,1);
                            app.fetchPaginate(app.current_page)
                        })
                        .catch(function (resp) {
                            alert("Could not delete department");
                        });
                }
            },
            restoreEntry(id,index) {
                if (confirm("Do you really want to restore it?")) {
                    var app = this;
                    axios.post('/api/departments/' + id + '/restore')
                        .then(function (resp) {
                            app.fetchPaginate(app.current_page)
                        })
                        .catch(function (resp) {
                            alert("Could not restore department");
                        });
                }
            }
        }
    }
</script>