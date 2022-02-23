<template>
    <div>
        <div  class="flex justify-center pt-20" v-if="isLoading">
            <hash-loader></hash-loader>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"></th>
                        <th scope="col">Started at</th>
                        <th scope="col">Status</th>
                        <th scope="col">Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="investigation in investigations">
                        <th scope="row">{{investigation.id}}</th>
                        <td>{{investigation.name}}</td>
                        <td>{{investigation.created_at}}</td>
                        <td>
                            <div v-if="investigation.closed_at">
                                Closed
                            </div>
                            <div v-else>
                                Open
                            </div>
                        </td>
                        <td>
                            <router-link :to="{ name: 'investigationShow', params: { id: investigation.id }}">
                                <button type="button" class="btn btn-primary btn-sm">Details</button>
                            </router-link>
                            <button type="button" class="btn btn-secondary btn-sm">Close</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners'

export default {
    data() {
        return {
            isLoading: true,
            investigations: [],
        }
    },

    components: {
        HashLoader,
    },

    methods: {
        loadData: async function (){
            await axios.get('../api/investigation').then(data => {
                this.investigations = data.data
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
