<template>
    <div>
        <hash-loader v-if="isLoading"></hash-loader>
        <div v-else>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Crime Reason / Date</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{crime.desc}} / {{crime.created_at}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Criminals</h5>
                            <h6 v-for="criminal in crime.characters" class="card-subtitle mb-2 text-muted">{{criminal.firstname}} {{criminal.lastname}}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Policeman</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{crime.policeman.name}} {{crime.policeman.last_name}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners'
import {Multiselect} from "vue-multiselect";
export default {
    name: "InvestigationShow",

    data() {
        return {
            isLoading: true,
            crime: {
                id: this.$route.params.id,
                desc: '',
                type: '',
                created_at: '',
            }
        }
    },
    components: {
        HashLoader
    },

    methods: {
        loadData: async function() {
            await axios.get('../api/crime/'+this.crime.id).then(data => {
                this.crime = data.data
                if (this.crime.created_at){
                    this.crime.created_at = this.crime.created_at.replace("T", " ").split('.')[0]
                }
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
