<template>
    <div v-if="isLoading" class="container">
        <hash-loader></hash-loader>
    </div>
    <div v-else>
        <div class="row justify-content-between">
            <div class="col-6">
                <h1 class="display-4 mb-4">Investigation</h1>
            </div>
            <div class="col-5">
                <div class="row justify-content-end">
                    <div class="col-8">
                        <button v-if="investigation.closed_at" disabled class="btn btn-secondary mt-4">Closed</button>
                        <button v-else @click="close" class="btn btn-secondary mt-4">Close</button>
                        <button class="btn btn-primary mt-4">Add comment</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card d-inline-block" style="width: 16rem;">
            <div class="card-body">
                <h5 class="card-title">Name</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ investigation.name }}</h6>
            </div>
        </div>
        <div class="card d-inline-block" style="width: 16rem;">
            <div class="card-body">
                <h5 class="card-title">Creator</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ investigation.creator.name }} {{ investigation.creator.last_name }}</h6>
            </div>
        </div>
        <div class="card d-inline-block" style="width: 16rem;">
            <div class="card-body">
                <h5 class="card-title">Create Date</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ investigation.created_at }}</h6>
            </div>
        </div>
        <div class="card d-inline-block" style="width: 16rem;" v-if="investigation.closed_at">
            <div class="card-body">
                <h5 class="card-title">Close Date</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ investigation.closed_at }}</h6>
            </div>
        </div>
        <div class="card d-inline-block" style="width: 19rem;">
            <div class="card-body">
                <h5 class="card-title">Description</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ investigation.desc }}</h6>
            </div>
        </div>
        <div class="card d-inline-block" style="width: 19rem;">
            <div class="card-body">
                <h5 class="card-title">Assigned Policemans</h5>
                <h6 class="card-subtitle mb-2 text-muted" v-for="user in investigation.users">{{ user.name }} {{ user.last_name }}</h6>
            </div>
        </div>

    </div>
</template>

<script>
import {HashLoader} from "@saeris/vue-spinners";

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
            isLoading: true
        }
    },

    components: {
        HashLoader
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
        }
    },

    async mounted() {
        await this.loadData();
    }
}
</script>
