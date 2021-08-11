<template>
    <div>
        <button
                class="btn btn-success float-right"
                @click="showSendMessageFrom"
        >发送私信
        </button>

        <div class="modal fade" id="modal-send-message" tabindex="-1" role="dia1og">
            <form id="form">
                <div Class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 Class="modal-title">
                                发送私信
                            </h4>
                            <button type="button" class="close" data-dismiss= "modal" aria-hidden="true" >&times;</button>
                        </div>
                        <div class= "modal-body">
                            <textarea id="message_text" name="body" class="form-control" rows="5" v-model="body" v-if="!status"></textarea>
                            <div class="alert alert-success" v-if="status">
                                <strong>私信发送成功</strong>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default " data-dismiss= "modal" >关闭</button>
                            <button type="button" class="btn btn-primary" @click="store">确认发送</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</template>
<script>
    export default {
        name: 'SendMessage',
        props: ['user'],
        data(){
            return {
                body: '',
                status: false
            }
        },
        methods: {
            store(){
                axios.post('/api/message/store',{'user':this.user,'body':this.body}).then(res => {
                    this.status = res.data.status
                    let that = this;
                    setTimeout(function() {
                        $('#modal-send-message').modal('hide')
                        that.status = false
                    },1000)
                })
            },
            showSendMessageFrom(){
                $('#modal-send-message').modal('show')
            }
        } ,
        mounted(){
            // 隐藏模态框 清空内容
            $('#modal-send-message').on('hidden.bs.modal', function (){
                document.getElementById("form").reset();
                //$('#message_text').val("");
            });
        }
    }
</script>

<style lang="css" scoped>
    .float-right{
        float: right;
    }
</style>