<template>
    <div class="flex flex-no-wrap bg-gray-200" style="height: 85vh">
        <sidebar-menu :menu="menu" :relative="true" :width="'270px'"/>
        <div class="container mx-auto py-10 md:w-4/5 w-11/12 px-6 h-96">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners'
import { SidebarMenu } from 'vue-sidebar-menu'

export default {
    name: "OthersLayout",
    data() {
        return {
            isLoading: false,
            menu: [
                {
                    header: true,
                    title: 'Other Tools',
                    hiddenOnCollapse: true,
                },
                {
                    href: '/others',
                    title: 'Dashboard',
                    icon: 'fas fa-tachometer-alt',
                },
                {
                    href: '',
                    title: 'Licenses',
                    icon: 'fas fa-id-card',
                    child: [
                        {
                            href: '/others/licenses/list',
                            title: 'List'
                        },
                        {
                            href: '/others/licenses/history',
                            title: 'Logs'
                        }
                    ]
                },
                {
                    href: '',
                    title: 'Vehicles',
                    icon: 'fas fa-car',
                    child: [
                        {
                            href: '/others/vehicles/list',
                            title: 'List'
                        },
                        {
                            href: '/others/vehicles/revoke',
                            title: 'Revoke'
                        }
                    ]
                },
                {
                    href: '',
                    title: 'Items',
                    icon: 'fas fa-hammer',
                    child: [
                        {
                            href: '/others/items/list',
                            title: 'List'
                        },
                        {
                            href: '/others/items/give',
                            title: 'Give'
                        }
                    ]
                }
            ]
        }
    },

    components: {
        HashLoader,
        SidebarMenu
    },
}
</script>
