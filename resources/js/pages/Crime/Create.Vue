<template>
    <div class="mx-auto max-w-md px-6 py-6 bg-white border-0 shadow-lg sm:rounded-2xl w-full">
        <h1 class="text-2xl font-bold mb-8">Crime
        </h1>
        <form id="form">
            <div class="relative z-0 w-full mb-5">
                <textarea
                    name="desc"
                    placeholder=" "
                    required
                    v-model="form.desc"
                    class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                ></textarea>
                <label for="desc" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Investigation Description</label>
                <span class="text-sm text-red-600 hidden">Description is required</span>
            </div>
            <div class="relative z-0 w-full mb-5">
                <input
                    type="number"
                    name="jail"
                    placeholder=" "
                    v-model="form.jail"
                    class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                />
                <label for="jail" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Jail Time</label>
                <span class="text-sm text-red-600 hidden">Jail Time have to be a number</span>
            </div>
            <div class="relative z-0 w-full mb-5">
                <input
                    type="number"
                    name="fine"
                    placeholder=" "
                    v-model="form.fine"
                    class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                />
                <label for="fine" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Money Fine</label>
                <span class="text-sm text-red-600 hidden">Money Fine have to be a number</span>
            </div>
            <div>
                <label class="typo__label">Criminals</label>
                <multiselect v-model="form.characters.value" :options="form.characters.options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick Criminals" label="fullname" track-by="fullname" :preselect-first="true">
                    <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                </multiselect>
                <pre class="language-json"><code>{{ value  }}</code></pre>
            </div>
            <div>
                <button @click.prevent='onSubmit' class="w-full py-4 bg-blue-600 hover:bg-blue-700 rounded text-sm font-bold text-gray-50 transition duration-200">Report Crime</button>
            </div>
        </form>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners';
import { Multiselect } from 'vue-multiselect';

export default {
    data() {
        return {
            isLoading: false,
            form:{
                desc: "",
                jail: null,
                fine: null,
                characters: {
                    value: [],
                    options: []
                },
            }
        }
    },

    components: {
        HashLoader,
        Multiselect
    },

    methods: {
        loadCharacters: async function (){
            await axios.get('/../api/characters').then(data => {
                this.form.characters.options = data.data
            }).catch(error => {
                console.log(error)
            })
        },
        loadData: async function (){
            await axios.get('/../api/characters').then(data => {
                this.form.characters.options = data.data
            }).catch(error => {
                this.$notify({
                    title: 'Error',
                    text: error,
                    type: 'error'
                })
            }).finally(() => {
                this.isLoading = false
            })
        },

        onSubmit: async function(){
            axios.post('../api/investigation/store', {
                name: this.form.name,
                desc: this.form.desc,
                criminals: _.map(this.form.criminals.value, 'id'),
                type: this.form.type.value.id,
            })
                .then(() => {
                    this.$notify({
                        title: 'Saved',
                        text: 'Succesful created investigation!',
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
        await this.loadData();
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
