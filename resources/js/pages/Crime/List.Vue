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
                        <th scope="col">Reason</th>
                        <th scope="col">Crime Date</th>
                        <th scope="col">Criminals</th>
                        <th scope="col">Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="crime in crimes">
                        <th scope="row">{{crime.id}}</th>
                        <th>{{crime.desc}}</th>
                        <td>{{crime.created_at}}</td>
                        <td>{{crime.characters_count}}</td>
                        <td>
<!--                            <router-link :to="{ name: 'investigationShow', params: { id: crime.id }}">-->
                            <button type="button" class="btn btn-primary btn-sm">Details</button>
<!--                            </router-link>-->
                            <button type="button" class="btn btn-secondary btn-sm">Close</button>
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

export default {
    data() {
        return {
            isLoading: true,
            crimes: [],
            page: 1,
            total: 0,
            per_page: 10
        }
    },

    components: {
        HashLoader,
    },

    methods: {
        loadData: async function (){
            await axios.get('../api/crime', {
                params: {
                    per_page: this.per_page,
                    page:     this.page,
                }
            }).then(data => {
                this.crimes = data.data.data
                this.total = Math.ceil(data.data.total / this.per_page)
                this.crimes.forEach((item)=>{
                    item.created_at = item.created_at.replace("T", " ").split('.')[0]
                })
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
        }
    },

    async mounted() {
        await this.loadData();
    }
}
</script>
