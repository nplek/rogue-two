<template>
    <div class="row">
        <div class="form-group">
            <router-link :to="{name: 'createLocation'}" class="btn btn-success">New</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Location list</div>
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
                    <tr v-for="(location, index) in locations" v-bind:key="location.id">
                        <td>{{ location.name }}</td>
                        <td>{{ location.short_name }}</td>
                        <td v-if="location.active == 'A'"> <i class="fa fa-eye text-green"></i></td>
                        <td v-else><i class="fa fa-eye-slash text-red"></i></td>
                        <td>
                            <div v-if="location.deleted_at === null">
                            <router-link :to="{name: 'editLocation', params: {id: location.id}}" class="btn btn-sm btn-info">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(location.id, index)">
                                Delete
                            </a>
                            </div>
                            <div v-else>
                            <a href="#"
                                class="btn btn-sm btn-warning"
                                v-on:click="restoreEntry(location.id, index)">
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
                locations: [],
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
                axios.get('/api/locations',{
                    params: {
                        page
                    }
                }).then(function (resp) {
                    app.locations = resp.data.data;
                    app.pageCount = resp.data.meta.last_page;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load locations");
                });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/locations/' + id)
                        .then(function (resp) {
                            //app.locations.splice(index,1);
                            app.fetchPaginate(app.current_page);
                        })
                        .catch(function (resp) {
                            alert("Could not delete location" );
                        });
                }
            },
            restoreEntry(id,index) {
                if (confirm("Do you really want to restore it?")) {
                    var app = this;
                    axios.post('/api/locations/' + id + '/restore')
                        .then(function (resp) {
                            app.fetchPaginate(app.current_page);
                        })
                        .catch(function (resp) {
                            alert("Could not restore location");
                        });
                }
            }
        }
    }
</script>