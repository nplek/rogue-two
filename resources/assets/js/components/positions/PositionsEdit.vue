<template>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Edit Position</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Position name</label>
                            <input type="text" v-model="position.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Short name</label>
                            <input type="text" v-model="position.short_name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Parent</label>
                            <select v-model='position.parent_id' class="form-control">
                                <option value=''>Please select ...</option>
                                <option v-for="parent in parents" v-bind:key="parent.id" v-bind:value="parent.id">
                                    {{ parent.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <input type="radio" id="active" value="A" v-model="position.active">
                            <label for="active">Active</label>
                            <input type="radio" id="inactive" value="I" v-model="position.active">
                            <label for="inactive">Inactive</label>
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
            app.positionId = id;
            axios.get('/api/positions')
                .then(function (resp) {
                    app.parents = resp.data.data;
                })
                .catch(function () {
                    alert("Could not load your parents")
                });
            axios.get('/api/positions/' + id)
                .then(function (resp) {
                    app.position = resp.data.data;
                })
                .catch(function () {
                    alert("Could not load your position")
                });
        },
        data: function () {
            return {
                errors: [],
                positionId: null,
                position: {
                    name: '',
                    short_name: '',
                    parent_id:null,
                },
                parents: {
                    id:'',
                    name: '',
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newPosition = app.position;
                axios.patch('/api/positions/' + app.positionId, newPosition)
                    .then(function (resp) {
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        app.errors = [];
                        for (var err in resp.response.data.errors){
                            app.errors.push( resp.response.data.errors[err].toString() );
                        }
                        alert("Could not update your position");
                    });
            }
        }
    }
</script>