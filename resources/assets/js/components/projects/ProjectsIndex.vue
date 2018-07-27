<template>
    <div class="row">
        <div class="form-group">
            <router-link :to="{name: 'createProject'}" class="btn btn-success">New</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Project list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Short name</th>
                        <th>Budget</th>
                        <th>Booked</th>
                        <th>Active</th>
                        <th width="230">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(project, index) in projects" v-bind:key="project.id">
                        <td>{{ project.project_code }}</td>
                        <td>{{ project.name }}</td>
                        <td>{{ project.short_name }}</td>
                        <td>{{ project.budget }}</td>
                        <td>{{ project.book_budget }}</td>
                        <td v-if="project.active == 'A'"> <i class="fa fa-eye text-green"></i></td>
                        <td v-else><i class="fa fa-eye-slash text-red"></i></td>
                        <td>
                            <div v-if="project.deleted_at === null">
                            <router-link :to="{name: 'editProject', params: {id: project.id}}" class="btn btn-sm btn-primary">
                                View
                            </router-link>
                            <router-link :to="{name: 'editProject', params: {id: project.id}}" class="btn btn-sm btn-info">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(project.id, index)">
                                Delete
                            </a>
                            </div>
                            <div v-else>
                            <a href="#"
                                class="btn btn-sm btn-warning"
                                v-on:click="restoreEntry(project.id, index)">
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
                projects: [],
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
                axios.get('/api/projects',{
                    params: {
                        page
                    }
                }).then(function (resp) {
                    app.projects = resp.data.data;
                    app.pageCount = resp.data.last_page;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load projects");
                });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/projects/' + id)
                        .then(function (resp) {
                            //app.projects.splice(index,1);
                            app.fetchPaginate(app.current_page);
                        })
                        .catch(function (resp) {
                            alert("Could not delete project" );
                        });
                }
            },
            restoreEntry(id,index) {
                if (confirm("Do you really want to restore it?")) {
                    var app = this;
                    axios.post('/api/projects/' + id + '/restore')
                        .then(function (resp) {
                            app.fetchPaginate(app.current_page);
                        })
                        .catch(function (resp) {
                            alert("Could not restore project");
                        });
                }
            }
        }
    }
</script>