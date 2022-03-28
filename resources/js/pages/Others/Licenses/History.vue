<template>
    <div>
        <div class="flex justify-center pt-20" v-if="isLoading">
            <hash-loader></hash-loader>
        </div>
        <div class="row justify-content-center" v-else>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-6">
                        <multiselect v-model="filter.character" deselect-label="Remove this value" track-by="fullname" label="fullname" placeholder="Select person" :options="characters" :searchable="true" :allow-empty="true">
                            <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.firstname }} {{ option.lastname }}</strong></template>
                        </multiselect>
                        <span class="text-sm text-red-600 hidden"></span>
                    </div>
                    <div class="col-4">
                        <multiselect v-model="filter.type" deselect-label="Remove this value" track-by="value" label="name" placeholder="Select type" :options="types" :searchable="true" :allow-empty="true">
                            <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.name }}</strong></template>
                        </multiselect>
                        <span class="text-sm text-red-600 hidden"></span>
                    </div>
                    <div class="col-2"><input type="submit" class="btn btn-info" @click.prevent="onFilterSubmit()" value="Filter"></div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Lastname</th>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action by</th>
                        <th scope="col">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="license in licenses">
                        <td>{{license.char.firstname}}</td>
                        <td>{{license.char.lastname}}</td>
                        <td>
                            <div v-if="license.type === 'weapon'">
                                Weapon permission
                            </div>
                            <div v-else-if="license.type === 'dmv'">
                                Drive Theory
                            </div>
                            <div v-else-if="license.type === 'drive_bike'">
                                Driving cat. A
                            </div>
                            <div v-else-if="license.type === 'drive'">
                                Driving cat. B
                            </div>
                            <div v-else-if="license.type === 'drive_truck'">
                                Driving cat. C
                            </div>
                        </td>
                        <td v-if="license.log_type === 0">
                            Revoked
                        </td>
                        <td v-else-if="license.log_type === 1">
                            Grant
                        </td>
                        <td>
                            {{ license.user.name }}
                            {{ license.user.last_name }}
                        </td>
                        <td>
                            {{ license.created_format }}
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
            licenses: [],
            page: 1,
            total: 0,
            per_page: 10,
            characters: [],
            types: [{
                name: 'Weapon permission',
                value: 'weapon'
            },{
                name: 'Driving Theory',
                value: 'dmv'
            },{
                name: 'Driving cat. A',
                value: 'drive_bike'
            },{
                name: 'Driving cat. B',
                value: 'drive'
            },{
                name: 'Driving cat. C',
                value: 'drive_truck'
            }],
            filter: {
                character: '',
                type: '',
            }
        }
    },

    components: {
        HashLoader,
        Multiselect
    },

    methods: {
        loadData: async function (){
            await axios.get('/../api/others/licenses/history',  {
                params: {
                    per_page: this.per_page,
                    page:     this.page,
                    character: this.filter.character,
                    type:      this.filter.type.value,
                }
            }).then(data => {
                this.licenses = data.data.data
                this.total = Math.ceil(data.data.total / this.per_page)
            }).catch(error => {
                console.log(error)
            }).finally(() => {
                this.isLoading = false
            })
        },
        loadCharacters: async function (){
            await axios.get('/../api/characters').then(data => {
                this.characters = data.data
            }).catch(error => {
                console.log(error)
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
        }
    },

    async mounted() {
        await this.loadCharacters();
        await this.loadData();
    }
}
</script>
