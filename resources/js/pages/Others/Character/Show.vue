<template>
    <div>
        <div v-if="isLoading">
            <hash-loader></hash-loader>
        </div>
        <div v-else class="row">
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
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Crimes
                            </div>
                            <div class="card-body">
                                test
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Crimes
                            </div>
                            <div class="card-body">
                                test
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Crimes
                            </div>
                            <div class="card-body">
                                test
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {HashLoader} from "@saeris/vue-spinners";

export default {
    data() {
        return {
            isLoading: true,
            character: {},
        }
    },

    components: {
        HashLoader,
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
    },

    async mounted() {
        await this.loadData();
    }
}
</script>

<style scoped>

</style>
