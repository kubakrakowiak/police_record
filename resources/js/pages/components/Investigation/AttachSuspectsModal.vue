<template>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle2">Attach suspects</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div v-if="isLoading" class="flex justify-center py-4">
                <HashLoader></HashLoader>
            </div>
            <div v-else class="modal-body">
                <label class="typo__label">Criminals</label>
                <multiselect v-model="form.characters.value" :options="form.characters.options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick Criminals" label="fullname" track-by="id" :preselect-first="true">
                    <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                </multiselect>
                <pre class="language-json"><code></code></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" @click="onSave" data-dismiss="modal" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners';
import { Multiselect } from 'vue-multiselect';

export default {
    name: "AttachSuspectsModal",

    data() {
        return {
            isLoading: true,
            form:{
                characters: {
                    value: [],
                    options: []
                },
            },
            res: []
        }
    },
    props: ['id'],

    components: {
        HashLoader,
        Multiselect,
    },
    methods:{
        loadCharacters: async function (){
            await axios.get('/../api/characters').then(data => {
                this.form.characters.options = data.data
                this.isLoading = false
            }).catch(error => {
                console.log(error)
            })
        },

        onSave: async function (){
            for (let index in this.form.characters.value){
                this.res.push(this.form.characters.value[index].id)
            }
            await axios.post('/../api/investigation/attach', {
                investigationId: this.id,
                characters: this.res,
            }).then(data => {
                this.$notify({
                    title: 'Success',
                    text: 'Succesful attached suspects!',
                    type: 'success'
                })
            }).catch(error => {
                this.$notify({
                    title: 'Error',
                    text: error.response.data,
                    type: 'error'
                })
            }).finally(() => {
                this.res = []
            })
            this.$emit('clicked')
        }
    },

    async created() {
        await this.loadCharacters();
    }
}
</script>


<style scoped>

</style>
