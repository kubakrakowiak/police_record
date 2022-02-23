<template>
    <div class="justify-center flex content-center" v-if="isLoading">
        <hash-loader></hash-loader>
    </div>
    <div v-else class="justify-content-center">
        <vuescroll :ops="ops" style="height: 600px">
            <div class="row">
                <div class="col-3">
                        <li class="list-group-item">
                            No team
                        </li>
                        <draggable
                            class="list-group"
                            tag="ul"
                            v-model="policemans"
                            v-bind="dragOptions"
                            :move="onMove"
                            @start="isDragging=true"
                            @end="isDragging=false"
                        >
                            <transition-group type="transition" :name="'flip-list'">
                                <li class="list-group-item" v-for="element in policemans" :key="element.id">
<!--                                    <i :class="element.fixed? 'fa fa-anchor' : 'glyphicon glyphicon-pushpin'" @click="element.fixed = !element.fixed" aria-hidden="true"></i>-->
                                    {{element.name}} {{element.last_name}}
                                    <br>
                                    <small>{{element.grade.name}}</small>
                                </li>
                            </transition-group>
                        </draggable>
                </div>

                <div class="col-9 inline-flex flex-md-wrap">
                    <div class="col-3 mt-3" v-for="(value, index) in patrols">
                        <li class="list-group-item inline-block flex justify-between">
                            <div>
                                {{value.name}} <br>
                                <small>{{value.car.name}}</small>
                            </div>

                            <div>
                                <i class="fas fa-sliders-h"></i>
                                <i @click="destroyUnit(value.id)" class="text-red-500 far fa-trash-alt align-self-end text-right pl-2"></i>
                            </div>
                        </li>
                        <draggable element="span" v-model="patrols[index].user" v-bind="dragOptions" :move="onMove">
                            <transition-group name="no" class="list-group" tag="ul">
                                <li class="list-group-item" v-for="element in patrols[index].user" :key="element.id">
<!--                                    <i :class="element.fixed? 'fas fa-anchor' : 'fas fa-key'" @click="element.fixed = !element.fixed" aria-hidden="true"></i>-->
                                    {{element.name}} {{element.last_name}}
                                    <br>
                                    <small>{{element.grade.name}}</small>
                                </li>
                            </transition-group>
                        </draggable>
                    </div>
                </div>
            </div>
        </vuescroll>
        <div class="inline-block flex float-right">
            <div @click="setUnits" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded flex justify-content-center align-items-center m-2">Save</div>
            <div @click="resetUnits" class="bg-red-400 hover:bg-red-600 text-white font-bold py-2 px-4 rounded flex justify-content-center align-items-center m-2">Reset</div>
            <div @click="createUnit(0)" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded flex justify-content-center align-items-center m-2">New Unit</div>
            <div type="button" data-toggle="modal" data-target="#modal" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded flex justify-content-center align-items-center m-2">New Special Unit</div>
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
                        <form>
                            <label for="name">Name</label>
                            <input type="text" v-model="specialUnitName" id="name">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button @click.prevent="createUnit(1)"  type="button" data-dismiss="modal" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners'
import draggable from 'vuedraggable'
import vuescroll from 'vuescroll';


