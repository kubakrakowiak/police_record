<template>

</template>

<script>
export default {
    name: "InvestigationShow",

    data() {
        return {
            investigation: {
                id: this.$route.params.id,
                name: '',
                desc: '',
                type: '',
                created_at: '',
                closed_at: '',
            }
        }
    },

    methods: {
        loadData: async function() {
            await axios.get('../api/investigation/'+this.investigation.id).then(data => {
                this.investigation = data.data
            }).catch(error => {
                console.log(error)
            }).finally(() => {
                this.isLoading = false
            })
        }
    },

    async mounted() {
        await this.loadData();
    }
}
</script>
