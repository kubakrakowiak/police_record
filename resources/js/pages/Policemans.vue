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
        }
    },

    components: {
        HashLoader
    },

    methods: {
        loadData: async function (){
            this.user = JSON.parse(localStorage.getItem('user'));
            await axios.get('api/policemans').then(data => {
                this.policemans = data.data
                console.log(data)
            }).catch(error => {
                console.log(error)
                localStorage.setItem('user', null)
                window.location.href = "/";
            }).finally(() => {
                this.isLoading = false
            })
        }
    },

    async mounted() {
        await this.loadData();
    }


}
</script>
