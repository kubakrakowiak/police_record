<template>
    <div class="card">
        <div class="container m-3">
            <h1 class="text-2xl font-bold mb-8">Quick license
            </h1>
            <form id="form" class="pr-3">
                <div>
                    <label class="typo__label">Person</label>
                    <multiselect v-model="form.characterId" deselect-label="Can't remove this value" track-by="lastname" label="lastname" placeholder="Select one" :options="characters" :searchable="true" :allow-empty="false">
                        <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.firstname }} {{ option.lastname }}</strong></template>
                    </multiselect>
                    <span class="text-sm text-red-600 hidden"></span>
                </div>
                <div>
                    <label class="typo__label">Person</label>
                    <multiselect v-model="form.type" deselect-label="Can't remove this value" track-by="name" label="name" placeholder="Select one" :options="types" :searchable="false" :allow-empty="false">
                        <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.name }}</strong></template>
                    </multiselect>
                </div>
                <button type="button" @click.prevent="addLicense" class="btn btn-success btn-sm">Add License</button>
            </form>
        </div>
    </div>
</template>

<script>
import { Multiselect } from 'vue-multiselect';


export default {
    name: "LicenseForm",
    data() {
        return {
            characters: [],
            types: [
                {
                    name: "Weapon License",
                    id: 0,
                },
                {
                    name: "Driving Theory",
                    id: 1,
                },
                {
                    name: "Driving License cat. A",
                    id: 2,
                },
                {
                    name: "Driving License cat. B",
                    id: 3,
                },
                {
                    name: "Driving License cat. C",
                    id: 4,
                }
            ],
            form: {
                characterId: null,
                type: null
            }
        }
    },
    components: {
        Multiselect
    },

    methods: {
        loadCharacters: async function (){
            await axios.get('/../api/characters').then(data => {
                this.characters = data.data
            }).catch(error => {
                console.log(error)
            })
        },
        addLicense: async function (){
            axios.post('/../api/others/licenses/add', {
                form: this.form
            })
                .then(response => {
                    this.$notify({
                        title: 'Saved',
                        text: 'Succesful assigned license to user!',
                        type: 'success'
                    });
                })
                .catch(error => {
                    this.$notify({
                        title: 'Error',
                        text: error,
                        type: 'error'
                    });
                });
        }
    },

    async mounted() {
        await this.loadCharacters();
    }
}
</script>


