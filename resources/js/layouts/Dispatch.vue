<template>
    <div class="flex flex-no-wrap bg-gray-200" style="height: 85vh">
        <!-- Sidebar starts -->
        <!-- Remove class [ hidden ] and replace [ sm:flex ] with [ flex ] -->

        <sidebar-menu :menu="menu" :relative="true" :width="'270px'"/>

<!--        <div class="w-64 absolute sm:relative bg-gray-800 shadow md:h-full flex-col justify-between hidden sm:flex">-->
<!--            <div class="px-8">-->
<!--                <div class="h-16 w-full flex items-center">-->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192.756 192.756">-->
<!--                        <g fill-rule="evenodd" clip-rule="evenodd">-->
<!--                            <path fill="#fff" fill-opacity="0" d="M0 0h192.756v192.756H0V0z"/>-->
<!--                            <path d="M22.462 91.654h8.968c.733 0 1.287.161 1.664.483.451.379.677 1.005.677 1.876 0 .872-.226 1.498-.677 1.876-.376.303-.931.456-1.664.456h-8.968v-4.691zm-6.205 14.502h6.205V101.4h8.968c3.309 0 5.499-.404 6.571-1.215 1.297-.961 1.946-3.023 1.946-6.186 0-3.182-.658-5.254-1.974-6.214-1.053-.791-3.234-1.187-6.543-1.187H16.257v19.558zM54.907 91.998c.592-.405 2.674-.608 6.247-.608 3.554 0 5.626.203 6.219.608.592.406.888 1.871.888 4.397 0 2.508-.296 3.969-.888 4.383-.593.416-2.675.623-6.247.623-3.554 0-5.626-.207-6.219-.623-.593-.414-.888-1.875-.888-4.383 0-2.526.295-3.992.888-4.397zM72.66 87.83c-1.278-.997-5.123-1.496-11.534-1.496-6.43 0-10.285.508-11.562 1.524-1.166.94-1.749 3.79-1.749 8.548 0 3.461.188 5.736.564 6.828.489 1.391 1.654 2.303 3.497 2.736 1.466.301 4.55.451 9.25.451 6.43 0 10.285-.49 11.563-1.467 1.184-.941 1.777-3.791 1.777-8.549-.001-4.757-.602-7.615-1.806-8.575zM82.281 86.632h6.205v14.47h14.073v5.054H82.281V86.632zM109.23 106.156V86.665h6.204v19.491h-6.204zM134.602 86.334c5.752 0 9.297.47 10.631 1.407 1.166.788 1.75 2.918 1.75 6.39h-6.232c0-1.149-.311-1.875-.932-2.177-.771-.377-2.51-.565-5.217-.565-3.027 0-4.805.227-5.33.679-.527.453-.789 1.895-.789 4.327 0 2.414.262 3.852.789 4.312.525.463 2.303.693 5.33.693 2.744 0 4.461-.16 5.146-.48s1.029-1.076 1.029-2.262h6.205c0 3.482-.564 5.617-1.691 6.408-1.336.904-4.898 1.355-10.689 1.355s-9.293-.504-10.506-1.51-1.818-3.85-1.818-8.533c0-4.646.582-7.467 1.748-8.464 1.259-1.052 4.785-1.58 10.576-1.58zM154.783 106.156V86.599h21.715v4.724h-15.512v2.71h14.807v4.723h-14.807v2.676h15.512v4.724h-21.715z"/>-->
<!--                        </g>-->
<!--                    </svg>-->
<!--                </div>-->
<!--                <ul class="mt-12">-->
<!--                    <router-link :to="{name: 'dispatch'}" active-class="active">-->
<!--                        <li class="flex w-full justify-between text-gray-300 hover:text-gray-500 cursor-pointer items-center mb-6">-->
<!--                            <div class="flex items-center">-->
<!--                                <span class="text-sm ml-2">Home</span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                    </router-link>-->
<!--                    <router-link :to="{name: 'management'}" active-class="active">-->
<!--                        <li class="flex w-full justify-between text-gray-300 hover:text-gray-500 cursor-pointer items-center mb-6">-->
<!--                            <div class="flex items-center">-->
<!--                                <span class="text-sm ml-2">Managment</span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                    </router-link>-->
<!--                    <router-link :to="{name: 'dispatchUnit'}" active-class="active">-->
<!--                        <li class="flex w-full justify-between text-gray-300 hover:text-gray-500 cursor-pointer items-center mb-6">-->
<!--                            <div class="flex items-center">-->
<!--                                <span class="text-sm ml-2">Units</span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                    </router-link>-->
<!--                    <li class="flex w-full justify-between text-gray-300 hover:text-gray-500 cursor-pointer items-center mb-6">-->
<!--                        <div class="flex items-center">-->
<!--                            <span class="text-sm ml-2">On Duty: asd</span>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                </ul>-->
<!--                <div class="flex justify-center mt-48 mb-4 h-32 w-full">-->
<!--                    &lt;!&ndash;                    <div class="relative">&ndash;&gt;-->
<!--                    &lt;!&ndash;                        <div class="text-gray-500 absolute ml-4 inset-0 m-auto w-4 h-4">&ndash;&gt;-->
<!--                    &lt;!&ndash;                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">&ndash;&gt;-->
<!--                    &lt;!&ndash;                                <path stroke="none" d="M0 0h24v24H0z"></path>&ndash;&gt;-->
<!--                    &lt;!&ndash;                                <circle cx="10" cy="10" r="7"></circle>&ndash;&gt;-->
<!--                    &lt;!&ndash;                                <line x1="21" y1="21" x2="15" y2="15"></line>&ndash;&gt;-->
<!--                    &lt;!&ndash;                            </svg>&ndash;&gt;-->
<!--                    &lt;!&ndash;                        </div>&ndash;&gt;-->
<!--                    &lt;!&ndash;                        <input class="bg-gray-700 focus:outline-none rounded w-full text-sm text-gray-500 pl-10 py-2" type="text" placeholder="Search" />&ndash;&gt;-->
<!--                    &lt;!&ndash;                    </div>&ndash;&gt;-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <!-- Sidebar ends -->
        <!-- Remove class [ h-64 ] when adding a card block -->
        <div class="container mx-auto py-10 md:w-4/5 w-11/12 px-6 h-96">
            <!-- Remove class [ border-dashed border-2 border-gray-300 ] to remove dotted border -->
            <!-- Place your content here -->
                <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners'
import { SidebarMenu } from 'vue-sidebar-menu'

export default {
    name: "DispatchLayout",
    data() {
        return {
            user: {},
            policemans: null,
            isLoading: false,
            menu: [
                {
                    header: true,
                    title: 'Dispatch Software',
                    hiddenOnCollapse: true,
                },
                {
                    href: '/dispatch',
                    title: 'Dashboard',
                    icon: 'fas fa-tachometer-alt',
                },
                {
                    href: '/dispatch/manage',
                    title: 'Management',
                    icon: 'fas fa-cog',
                    child: [
                        {
                            href: '/charts/sublink',
                            title: 'Sub Link'
                        }
                    ]
                },
                {
                    href: '/dispatch/unit',
                    title: 'Unit',
                    icon: 'fas fa-users',
                }
            ]

        }
    },

    components: {
        HashLoader,
        SidebarMenu,
    },
}
</script>
