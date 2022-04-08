<template>
    <div>
        <div v-if="isLoading">
            <hash-loader></hash-loader>
        </div>
        <div v-else>
            <div class="row justify-content-between">
                <div class="col-6">
                    <h1 class="h1 mb-4">Character Data</h1>
                </div>
                <div class="col-2">
                    <div class="row justify-content-end">
                        <div class="col-12">
                            <button type="button" v-if="character.wanted[0]" class="btn btn-danger" @click="destroyWanted">
                                Unmark Wanted
                            </button>
                            <button type="button" v-else class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">
                                Mark as Wanted
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-header">
                            Name: {{character.firstname}} {{character.lastname}}
                        </div>
                        <ul class="list-group list-group-flush">
                            <li style="cursor: default" class="list-group-item">DOB: <small>{{character.dateofbirth}}</small></li>
                            <li style="cursor: default" class="list-group-item">SEX: <small>{{character.sex}}</small></li>
                            <li style="cursor: default" class="list-group-item">JOB: <small>{{character.job}}</small></li>
                        </ul>
                    </div>
                    <div v-if="character.wanted[0]" class="card text-white bg-danger mt-1">
                        <div class="card-header">
                            Wanted status
                        </div>
                        <div class="card-body ">
                            <p class="text-center">Wanted</p>
                            <p class="text-center">Marked by:: {{character.wanted[0].user.name}} {{character.wanted[0].user.last_name}}</p>
                            <p class="text-center">Reason: {{character.wanted[0].reason}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    Crimes
                                </div>
                                <ul v-if="character.crimes[0]" class="list-group list-group-flush">
                                    <li v-for="crime in character.crimes.slice(0,5)" style="cursor: default" class="list-group-item justify-content-between d-flex flex-md-row">
                                        <p class="text-left inline-block">{{crime.desc}}</p>
                                        <p class="text-right inline-block"><small>Jail: {{crime.jail}} | Fine: {{crime.fine}}$</small></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    Suspected at Investigations
                                </div>
                                <ul v-if="character.crimes[0]" class="list-group list-group-flush">
                                    <li v-for="investigation in character.investigations.slice(0,5)" style="cursor: default" class="list-group-item justify-content-between d-flex flex-md-row">
                                        <p class="text-left inline-block">{{investigation.name}}</p>
                                        <p class="text-right inline-block"><small>Created at: {{investigation.created_at}}</small></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <WantedModal @clicked="loadData" :id="character.id"></WantedModal>
        </div>
    </div>
</template>

<script>
import {HashLoader} from "@saeris/vue-spinners";
import WantedModal from "../../components/Character/WantedModal";

export default {
    data() {
        return {
            isLoading: true,
            character: {},
        }
    },

    components: {
        HashLoader,
        WantedModal
    },

    methods: {
        loadData: async function (){
            await axios.get('/../api/characters/' + this.$route.params.id).then(data => {
                this.character = data.data
            }).catch(error => {
                console.log(error)
            }).finally(() => {
                this.isLoading = false
            })
        },
        destroyWanted: async function(){
            await axios.post('/../api/wanted-destroy', {
                id: this.character.wanted[0].id,
            }).then(async () => {
                this.$notify({
                    title: 'Success',
                    text: 'Succesful attached suspects!',
                    type: 'success'
                })
                this.character.wanted = []
            }).catch(error => {
                this.$notify({
                    title: 'Error',
                    text: error,
                    type: 'error'
                })
            })
        }
    },

    async mounted() {
        await this.loadData();
    }
}
</script>

<style scoped>

</style>
