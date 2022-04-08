<template>
    <div>
        <nav class="bg-gray-800">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="relative flex items-center justify-between h-16">
                    <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open menu</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>

                            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                        <div class="flex-shrink-0 flex items-center">
                            <router-link
                                data-toggle="collapse"
                                :to="{ name: 'home' }"
                                exact
                            >
                                <img class="block lg:hidden h-8 w-auto" src="/img/logo.png" alt="CitizenDB">
                                <img class="hidden lg:block h-8 w-auto" src="/img/logo.png" alt="CitizenDB">
                            </router-link>
                        </div>
                        <div class="hidden sm:block sm:ml-6">
                            <div class="flex space-x-4">
                                <router-link
                                    class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                    data-toggle="collapse"
                                    :to="{ name: 'dashboard' }"
                                >
                                    Dashboard
                                </router-link>
                                <router-link
                                    class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                    data-toggle="collapse"
                                    :to="{ name: 'policemans' }"
                                >
                                    Policemans
                                </router-link>
                                <router-link
                                    class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                    data-toggle="collapse"
                                    :to="{ name: 'dispatch' }"
                                >
                                    Dispatch
                                </router-link>
                                <router-link
                                    class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                    data-toggle="collapse"
                                    :to="{ name: 'investigation' }"
                                >
                                    Investigation
                                </router-link>
                                <router-link
                                    class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                    data-toggle="collapse"
                                    :to="{ name: 'crime' }"
                                >
                                    Crime
                                </router-link>
                                <router-link
                                    class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                    data-toggle="collapse"
                                    :to="{ name: 'othersIndex' }"
                                >
                                    Others
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                        <div class="ml-3 relative">
                            <div>
                                <router-link
                                    class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                    data-toggle="collapse"
                                    v-if="!isLoggedIn"
                                    :to="{ name: 'login' }"
                                >
                                    Login
                                </router-link>
                                <router-link
                                    class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                    data-toggle="collapse"
                                    v-if="!isLoggedIn"
                                    :to="{ name: 'register' }"
                                >
                                    Register
                                </router-link>
                                <div>
                                    <div class="inline-block"
                                    v-if="isLoggedIn">
                                        <router-link
                                            class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                            data-toggle="collapse"
                                            v-if="user.permission"
                                            :to="{ name: 'admin' }"
                                        >
                                            Admin Dashboard
                                        </router-link>

                                    </div>
                                    <div
                                        class="inline-block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                        data-toggle="collapse"
                                        v-if="isLoggedIn"
                                        @click="logout"
                                    >
                                        Logout
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile menu, show/hide based on menu state. -->
        </nav>
        <notifications position="bottom right"/>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            user: {}
        }
    },

    computed: {
        isLoggedIn(){
            try {
                this.user = JSON.parse(localStorage.getItem('user'));
            }
            catch(e) {
                localStorage.removeItem('user');
                this.user = JSON.parse(localStorage.getItem('user'));
            }
            return this.user;
        }

    },

    methods: {
        async logout() {
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/api/logout').then(response => {
                if (response.data.success) {
                    localStorage.removeItem('user');
                    this.isLoggedIn();
                } else {
                    console.log(response);
                }
            })
                .catch(function (error) {
                    console.error(error);
                }).finally(function (){
                    localStorage.setItem('user', null);
                    window.location.href = "/";
                });
        }
    },
};


</script>
