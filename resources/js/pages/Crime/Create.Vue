<template>
    <div>
        <div v-if="isLoading">
            <hash-loader></hash-loader>
        </div>
        <div class="row" v-else>
            <div class="col-5">
                <div class="card">
                    <div class="card-header">
                        Tariff
                    </div>
                    <vuescroll style="height: 450px">
                        <ul class="list-group list-group-flush w-100">
                            <li class="list-group-item" style="cursor: default" v-for="(tariff, index) in tariffs">
                                <div class="d-inline align-middle">{{ tariff.name }} <small>{{ tariff.fine }}$$ | {{ tariff.jail }}month</small></div>
                                <div class="d-inline float-right">
                                    <button class="btn btn-success btn-sm" @click="subCounter(index)">-</button>
                                    <div class="border rounded-circle d-inline p-1 px-2 align-middle">{{ tariff.counter }}</div>
                                    <button class="btn btn-success btn-sm" @click="addCounter(index)">+</button>
                                </div>
                            </li>
                        </ul>
                    </vuescroll>
                    <div class="card-footer text-muted">
                        {{ res.message }}
                        {{ res.jail }} month
                        {{ res.fine }}$$
                    </div>
                </div>
            </div>

            <div class="col-6 mx-auto max-w-md px-6 py-6 bg-white border-0 shadow-lg sm:rounded-2xl w-full">
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
                        <label for="desc" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Crime Reason</label>
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
                        <pre class="language-json"><code></code></pre>
                    </div>
                    <div class="mt-2">
                        <button @click.prevent='onSubmit' class="w-full py-4 bg-blue-600 hover:bg-blue-700 rounded text-sm font-bold text-gray-50 transition duration-200">Report Crime</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners';
import { Multiselect } from 'vue-multiselect';
import vuescroll from 'vuescroll';


export default {
    data() {
        return {
            isLoading: true,
            form:{
                desc: "",
                jail: null,
                fine: null,
                characters: {
                    value: [],
                    options: []
                },
            },
            tariffs: [],
            res:{
                message: '',
                jail: 0,
                fine: 0,
            }
        }
    },


    components: {
        HashLoader,
        Multiselect,
        vuescroll
    },

    methods: {
        loadCharacters: async function (){
            await axios.get('/../api/characters').then(data => {
                this.form.characters.options = data.data
            }).catch(error => {
                console.log(error)
            })


        },
        loadTariff: async function (){
            await axios.get('/../api/tariff').then(data => {
                data.data.forEach((value, index) => {
                    value.counter = 0
                });
                this.tariffs = data.data
            }).catch(error => {
                console.log(error)
            }).finally(()=>{
                this.isLoading = false;
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
            })
        },

        onSubmit: async function(){
            axios.post('../api/crime/store', {
                desc: this.form.desc,
                characters: _.map(this.form.characters.value, 'id'),
                jail: this.form.jail,
                fine: this.form.fine,
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
        },

        createMessage: function (){
            this.res.message = '';
            this.res.fine = 0;
            this.res.jail = 0;
            this.tariffs.forEach((value) => {
                if (value.counter){
                    this.res.message += value.name + " | ";
                    this.res.fine += (value.counter * value.fine);
                    this.res.jail += (value.counter * value.jail);

                }
            });
        },

        subCounter: function (id){
            this.tariffs[id].counter -= 1;
            this.createMessage();
        },
        addCounter: function (id){
            this.tariffs[id].counter += 1;
            this.createMessage();

        }
    },

    async mounted() {
        await this.loadData();
        await this.loadTariff();
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
