<template>
    <div>
        <div  class="flex justify-center pt-20" v-if="isLoading">
            <hash-loader></hash-loader>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    <input type="text" class="form-control-lg col-5" v-model="filter.name" aria-describedby="emailHelp" placeholder="Enter reason">
                    <div class="col-5">
                        <multiselect v-model="filter.type" deselect-label="Remove this value" track-by="name" label="name" placeholder="Select Type" :options="types" :searchable="true" :allow-empty="true">
                            <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.name }}</strong></template>
                        </multiselect>
                        <span class="text-sm text-red-600 hidden"></span>
                    </div>
                    <div class="col-2"><input type="submit" class="btn btn-info" @click.prevent="onFilterSubmit()" value="Filter"></div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
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
                            <button type="button" @click="close(investigation.id)" class="btn btn-secondary btn-sm">Close</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <button v-if="page-1 > 0" class="btn btn-success mr-1" @click="pageChange(page-1)">Prev</button>
                    <button v-else class="btn btn-success mr-1" disabled>Prev</button>
                    <button v-if="page+1 <= total" class="btn btn-success" @click="pageChange(page+1)">Next</button>
                    <button v-else class="btn btn-success" disabled>Next</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners'
import { Multiselect } from 'vue-multiselect';

export default {
    data() {
        return {
            isLoading: true,
            investigations: [],
            page: 1,
            total: 0,
            per_page: 9,
            types: [
                {
                    name: 'Open',
                    value: '1'
                },
                {
                    name: 'Closed',
                    value: '0'
                }
            ],
            filter: {
                name: '',
                type: {
                    value: ''
                }
            }
        }
    },

    components: {
        HashLoader,
        Multiselect
    },

    methods: {
        loadData: async function (){
            await axios.get('../api/investigation', {
                params: {
                    per_page: this.per_page,
                    page:     this.page,
                    name:     this.filter.name,
                    type:     this.filter.type.value,
                }
            }).then(data => {
                this.investigations = data.data.data
                this.total = Math.ceil(data.data.total / this.per_page)
            }).catch(error => {
                console.log(error)
            }).finally(() => {
                this.isLoading = false
            })
        },
        pageChange: async function(page){
            this.isLoading = true;
            this.page = page
            await this.loadData();
        },
        onFilterSubmit: async function (){
            this.isLoading = true;
            await this.loadData();
        },

        close: async function(id) {
            await axios.post('../api/investigation/close', {
                id: id
            }).then(data => {
                this.$notify({
                    title: 'Investigation Closed',
                    text: 'Correctly closed investigation',
                    type: 'success'
                })
            }).catch(error => {
                this.$notify({
                    title: 'Error',
                    text: error.response.data,
                    type: 'error'
                })
            })
            await this.loadData();
        }
    },

    async mounted() {
        await this.loadData();
    }
}
</script>
