<template>
    <div class="row">
        <div class="form-group">
            <router-link :to="{name: 'createPosition'}" class="btn btn-success">New</router-link>
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
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(position, index) in positions" v-bind:key="position.id">
                        <td>{{ position.name }}</td>
                        <td>{{ position.short_name }}</td>
                        <td v-if="position.parent === null"></td>
                        <td v-else>{{ position.parent.name }}</td>
                        <td>
                            <div v-if="position.deleted_at === null">
                            <router-link :to="{name: 'editPosition', params: {id: position.id}}" class="btn btn-sm btn-info">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(position.id, index)">
                                Delete
                            </a>
                            </div>
                            <div v-else>
                            <a href="#"
                                class="btn btn-sm btn-warning"
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
            }
        },
        mounted() {
            this.fetchPaginate();
            
        },
        methods: {
            fetchPaginate(page){
                var app = this;
                axios.get('/api/positions',{
                    params: {
                        page
                    }
                }).then(function (resp) {
                    app.positions = resp.data.data;
                    app.pageCount = resp.data.last_page;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load positions");
                });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/positions/' + id)
                        .then(function (resp) {
                            app.positions.splice(index,1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete position" );
                        });
                }
            },
            restoreEntry(id,index) {
                if (confirm("Do you really want to restore it?")) {
                    var app = this;
                    axios.post('/api/positions/restore/' + id)
                        .catch(function (resp) {
                            alert("Could not restore position");
                        });
                    axios.get('/api/positions')
                        .then(function (resp) {
                            app.positions = resp.data;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Could not load positions");
                        });
                }
            }
        }
    }
</script>