<template>
    <div class="row">
        <div class="form-group">
            <router-link :to="{name: 'editUser', params: {userId: userId}}" class="btn btn-default">
                Back
            </router-link>
            <router-link :to="{name: 'createRoleTeam', params: {uid: userId}}" class="btn btn-success">
                Add
            </router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Role list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Team</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(userrole, index) in user_roles" v-bind:key="index">
                        <td>{{ userrole.user.name }}</td>
                        <td>{{ userrole.role.name }}</td>
                        <td v-if="userrole.team">{{ userrole.team.name }}</td>
                        <td v-else>--Blank--</td>
                        <td>
                            <a v-if="auth.can.update === true" href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(userrole.user_id,userrole.role_id,userrole.team_id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        components: {
        },
        props: {
            tokenId: null,
        },
        data: function () {
            return {
                userId:null,
                user_roles: [],
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
        mounted() {
            this.getAuthen();
            //this.fetchPaginate();
            var app = this;
            let id = app.$route.params.id;
            app.userId = id;
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
                        case 'create-user':
                            app.auth.can.create = true;
                            break;
                        case 'update-user':
                            app.auth.can.update = true;
                            break;
                        case 'delete-user':
                            app.auth.can.delete = true;
                            break;
                        case 'restore-user':
                            app.auth.can.restore = true;
                            break;
                        default:
                            break;
                    }
                }
            },
            fetchPaginate(){
                var app = this;
                axios.get('/api/users/roles/' + app.userId,{
                    headers: {
                        'Accept': 'application/json',
		                'Authorization': 'Bearer '+ app.token
                    }
                }).then(function (resp) {
                    app.user_roles = resp.data.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load users");
                });
            },
            deleteEntry(uid,rid,tid,index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/users/roles/' + uid + '/' + rid + '/' + tid,{
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer '+ app.token
                            }
                        })
                        .then(function (resp) {
                            app.user_roles.splice(index,1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete role" );
                        });
                }
            },
        }
    }
</script>