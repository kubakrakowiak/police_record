<template>
    <div>
        <div v-if="isLoading">
            <hash-loader></hash-loader>
        </div>
        <form v-else>
            <div class="form-group">
                <label for="inputEmail1">Email address</label>
                <input type="email" class="form-control" id="inputEmail1" aria-describedby="emailHelp" v-model="user.email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="inputName">Name</label>
                <input type="text" class="form-control" id="inputName" aria-describedby="nameHelp" v-model="user.name">
                <small id="nameHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="inputLastname">Lastname</label>
                <input type="text" class="form-control" id="inputLastname" aria-describedby="lastnameHelp" v-model="user.last_name">
                <small id="lastnameHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="inputEmail1">Permission</label>
                <input type="number" class="form-control" id="inputPermission" aria-describedby="permissionHelp" v-model="user.permission">
                <small id="permissionHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <multiselect v-model="user.grade" deselect-label="Remove this value" track-by="name" label="name" placeholder="Select Type" :options="grades" :searchable="true" :allow-empty="true">
                    <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.name }}</strong></template>
                </multiselect>
            </div>
            <button @click.prevent="onSubmit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
import {HashLoader} from "@saeris/vue-spinners";
import { Multiselect } from 'vue-multiselect';

export default {
    name: "Edit",
    data() {
        return {
            user: {
                id: this.$route.params.id,
            },
            grades: [],
            isLoading: true,
        }
    },

    components:{
        HashLoader,
        Multiselect
    },

    methods: {
        loadData: async function (){
            await axios.get('/api/admin/user/' + this.user.id)
                .then(data => {
                    this.user = data.data
                }).catch(error => {
                    console.log(error)
                }).finally(() => {
                        this.isLoading = false
                })
        },
        loadGrades: async function (){
            await axios.get('/api/grade/list')
                .then(data => {
                    this.grades = data.data
                }).catch(error => {
                    console.log(error)
                }).finally(() => {
                    this.isLoading = false
                })
        },
        onSubmit: async function (){
            axios.post('/api/admin/user', {
                data: this.user
            }).then((data) => {
                this.$notify({
                    title: 'Saved',
                    text: 'Succesful updated user!',
                    type: 'success'
                });
            }).catch((error) => {
                this.$notify({
                    title: 'Error',
                    text: error,
                    type: 'Error'
                });
            }).finally(()=>{
                this.$router.push({name: 'adminListUser'});
            })
        },
    },

    async mounted(){
        await this.loadData();
        await this.loadGrades();
    }
}
</script>

<style scoped>

</style>
