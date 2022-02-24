<template>
    <div>
        <div class="flex justify-center pt-20" v-if="isLoading">
            <hash-loader></hash-loader>
        </div>
        <div class="row justify-content-center" v-else>
            <div class="col-md-10">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Lastname</th>
                        <th scope="col">Status</th>
                        <th scope="col">Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="license in licenses">
                        <td>{{license.char.firstname}}</td>
                        <td>{{license.char.lastname}}</td>
                        <td>
                                <div v-if="license.type">
                                    Weapon permission
                                </div>
                        </td>
                        <td>
                            <button type="button" @click.prevent="revokeLicense(license.id)" class="btn btn-danger btn-sm">Revoke</button>
                            <button type="button" class="btn btn-primary btn-sm">History</button>
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
            licenses: [],
        }
    },

    components: {
        HashLoader,
    },

    methods: {
        loadData: async function (){
            await axios.get('/../api/others/licenses/list').then(data => {
                this.licenses = data.data
            }).catch(error => {
                console.log(error)
            }).finally(() => {
                this.isLoading = false
            })
        },

        revokeLicense: async function(id){
            await axios.post('/../api/others/licenses/' + id + "/revoke").then(() => {
                this.$notify({
                    title: 'Saved',
                    text: 'Succesful revoked user license!',
                    type: 'success'
                });
            }).catch((error) => {
                this.$notify({
                    title: 'Error',
                    text: error,
                    type: 'error'
                });
            }).finally(() => {
                this.loadData();
            })
        },
    },

    async mounted() {
        await this.loadData();
    }
}
</script>
