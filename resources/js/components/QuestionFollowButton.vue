<template>
    <button class="btn  "
            v-text="text"
            v-on:click="follow"
            v-bind:class="{'btn-success':followed,'btn-info':!followed}">
    </button>
</template>

<script>
    export default {
        name: "QuestionFollowButton",
        props:['question','user'],
        mounted(){
           
            axios.post('/api/question/follower',{'question':this.question,'user':this.user}).then(res => {
                this.followed = res.data.followed;
                //console.log(res.data)
            })
        },
        data(){
            return {
                followed:false
            }
        },
        computed:{
            text(){
                return this.followed ? '已关注':'关注该问题'
            }
        },
        
        methods:{
            follow(){
                //alert('Hello')
               axios.post('/api/question/follow',{'question':this.question,'user':this.user}).then(res => {
                    this.followed = res.data.followed;
                    //console.log(res.data)
                })
            }
        }
    }
</script>

<style scoped>

</style>