<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Edit Team</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Name</label>
                            <input type="text" v-model="team.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Display name</label>
                            <input type="text" v-model="team.display_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Description</label>
                            <input type="text" v-model="team.description" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
                <p v-if="errors.length" class="text-red">
                    <b>Please correct the following error(s):</b>
                    <ul>
                    <li v-for="(error,index ) in errors" v-bind:key="index" >{{ error }}</li>
                    </ul>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.teamId = id;
            axios.get('/api/teams/' + id)
                .then(function (resp) {
                    app.team = resp.data.data;
                })
                .catch(function () {
                    alert("Could not load your team")
                });
        },
        data: function () {
            return {
                errors: [],
                teamId: null,
                team: {
                    name: '',
                    display_name:'',
                    description: '',
                },
            }
        },
        methods: {
            getteamsList(){
                let app = this;
                axios.post('/api/teams/list')
                    .then(function (resp) {
                        app.teams = resp.data.data;
                    })
                    .catch(function () {
                        alert("Could not load your teams")
                    });
            },
            saveForm() {
                event.preventDefault();
                var app = this;
                var newTeam = app.team;
                axios.patch('/api/teams/' + app.teamId, newTeam)
                    .then(function (resp) {
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        app.errors = [];
                        for (var err in resp.response.data.errors){
                            app.errors.push( resp.response.data.errors[err].toString() );
                        }
                        alert("Could not update your team");
                    });
            }
        }
    }
</script>