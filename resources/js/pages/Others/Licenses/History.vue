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
            await axios.get('/../api/others/licenses/history').then(data => {
                this.licenses = data.data
            }).catch(error => {
                console.log(error)
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
