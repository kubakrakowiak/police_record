<template>
    <section class="flex justify-center items-center h-screen">
        <form class="max-w-md w-full bg-gray-900 rounded p-6 space-y-4"
              @submit.prevent="handleSubmit"
        >
            <div class="mb-4">
                <p class="text-gray-400">Sign Up</p>
                <h2 class="text-xl font-bold text-white">Centralized Citizen Database</h2>
            </div>
            <div>
                <input class="w-full p-4 text-sm bg-gray-50 focus:outline-none border border-gray-200 rounded text-gray-600"
                       type="text"
                       name="email"
                       required
                       v-model="form.email"
                       placeholder="Email"
                >
            </div>
            <div>
                <input class="w-full p-4 text-sm bg-gray-50 focus:outline-none border border-gray-200 rounded text-gray-600"
                       type="password"
                       name="password"
                       required
                       v-model="form.password"
                       placeholder="Password"
                >
            </div>
            <div>
                <input class="w-full p-4 text-sm bg-gray-50 focus:outline-none border border-gray-200 rounded text-gray-600"
                       type="password"
                       name="password"
                       required
                       v-model="form.password_confirmation"
                       placeholder="Confirm Password"
                >
            </div>
            <div>
                <input class="w-full p-4 text-sm bg-gray-50 focus:outline-none border border-gray-200 rounded text-gray-600"
                       type="text"
                       name="name"
                       required
                       v-model="form.name"
                       placeholder="Name"
                >
            </div>
            <div>
                <input class="w-full p-4 text-sm bg-gray-50 focus:outline-none border border-gray-200 rounded text-gray-600"
                       type="text"
                       name="last_name"
                       required
                       v-model="form.last_name"
                       placeholder="Last Name"
                >
            </div>
            <div>
                <input
                    type="submit"
                    class="w-full py-4 bg-blue-600 hover:bg-blue-700 rounded text-sm font-bold text-gray-50 transition duration-200"
                    value="Sign Up"
                >
            </div>
        </form>
    </section>
</template>

<script>
export default {
    name: "Register",
    data() {
        return {
            form:{
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                last_name: "",
                error: null
            },
        }
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault()
            if (this.form.password.length > 0) {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('api/register', {
                        name: this.form.name,
                        email: this.form.email,
                        password: this.form.password,
                        password_confirmation: this.form.password_confirmation,
                        last_name: this.form.last_name,
                    })
                        .then(response => {
                            if (response.data.success) {
                                window.location.href = "/login"
                            } else {
                                this.form.error = response.data.message
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                })
            }
        }
    },
}

</script>

<style scoped>

</style>
