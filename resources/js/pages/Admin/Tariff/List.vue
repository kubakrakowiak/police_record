<template>
    <div>
        <div  class="flex justify-center pt-20" v-if="isLoading">
            <hash-loader></hash-loader>
        </div>

        <div v-else class="container-fluid mt-2">
            <div class="row justify-content-end">
                <button class="btn btn-success" @click.prevent="onClick(null)">New Tariff</button>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" class="col-1">#</th>
                            <th scope="col" class="col-5">Name</th>
                            <th scope="col" class="col-2">Fine</th>
                            <th scope="col" class="col-2">Jain</th>
                            <th scope="col" class="col-2">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="tariff in tariffs">
                            <th scope="row">{{ tariff.id }}</th>
                            <td>{{ tariff.name }}</td>
                            <td>{{ tariff.fine }}</td>
                            <td>{{ tariff.jail }}</td>
                            <td>
                                <button class="btn-sm btn-primary mr-1" @click="onClick(tariff.id)">Edit</button>
                                <button class="btn-sm btn-danger mr-1" @click="destroy(tariff.id)">Delete</button>
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
        <div class="modal fade" id="modal" tabindex="-1" role="dialog">
            <TariffModal @clicked="loadData" :id="idToModal"></TariffModal>
        </div>
    </div>
</template>

<script>
import HashLoader from "@saeris/vue-spinners";
import TariffModal from "../../components/Tariff/TariffForm";


export default {
    name: "TariffList",
    data() {
        return {
            user: {},
            tariffs: null,
            isLoading: true,
            page: 1,
            total: 0,
            per_page: 8,
            idToModal: null,
        }
    },

    components: {
        HashLoader,
        TariffModal
    },

    methods: {
        loadData: async function (){
            this.user = JSON.parse(localStorage.getItem('user'));
            await axios.get('/api/admin/tariff', {
                params: {
                    per_page: this.per_page,
                    page:     this.page,
                }
            }).then(data => {
                this.tariffs = data.data[0].data
                this.total = Math.ceil(data.data[0].total / this.per_page)
            }).catch(error => {
                console.log(error)
                localStorage.setItem('user', null)
                window.location.href = "/";
            }).finally(() => {
                this.isLoading = false
            })
        },
        destroy: async function (id){
            await axios.post('/api/admin/tariff/destroy/' + id).then(data => {
                this.loadData();
                this.$notify({
                    title: 'Deleted',
                    text: 'Succesful deleted user!',
                    type: 'success'
                });
            }).catch(error => {
                this.$notify({
                    title: 'Error',
                    text: error,
                    type: 'error'
                });
            })
        },
        pageChange: async function(page){
            this.isLoading = true;
            this.page = page
            await this.loadData();
        },
        onClick: function (id){
            this.idToModal = id;
            $('#modal').modal('show');
        },
    },

    async mounted() {
        await this.loadData();
    }

}
</script>
