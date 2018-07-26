<template>
    <div class="row">
        <div class="form-group">
            <router-link :to="{name: 'createCompany'}" class="btn btn-success">New</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Companies list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Short name</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(company, index) in companies" v-bind:key="company.id" >
                        <td>{{ company.name }}</td>
                        <td>{{ company.short_name }}</td>
                        <td>
                            <div v-if="company.deleted_at === null">
                            <router-link :to="{name: 'editCompany', params: {id: company.id}}" class="btn btn-sm btn-info">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(company.id, index)">
                                Delete
                            </a>
                            </div>
                            <div v-else>
                            <a href="#"
                                class="btn btn-sm btn-warning"
                                v-on:click="restoreEntry(company.id, index)">
                                Restore
                            </a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paginate
                    v-model="current_page"
                    :pageCount="pageCount"
                    :click-handler="fetchPaginate"
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
                companies: [],
                current_page: 1,
                pageCount: 0,
            }
        },
        mounted() {
            this.fetchPaginate();
        },
        methods: {
            fetchPaginate(page = 1){
                var app = this;
                axios.get('/api/companies',{
                    params: {
                        page
                    }
                })
                    .then(function (resp) {
                        app.companies = resp.data.data;
                        app.pageCount = resp.data.last_page;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not load companies");
                    });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/companies/' + id)
                        .then(function (resp) {
                            app.companies.splice(index,1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete company");
                        });
                }
            },
            restoreEntry(id,index) {
                if (confirm("Do you really want to restore it?")) {
                    var app = this;
                    axios.post('/api/companies/restore/' + id)
                        .catch(function (resp) {
                            alert("Could not restore company");
                        });
                    axios.get('/api/companies')
                        .then(function (resp) {
                            app.companies = resp.data;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Could not load companies");
                        });
                }
            }
        }
    }
</script>