<template>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Employee list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Employee code</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Mobile</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(employee) in employees" v-bind:key="employee.id">
                        <td>{{ employee.employee_id }}</td>
                        <td>{{ employee.first_name }}</td>
                        <td>{{ employee.last_name }}</td>
                        <td>{{ employee.mobile }}</td>
                        <td>{{ employee.phone }}</td>
                        <td v-if="employee.location_id">{{ employee.location.name }}</td>
                        <td v-else>-</td>
                        <td>
                            <router-link :to="{name: 'showEmployee', params: {id: employee.id}}" class="btn btn-sm btn-success">
                                View
                            </router-link>
                            <router-link :to="{name: 'editEmployee', params: {id: employee.id}}" class="btn btn-sm btn-info">
                                Edit
                            </router-link>
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
                employees: [],
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
                axios.get('/api/employees',{
                    params: {
                        page
                    }
                }).then(function (resp) {
                    app.employees = resp.data.data;
                    app.pangeCount = resp.data.meta.last_page;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load employees");
                });
            }
        }
    }
</script>