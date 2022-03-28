<template>
    <div>
        <div  class="flex justify-center pt-20" v-if="isLoading">
            <hash-loader></hash-loader>
        </div>

        <div v-else class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <table class="table table-dark">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Grade</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="policeman in policemans">
                            <th scope="row">{{ policeman.id }}</th>
                            <td>{{ policeman.name }}</td>
                            <td>{{ policeman.last_name }}</td>
                            <td>{{ policeman.grade.name }}</td>
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
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners'

export default {

    name: "Policemans",
    data() {
        return {
            user: {},
            policemans: null,
            isLoading: true,
            page: 1,
            total: 0,
            per_page: 10
        }
    },

    components: {
        HashLoader
    },

    methods: {
        loadData: async function (){
            this.user = JSON.parse(localStorage.getItem('user'));
            await axios.get('api/policemans', {
                params: {
                    per_page: this.per_page,
                    page:     this.page,
                }
            }).then(data => {
                this.policemans = data.data[0]
                this.total = Math.ceil(data.data[1] / this.per_page)
                console.log(this.total)
            }).catch(error => {
                console.log(error)
                localStorage.setItem('user', null)
                window.location.href = "/";
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
