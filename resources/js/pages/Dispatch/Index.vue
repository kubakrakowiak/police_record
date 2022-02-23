<template>
    <div class="justify-center flex content-center" v-if="isLoading">
        <hash-loader></hash-loader>
    </div>
    <div v-else>
        <div>
            <h2 class="h2 justify-center flex content-center" style="font-family: 'Roboto'">Encrypted Dispatch Software developed by Craco</h2>
        </div>
        <div>
            <h3 class="h3 justify-center flex content-center" style="font-family: 'Roboto'">v0.4</h3>
        </div>
        <div class="flex justify-content-center align-items-center m-2">
            <button v-if="dispatch===0"
                    @click="setDispatch"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded "
            >Be the PWD</button>
            <button v-else-if="dispatch===1"
                    @click="setDispatch"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded "
            >Leave PWD</button>
            <button v-else
                    type="button"
                    data-toggle="modal"
                    data-target="#modal"
                    class="bg-yellow-400 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded "
            >Get PWD</button>
        </div>
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add special unit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are u sure?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button @click.prevent="setDispatch"  type="button" data-dismiss="modal" class="btn btn-primary">Grab dispatch</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners'

export default {

    data() {
        return {
            user: {},
            policemans: null,
            isLoading: true,
            dispatch: false,
        }
    },

    components: {
        HashLoader,
    },

    methods: {
        getDispatch: async function (){
            await axios.get('../api/dispatch/get').then((data)=>{
                this.dispatch = data.data;
                this.isLoading = false;
            })
        },

        setDispatch: async function () {
            await axios.post('../api/dispatch/set').then((data) => {
                this.getDispatch()
            })
        },
    },

    async mounted() {
        await this.getDispatch();
    },
}
</script>
