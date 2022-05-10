<template>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div v-if="isLoading">
            <hash-loader></hash-loader>
        </div>
        <div v-else class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Grade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="content">Grade Name</label>
                    <input class="form-control" type="text" id="content" rows="3" v-model="tariff.name"/>
                </div>
                <div class="form-group">
                    <label for="content">Fine ($)</label>
                    <input class="form-control" type="text" id="content" rows="3" v-model="tariff.fine"/>
                </div>
                <div class="form-group">
                    <label for="content">Jail (m)</label>
                    <input class="form-control" type="text" id="content" rows="3" v-model="tariff.jail"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" @click.prevent="onSubmit" data-dismiss="modal" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</template>

<script>
import {HashLoader} from "@saeris/vue-spinners";


export default {
    name: "AdminTariffForm",
    data() {
        return {
            isLoading: true,
            tariff: {
                name: '',
                jail: 0,
                fine: 0,
            },
        }
    },
    props: ['id'],

    components: {
        HashLoader
    },

    methods: {
        loadData: async function(){
            if (this.id){
                this.isLoading = true;
                await axios.get('/api/admin/tariff/'+this.id).then(data => {
                    this.tariff = data.data
                }).catch(error => {
                    console.log(error)
                }).finally(() => {
                    this.isLoading = false
                })
            }else{
                this.tariff.name = '';
                this.tariff.jail = 0;
                this.tariff.fine = 0;
                this.isLoading = false;
            }
        },
        onSubmit: async function(){
            let url;
            this.id ?
                url = '/api/admin/tariff/'+this.id :
                url = '/api/admin/tariff';
            console.log(url)
            await axios.post(url, {
                data: this.tariff
            }).then(data => {
                console.log(data)
            }).catch(error => {
                console.log(error)
            }).finally(() => {
                this.isLoading = false;
                this.$emit('clicked');
            })
        }
    },

    watch: {
        id: {
            handler: async function() {
                await this.loadData();
            },
        }
    },

    async mounted(){
        if(this.id){
            await this.loadData()
        }else{
            this.isLoading = false
        }
    }
}
</script>

<style scoped>

</style>
