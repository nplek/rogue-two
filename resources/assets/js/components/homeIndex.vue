<template>
<div>
</div>

</template>

<script>
export default {
        props: {
        },
        data: function () {
            return {
                token:null,
                user: {
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
            //this.getAuthen();
        },
        methods: {
            getAuthen(){
                var app = this;
                let token = document.head.querySelector('meta[name="token"]'); 
                let user = document.head.querySelector('meta[name="user"]');
                let isAdmin = document.head.querySelector('meta[name="isAdmin"]');
                let permissions = document.head.querySelector('meta[name="permissions"]');
                app.token = token.content;
                app.user.name = user.content;
                app.user.isAdmin = isAdmin.content;
                let content = permissions.content;
                var objs = JSON.parse(content);
                for (var index in objs){
                    var permission = objs[index].name;
                    switch(permission) {
                        case 'create-user':
                            app.user.can.create = true;
                            break;
                        case 'update-user':
                            app.user.can.update = true;
                            break;
                        case 'delete-user':
                            app.user.can.update = true;
                            break;
                        case 'restore-user':
                            app.user.can.update = true;
                            break;
                        default:
                            break;
                    }
                }
            }
        }
}
</script>