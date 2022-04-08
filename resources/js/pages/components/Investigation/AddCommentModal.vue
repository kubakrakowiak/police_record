<template>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add comment to investigation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="content">Comment</label>
                    <textarea class="form-control" id="content" rows="3" v-model="res"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="onSave">Save changes</button>
            </div>
        </div>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners';

export default {
    name: "AddCommentModal",
    data() {
        return {
            res: ''
        }
    },
    props: ['id'],

    methods:{
        onSave: async function (){
            await axios.post('/../api/investigation/comment', {
                investigationId: this.id,
                content: this.res,
            }).then(data => {
                this.$notify({
                    title: 'Success',
                    text: 'Succesful attached suspects!',
                    type: 'success'
                })
            }).catch(error => {
                this.$notify({
                    title: 'Error',
                    text: error,
                    type: 'error'
                })
            }).finally(() => {
                this.res = []
            })
            this.$emit('clicked')
        }
    }
}
</script>

<style scoped>

</style>
