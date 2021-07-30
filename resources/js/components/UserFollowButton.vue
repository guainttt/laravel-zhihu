<template>
    <button class="btn  "
            v-text="text"
            v-on:click="follow"
            v-bind:class="{'btn-success':followed,'btn-info':!followed}">
    </button>
</template>

<script>
    export default {
        name: "UserFollowButton",
        props:['user'],
        // mounted是vue中的一个钩子函数,一般在初始化页面完成后,再对dom节点进行相关操作
        mounted(){
            axios.get('/api/user/followers/' + this.user).then(res => {
                this.followed = res.data.followed
            },error => {
                //console.log(error);
                //console.log(error.response.status)
                if(error.response.status==401){
                    this.auth = false
                }

            })
        },
        data(){
            return {
                followed:false ,
                auth:true
            }
        },
        computed:{
            text(){
                if (!this.auth){
                    return '登录后关注'
                }
                return this.followed ? '关注get':'关注ta'
            }
        },

        methods:{
            follow(){
                //alert('Hello')
                axios.post('/api/user/follow',{'user':this.user}).then(res => {
                    this.followed = res.data.followed;
                    console.log(res);
                    console.log(res.data)
                })
            }
        }
    }
</script>

<style scoped>

</style>