export default {

    name: "dispatchUnit",
    data() {
        return {
            policemans: {},
            patrols: {},
            isLoading: true,
            editable: true,
            isDragging: false,
            delayedDragging: false,
            ops: {
                vuescroll: {},
                scrollPanel: {
                    scrollingX: false,
                },
                rail: {},
                bar: {}
            },
            specialUnitName: ''
        }
    },

    components: {
        HashLoader,
        draggable,
        vuescroll,
    },

    methods: {
        jsonConcat: function(o1, o2) {
            for (var key in o2) {
                o1[key] = o2[key];
            }
            return o1;
        },

        resetUnits: async function (){
            this.isLoading = true;
            this.policemans = {};
            this.patrols = {};
            await this.getAllDuties();
            await this.getAllUnits();
            this.isLoading = false;
        },

        getAllDuties: async function (){
            this.policemans = {}
            await axios.get('../api/duty/count').then((data)=>{
                this.policemans = data.data;
            })
            for (let i = 0; i < this.policemans.length; i++){
                this.policemans[i] = this.jsonConcat(this.policemans[i], {
                    fixed: false,
                });
            }
        },

        getAllUnits: async function (){
            this.patrols = {};
            await axios.get('../api/units').then((data)=>{
                for (let i = 0; i < data.data.length; i++){
                    Vue.set(this.patrols, i, data.data[i]);
                    //this.patrols = data.data
                }
            })
        },

        getDispatch: async function (){
            await axios.get('../api/duty').then((data)=>{
                this.dispatch = data.data
                this.isLoading = false;
            })
        },

        setUnits: async function(){
            await axios.post('../api/units/set', {
                units: this.patrols,
            }).then(() => {
                this.$notify({
                    title: 'Saved',
                    text: 'Succesful saved the dispatch setup!',
                    type: 'success'
                });
            }).catch((error) => {
                this.$notify({
                    title: 'Error',
                    text: error,
                    type: 'error'
                });
            })
        },

        matchUnits: function (){
            let arr = [];
            for (let i = 0; i < this.policemans.length; i++){
                if (this.policemans[i].patrol[0]){
                    for (let j = 0; j < Object.keys(this.patrols).length; j++){
                        if(this.policemans[i].patrol[0].id === this.patrols[j].id){
                            this.patrols[j].user.push(this.policemans[i]);
                            arr.push(i)
                        }
                    }
                }
            }
            for(let i = arr.length-1; i >= 0; i--){
                this.policemans.splice(arr[i], 1);
            }
        },

        createUnit: async function(type){
            if (type === 0){
                await axios.post('../api/units/create', {
                    type: 0,
                }).then(()=>{
                    this.$notify({
                        title: 'Created',
                        text: 'Succesful created the unit!',
                        type: 'success'
                    });
                }).catch((error)=>{
                    this.$notify({
                        title: 'Error',
                        text: error,
                        type: 'error'
                    });
                })
            }
            else {
                await axios.post('../api/units/create', {
                    type: 1,
                    name: this.specialUnitName,
                }).then(()=>{
                    this.$notify({
                        title: 'Created',
                        text: 'Succesful created special unit!',
                        type: 'success'
                    });
                    this.specialUnitName = '';
                }).catch((error)=>{
                    this.$notify({
                        title: 'Error',
                        text: error,
                        type: 'error'
                    });
                })
            }
            await this.phabricView();
        },

        destroyUnit: async function(id) {
            await axios.post('../api/units/destroy/' + id).then((response)=>{
                this.$notify({
                    title: 'Destroyed',
                    text: 'Succesful destroyed the unit!',
                    type: 'success'
                });
            }).catch((error)=>{
                this.$notify({
                    title: 'Error',
                    text: error,
                    type: 'error'
                });
            });
            await this.phabricView();
        },

        onMove({ relatedContext, draggedContext }) {
            const relatedElement = relatedContext.element;
            const draggedElement = draggedContext.element;
            return (
                (!relatedElement || !relatedElement.fixed) && !draggedElement.fixed
            );
        },

        phabricView: async function() {
            await this.getAllUnits();
            await this.getAllDuties();
            this.matchUnits();
        },

    },

    async mounted() {
        await this.phabricView();
        this.isLoading = false;
    },

    computed:{
        dragOptions() {
            return {
                animation: 0,
                group: "description",
                disabled: !this.editable,
                ghostClass: "ghost"
            };
        },
    },

    watch: {
        isDragging(newValue) {
            if (newValue) {
                this.delayedDragging = true;
                return;
            }
            this.$nextTick(() => {
                this.delayedDragging = false;
            });
        }
    },
}
</script>
