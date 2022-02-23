<template>
    <div class="justify-center flex content-center" v-if="isLoading">
        <hash-loader></hash-loader>
    </div>
    <div v-else>
        <form name="manage">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                Danger Level
            </label>
            <div class="relative">
                <select v-model="dangerLevel.type" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                    <option value="0">Safe City - Green</option>
                    <option value="1">Avg Danger - Orange</option>
                    <option value="2">Danger - Red</option>
                    <option value="3">Very Dangerous - Black</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                        @click.prevent="onSubmit"
                        class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded flex justify-content-center align-items-center m-2"
                >
                    Save
                </button>
            </div>
        </form>
        </div>
</template>

<script>
import {HashLoader} from "@saeris/vue-spinners";

export default {
    name: "Management",

    data() {
        return {
            dangerLevel: {},
            isLoading: true,
        }
    },

    components: {
        HashLoader,
    },

    async mounted() {
        await this.getDangerLevel();
        this.isLoading = false;
    },

    methods: {
        onSubmit: async function() {
            await axios.post('../api/danger-level/store', {
                type: this.dangerLevel.type,
            }).then((data) => {
                this.$notify({
                    title: 'Saved',
                    text: 'Succesful saved the dispatch management!',
                    type: 'success'
                });
            }).catch((error) => {
                this.$notify({
                    title: 'Error',
                    text: error,
                    type: 'Error'
                });
            })
        },

        getDangerLevel: async function(){
            await axios.get('../api/danger-level').then((data) => {
                this.dangerLevel = data.data;
            })
        },
    }
}
</script>

