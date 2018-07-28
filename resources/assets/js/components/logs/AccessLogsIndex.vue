<template>
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">Activity logs list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="150">Created date</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>User</th>
                        <th>Properties</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(log, index) in logs" v-bind:key="log.id">
                        <td>{{ log.created_at }}</td>
                        <td>{{ log.log_name }}</td>
                        <td>{{ log.subject_type }}</td>
                        <td>{{ log.description }}</td>
                        <td>{{ log.causer_id }}</td>
                        <td>{{ log.properties }}</td>
                        <td>
                            <a href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(log.id, index)">
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
                logs: [],
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
                axios.get('/api/logs/accesslogs',{
                    params: {
                        page
                    }
                }).then(function (resp) {
                    app.logs = resp.data.data;
                    app.pageCount = resp.data.meta.last_page;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load logs");
                });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/logs/accesslogs/' + id)
                        .then(function (resp) {
                            app.fetchPaginate(app.current_page);
                        })
                        .catch(function (resp) {
                            alert("Could not delete log" );
                        });
                }
            },
        }
    }
</script>