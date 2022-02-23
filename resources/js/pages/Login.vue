<template>
    <section class="flex justify-center items-center h-screen">
        <form class="max-w-md w-full bg-gray-900 rounded p-6 space-y-4" @submit.prevent="handleSubmit">
            <div class="mb-4">
                <p class="text-gray-400">Sign In</p>
                <h2 class="text-xl font-bold text-white">Centralized Citizen Database</h2>
            </div>
            <div>
                <input
                    class="w-full p-4 text-sm bg-gray-50 focus:outline-none border border-gray-200 rounded text-gray-600"
                    type="text"
                    name="email"
                    required
                    v-model="auth.email"
                    placeholder="Email"
                >
            </div>
            <div>
                <input
                    class="w-full p-4 text-sm bg-gray-50 focus:outline-none border border-gray-200 rounded text-gray-600"
                    type="password"
                    name="password"
                    required
                    v-model="auth.password"
                    placeholder="Password"
                >
            </div>
            <div>
                <button class="w-full py-4 bg-blue-600 hover:bg-blue-700 rounded text-sm font-bold text-gray-50 transition duration-200">Sign In</button>
            </div>
            <div class="flex items-center justify-between">
<!--                <div class="flex flex-row items-center">-->
<!--                    <input type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">-->
<!--                    <label for="comments" class="ml-2 text-sm font-normal text-gray-400">Remember me</label>-->
<!--                </div>-->

            </div>
        </form>
    </section>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            auth: {
                email: "",
                password: "",
            },
            user: {},
            error: null,
        }
    },
    methods: {
        async handleSubmit() {
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('api/login', {
                email: this.auth.email,
                password: this.auth.password,
            })
                .then(({data})=>{
                    localStorage.setItem('user', JSON.stringify(data));
                    this.user = JSON.parse(localStorage.getItem('user'));
                    window.location.href = "/dashboard";
                })
                .catch(({response:{data}})=>{
                    alert(data.message)
            })
        }
    },
    // beforeRouteEnter(to, from, next) {
    //     if (!this.$root.user) {
    //         window.location.href = "/login";
    //     }
    //     next();
    // }

}
</script>

<style scoped>

</style>
