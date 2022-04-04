<template>
    <div>
        <div  class="flex justify-center pt-20" v-if="isLoading">
            <hash-loader></hash-loader>
        </div>
        <div v-else class="row justify-content-center">
            <div class="col-md-10">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Firstname</th>
                        <th scope="col">Lastname</th>
                        <th scope="col">Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="character in characters">
                        <td>{{character.id}}</td>
                        <td>{{character.firstname}}</td>
                        <td>{{character.lastname}}</td>
                        <td>
                            <router-link :to="{ name: 'othersCharacterShow', params: { id: character.id }}">
                                <button type="button" class="btn btn-primary btn-sm">Details</button>
                            </router-link>
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
            characters: [],
            page: 1,
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
            await axios.get('/../api/characters', {
                params: {
                    per_page: this.per_page,
                    page:     this.page,
                }
            }).then(data => {
                this.characters = data.data.data
                this.total = Math.ceil(data.data.total / this.per_page)
            }).catch(error => {
                console.log(error)
            }).finally(() =>{
                this.isLoading = false;
            })
        },

        pageChange: async function(page){
            this.isLoading = true;
            this.page = page;
            await this.loadCharacters();
        },
    },

    async mounted() {
        await this.loadCharacters();
    }
}
</script>
