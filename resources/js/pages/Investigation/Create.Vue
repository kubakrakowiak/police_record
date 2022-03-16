<template>
    <div class="mx-auto max-w-md px-6 py-8 bg-white border-0 shadow-lg sm:rounded-2xl">
        <h1 class="text-2xl font-bold mb-8">Investigation
        </h1>
        <form id="form">
            <div class="relative z-0 w-full mb-5">
                <input
                    type="text"
                    name="name"
                    placeholder=" "
                    required
                    v-model="form.name"
                    class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                />
                <label for="name" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Investigation name</label>
                <span class="text-sm text-red-600 hidden">Name is required</span>
            </div>
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
            <div>
                <label class="typo__label">Type</label>
                <multiselect v-model="form.type.value" deselect-label="Can't remove this value" track-by="name" label="name" placeholder="Select one" :options="form.type.options" :searchable="false" :allow-empty="false">
                    <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.name }}</strong></template>
                </multiselect>
                <pre class="language-json"><code>{{ value  }}</code></pre>
                <span class="text-sm text-red-600 hidden">ź</span>
            </div>
            <div class="mt-2">
                <label class="typo__label">Assigned Policemans</label>
                <multiselect v-model="form.policemans.value" :options="form.policemans.options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick Policemans" label="name" track-by="name" :preselect-first="true">
                    <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                </multiselect>
                <pre class="language-json"><code>{{ value  }}</code></pre>
            </div>
            <div class="mt-2">
                <button @click.prevent='onSubmit' class="w-full py-4 bg-blue-600 hover:bg-blue-700 rounded text-sm font-bold text-gray-50 transition duration-200">Start Investigation</button>
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
                name: "",
                desc: "",
                policemans: {
                    value: [],
                    options: []
                },
                type: {
                    value: { name: 'Closed Investigation', id: 0 },
                    options: [
                        { name: 'Closed Investigation', id: 0 },
                        { name: 'Open Investigation', id: 1 },
                    ]
                }
            }
        }
    },

    components: {
        HashLoader,
        Multiselect
    },

    methods: {
        loadData: async function (){
            await axios.get('../api/policemans').then(data => {
                this.form.policemans.options = data.data
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
                policemans: _.map(this.form.policemans.value, 'id'),
                type: this.form.type.value.id,
            })
                .then(response => {
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
