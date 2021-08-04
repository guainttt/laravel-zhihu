<template>
    <button class="btn   btn-default"
            v-text="text"
            v-on:click.prevent="vote"
            v-bind:class="{'btn-success':voted}">
    </button>
</template>

<script>
    export default {
        name: "UserVoteButton",
        props:['answer','count'],
        // mounted是vue中的一个钩子函数,一般在初始化页面完成后,再对dom节点进行相关操作
        mounted(){
            axios.post('/api/answer/' + this.answer+'/votes/users').then(res => {
                this.voted = res.data.voted
                console.log(res.data);
            },error => {
                console.log(error);
                //console.log(error.response.status)
                if(error.response.status==401){
                    this.auth = false
                }

            })
        },
        data(){
            return {
                voted:false ,
                auth:true   ,
                count2:this.count
            }
        },
        computed:{
            text(){
                return this.count2
            }
        },

        methods:{
            vote(){
                axios.post('/api/answer/vote',{'answer':this.answer}).then(res => {
                    this.voted = res.data.voted
                    res.data.voted ? this.count2++ : this.count2--
                    console.log(res.data)
                })
            }
            
        }
    }
</script>

<style scoped>

</style>