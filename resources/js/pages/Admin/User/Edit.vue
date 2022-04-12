<template>

</template>

<script>
export default {
    name: "Edit",
    data() {
        return {
            user: {
                id: this.$route.params.id,
            },
            isLoading: true,
        }
    },

    methods: {
        loadData: async function (){
            await axios.get('/api/admin/user/' + this.user.id)
                .then(data => {
                    this.user = data.data[0]
                }).catch(error => {
                    console.log(error)
                }).finally(() => {
                        this.isLoading = false
                })
        },
    },

    async mounted(){
        await this.loadData();
    }
}
</script>

<style scoped>

</style>
