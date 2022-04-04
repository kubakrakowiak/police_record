<template>
    <div>
        <div  class="flex justify-center pt-20" v-if="isLoading">
            <hash-loader></hash-loader>
        </div>
        <div v-else class="row justify-content-center">
            <div class="col-md-10">
                <div class="row justify-content-center">
                    <div class="col-6">
                        <multiselect v-model="character" deselect-label="Remove this value" track-by="fullname" label="fullname" placeholder="Select criminal" :options="characters" :searchable="true" :allow-empty="true">
                            <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.firstname }} {{ option.lastname }}</strong></template>
                        </multiselect>
                        <span class="text-sm text-red-600 hidden"></span>
                    </div>
                    <div class="col-2"><input type="submit" class="btn btn-info" @click.prevent="onFilterSubmit()" value="Filter"></div>
                </div>
                <div v-if="characterLoaded">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Jail (months)</th>
                            <th scope="col">Fine ($$$)</th>
                            <th scope="col">Date</th>
                            <th scope="col">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="crime in crimes">
                                <td>{{crime.id}}</td>
                                <td>{{crime.desc}}</td>
                                <td>{{crime.jail}}</td>
                                <td>{{crime.fine}}</td>
                                <td>{{crime.created_at}}</td>
                                <td>
                                    <router-link :to="{ name: 'crimeShow', params: { id: crime.id }}">
                                        <button type="button" class="btn btn-primary btn-sm">Details</button>
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        <button v-if="page-1 >= 0" class="btn btn-success mr-1" @click="pageChange(page-1)">Prev</button>
                        <button v-else class="btn btn-success mr-1" disabled>Prev</button>
                        <button v-if="page+1 < total" class="btn btn-success" @click="pageChange(page+1)">Next</button>
                        <button v-else class="btn btn-success" disabled>Next</button>
                    </div>
                </div>
                <div v-else class="row justify-content-center">
                    <h1 class="display-4 pt-10">Select character to find the crimes</h1>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners'
import { Multiselect } from 'vue-multiselect';
import {forEach} from "lodash";

export default {
    data() {
        return {
            isLoading: true,
            characterLoaded: false,
            characters: [],
            character: {},
            crimes: [],
            page: 0,
            total: null,
            per_page: 8
        }
    },

    components: {
        HashLoader,
        Multiselect
    },

    methods: {
        loadCharacters: async function (){
            await axios.get('/../api/characters').then(data => {
                this.characters = data.data
            }).catch(error => {
                console.log(error)
            }).finally(() =>{
                this.isLoading = false;
            })
        },

        pageChange: async function(page){
            this.isLoading = true;
            await this.onFilterSubmit(page);
        },

        onFilterSubmit: async function (page = 0){
            if (this.character){
                this.isLoading = true
                this.page = page
                await axios.get('../api/crime/criminals', {
                    params: {
                        character: this.character.id,
                        per_page:  this.per_page,
                        page:      this.page,
                    }
                }).then(data => {
                    this.crimes = data.data[0];
                    this.total = Math.ceil(data.data[1] / this.per_page)
                    this.crimes.forEach(function (item){
                        item.created_at = item.created_at.replace("T", " ").split('.')[0]
                    })
                }).catch(error => {
                    console.log(error)
                }).finally(() => {
                    this.isLoading = false
                    this.characterLoaded = true
                })
            }
        },
    },

    async mounted() {
        await this.loadCharacters();
    }
}
</script>
