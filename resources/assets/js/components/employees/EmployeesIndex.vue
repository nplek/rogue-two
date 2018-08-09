<template>
    <div class="row">
        <div class="form-group">
            <router-link v-if="auth.can.create" :to="{name: 'createEmployee'}" class="btn btn-success">New</router-link>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Employee list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Employee code</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Position</th>
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
                        <td>
                            <span v-for="(position,index) in employee.positions" v-bind:key="index" class="badge bg-orange">
                                {{ position.name }}
                            </span>
                        </td>
                        <td>{{ employee.mobile }}</td>
                        <td>{{ employee.phone }}</td>
                        <td v-if="employee.location_id">{{ employee.location.name }}</td>
                        <td v-else>-</td>
                        <td>
                            <router-link v-if="auth.can.view" :to="{name: 'showEmployee', params: {id: employee.id}}" class="btn btn-sm btn-success">
                                View
                            </router-link>
                            <router-link v-if="auth.can.update" :to="{name: 'editEmployee', params: {id: employee.id}}" class="btn btn-sm btn-info">
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
                token:null,
                auth: {
                    name: '',
                    isAdmin: false,
                    can: {
                        view: false,
                        create: false,
                        update: false,
                        delete: false,
                        restore: false,
                    },
                },
            }
        },
        beforeMount(){
            this.getAuthen();
        },
        mounted() {
            this.fetchPaginate();
        },
        methods: {
            getAuthen(){
                var app = this;
                let token = document.head.querySelector('meta[name="token"]'); 
                let user = document.head.querySelector('meta[name="user"]');
                let isAdmin = document.head.querySelector('meta[name="isAdmin"]');
                let permissions = document.head.querySelector('meta[name="permissions"]');
                app.token = token.content;
                app.auth.name = user.content;
                app.auth.isAdmin = isAdmin.content;
                let content = permissions.content;
                var objs = JSON.parse(content);
                for (var index in objs){
                    var permission = objs[index].name;
                    switch(permission) {
                        case 'create-employee':
                            app.auth.can.create = true;
                            break;
                        case 'update-employee':
                            app.auth.can.update = true;
                            break;
                        case 'delete-employee':
                            app.auth.can.delete = true;
                            break;
                        case 'restore-employee':
                            app.auth.can.restore = true;
                            break;
                        default:
                            break;
                    }
                }
            },
            fetchPaginate(page){
                var app = this;
                axios.get('/api/employees',{
                    params: {
                        page
                    },
                    headers: {
                        'Accept': 'application/json',
		                'Authorization': 'Bearer '+ app.token
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