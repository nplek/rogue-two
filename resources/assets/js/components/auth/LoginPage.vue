<template>
<div>
    <form v-on:submit="loginForm()">
        <div class="form-group">
            <input type="email" v-model="auth.email" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <span class="help-block">
                <strong>Email error</strong>
            </span>
        </div>
        <div class="form-group">
            <input type="password" v-model="auth.password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <span class="help-block">
                <strong>Password error</strong>
            </span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember"> Remember
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit"
                        class="btn btn-primary btn-block btn-flat">Signin</button>
            </div>
            <!-- /.col -->
        </div>
        <p v-if="errors.length" class="login-box-msg text-red">
            <b>Please correct the following error(s):</b>
            <ul>
            <li v-for="(error,index ) in errors" v-bind:key="index" >{{ error }}</li>
        </ul>
    </p>
    </form>
</div>
</template>

<script>
export default {
        data: function () {
            return {
                errors: [],
                email: null,
                password: null,
                auth: {
                    email: '',
                    password: '',
                }
            }
        },
        mount: function(){
            //
        },
        methods: {
            loginForm() {
                event.preventDefault();
                var app = this;
                var newAuth = app.auth;
                app.errors = [];
                axios.post('/api/login', newAuth)
                    .then(function (resp) {
                        console.log(resp.data);
                        if (reps.status === 200 ){
                            //app.$session.start();
                            //app.$session.set('token', resp.data.success.token);
                            //Vue.http.headers.common['Authorization'] = 'Bearer ' + resp.data.success.token;
                            //window.location.href = '/home';
                        }
                        //app.$router.replace('home/');
                        
                        //app.$router.replace({paht:'/home', redirect: '/'});
                        //window.location.href = '/home';
                    })
                    .catch(function (resp) {
                        /*for (var err in resp.errors){
                            app.errors.push( resp.errors[err].toString() );
                        }*/
                        app.errors.push(resp.error);
                        alert("Could not login.");
                    });
            }
        }
}
</script>