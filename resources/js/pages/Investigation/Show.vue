<template>
    <div v-if="isLoading" class="container">
        <hash-loader></hash-loader>
    </div>
    <div v-else>
        <div class="row justify-content-between">
            <div class="col-6">
                <h1 class="display-4 mb-4">Investigation</h1>
            </div>
            <div class="col-6">
                <div class="row justify-content-end">
                    <div class="col-8">
                        <button v-if="investigation.closed_at" disabled class="btn btn-secondary">Closed</button>
                        <button v-else @click="close" class="btn btn-secondary">Close</button>
                        <button v-if="investigation.closed_at" disabled type="button" class="btn btn-secondary">
                            Add comment
                        </button>
                        <button v-else type="button" @click="loadCommentModalToggle" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter">
                            Add comment
                        </button>
                        <button v-if="investigation.closed_at" disabled type="button" class="btn btn-secondary">
                            Attach suspects
                        </button>
                        <button type="button" @click="loadSuspectsModalToggle" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter2">
                            Attach suspects
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        Title/Name: {{ investigation.name }}
                    </div>
                    <ul class="list-group list-group-flush">
                        <li style="cursor: default" class="list-group-item">Creator: <small>{{ investigation.creator.name }} {{ investigation.creator.last_name }}</small></li>
                        <li style="cursor: default" class="list-group-item">Create Date: <small>{{ investigation.created_at }}</small></li>
                        <li style="cursor: default" class="list-group-item">Closing Date: <small>{{ investigation.closed_at }}</small></li>
                    </ul>
                </div>
                <div class="card mt-1">
                    <div class="card-header">
                        Assigned Policemans
                    </div>
                    <vuescroll style="height: 270px">
                        <ul class="list-group list-group-flush">
                            <li style="cursor: default" class="list-group-item" v-for="user in investigation.users">{{ user.name }} {{ user.last_name }} <small>{{user.grade.name}}</small></li>
                        </ul>
                    </vuescroll>
                </div>
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                Description
                            </div>
                            <vuescroll style="height: 150px">
                                <div class="card-body">
                                        {{ investigation.desc }}
                                </div>
                            </vuescroll>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                Suspects
                            </div>
                            <ul class="list-group list-group-flush">
                                <vuescroll style="height: 150px">
                                    <li style="cursor: default" v-for="suspect in investigation.suspects" class="list-group-item"> {{suspect.firstname}} {{suspect.lastname}} </li>
                                </vuescroll>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Comments
                            </div>
                            <vuescroll style="height: 250px">
                                <div class="card-body">
                                    <div v-for="comment in investigation.comments">
                                        {{ comment.user.name }}
                                        {{ comment.user.last_name }}
                                        <small>{{ comment.created_at }}</small>
                                        <p>
                                            {{ comment.content }}
                                        </p>
                                        <hr class="my-3">
                                    </div>
                                </div>
                            </vuescroll>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" v-if="loadCommentModal" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <AddCommentModal @clicked="loadData" :id="investigation.id"></AddCommentModal>
        </div>

        <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" v-if="loadSuspectsModal" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <AttachSuspectsModal @clicked="loadData" :id="investigation.id"></AttachSuspectsModal>
        </div>
    </div>
</template>

<script>
import {HashLoader} from "@saeris/vue-spinners";
import vuescroll from 'vuescroll';

import AttachSuspectsModal from "../components/Investigation/AttachSuspectsModal";
import AddCommentModal from "../components/Investigation/AddCommentModal";

export default {
    name: "InvestigationShow",

    data() {
        return {
            investigation: {
                id: this.$route.params.id,
                name: '',
                desc: '',
                type: '',
                created_at: '',
                closed_at: '',
                users: []
            },
            loadSuspectsModal: false,
            loadCommentModal: false,
            isLoading: true
        }
    },

    components: {
        HashLoader,
        vuescroll,
        AttachSuspectsModal,
        AddCommentModal
    },

    methods: {
        loadData: async function() {
            await axios.get('../api/investigation/'+this.investigation.id).then(data => {
                this.investigation = data.data
            }).catch(error => {
                console.log(error)
            }).finally(() => {
                this.isLoading = false
            })
        },
        close: async function() {
            await axios.post('../api/investigation/close', {
                id: this.investigation.id
            }).then(data => {
                this.$notify({
                    title: 'Investigation Closed',
                    text: 'Correctly closed investigation',
                    type: 'success'
                })
            }).catch(error => {
                this.$notify({
                    title: 'Error',
                    text: error,
                    type: 'error'
                })
            })
        },
        loadCommentModalToggle: function (){
            this.loadCommentModal = true
        },
        loadSuspectsModalToggle: function (){
            this.loadSuspectsModal = true
        }
    },

    async mounted() {
        await this.loadData();
    }
}
</script>
