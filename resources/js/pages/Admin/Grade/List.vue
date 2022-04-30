<template>
    <div>
        <div v-if="isLoading">
            <HashLoader></HashLoader>
        </div>
        <div v-else>
            <vuescroll :ops="ops" style="height: 600px">
                <draggable
                    :list="grades"
                    :disabled="!enabled"
                    class="list-group"
                    ghost-class="ghost"
                    :move="checkMove"
                    @start="dragging = true"
                    @end="dragging = false"
                >
                    <div
                        class="list-group-item"
                        v-for="element in grades"
                        :key="element.name"
                    >
                        {{ element.name }}
                        <button class="float-right btn-sm btn-danger" @click.prevent="destroy(element.id)">Delete</button>
                        <button class="float-right btn-sm btn-secondary" @click.prevent="onClick(element.id)">Edit</button>
                    </div>
                </draggable>
            </vuescroll>
            <button class="btn btn-success" @click.prevent="onSubmit">Save order</button>
            <button class="btn btn-success" @click.prevent="onClick(null)">New Grade</button>
            <div class="modal fade" id="modal" tabindex="-1" role="dialog">
                <GradeModal :id="idToModal"></GradeModal>
            </div>
        </div>
    </div>
</template>

<script>
import {HashLoader} from "@saeris/vue-spinners";
import draggable from 'vuedraggable';
import vuescroll from 'vuescroll';
import GradeModal from "../../components/Grade/GradeForm";


export default {
    name: "AdminGroupList",
    data() {
        return {
            grades: [],
            isLoading: true,
            dragging: false,
            enabled: true,
            ops: {
                vuescroll: {},
                scrollPanel: {
                    scrollingX: false,
                },
                rail: {},
                bar: {}
            },
            loadEditModal: [],
            idToModal: null,
        }
    },

    components:{
        HashLoader,
        draggable,
        vuescroll,
        GradeModal
    },

    computed: {
        draggingInfo() {
            return this.dragging ? "under drag" : "";
        }
    },

    methods: {
        checkMove: function(e) {
            window.console.log("Future index: " + e.draggedContext.futureIndex);
        },
        loadGrades: async function (){
            await axios.get('/api/grade/list')
                .then(data => {
                    this.grades = data.data;
                    this.grades.forEach((item, index)=>{
                        this.loadEditModal[item.id] = false;
                    })
                }).catch(error => {
                    console.log(error)
                }).finally(() => {
                    this.isLoading = false
                })
        },
        onSubmit: async function (){
            await axios.post('/api/admin/grade/order', {
                data: this.grades,
            }).then(data => {
                this.$notify({
                    title: 'Saved',
                    text: 'Succesful saved the grades order!',
                    type: 'success'
                });
            }).catch(error => {
                this.$notify({
                    title: 'Error',
                    text: error,
                    type: 'Error'
                });
            })
        },
        destroy: async function (id){
            await axios.post('/api/admin/grade/destroy/' + id).then(data => {
                this.$notify({
                    title: 'Saved',
                    text: 'Succesful deleted the grades order!',
                    type: 'success'
                });
            }).catch(error => {
                this.$notify({
                    title: 'Error',
                    text: error,
                    type: 'Error'
                });
            }).finally(()=>{
                this.loadGrades();
            })
        },
        onClick: function (id){
            this.idToModal = id;
            $('#modal').modal('show');
        },
    },

    async mounted(){
        await this.loadGrades();
    }
}
</script>
