<template>
    <div class="row">
        <div class="form-group">
            <router-link :to="{name: 'createTeam'}" class="btn btn-success">New</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Team list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Display name</th>
                        <th>Description</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(team, index) in teams" v-bind:key="team.id">
                        <td>{{ team.name }}</td>
                        <td>{{ team.display_name }}</td>
                        <td>{{ team.description }}</td>
                        <td>
                            <router-link :to="{name: 'editTeam', params: {id: team.id}}" class="btn btn-sm btn-info">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(team.id, index)">
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
                teams: [],
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
                axios.get('/api/teams',{
                    params: {
                        page
                    }
                }).then(function (resp) {
                    app.teams = resp.data.data;
                    app.pageCount = resp.data.meta.last_page;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load teams");
                });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/teams/' + id)
                        .then(function (resp) {
                            app.teams.splice(index,1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete team" );
                        });
                }
            }
        }
    }
</script>