<template>
    <div class="flex flex-no-wrap bg-gray-200" style="height: 85vh">
        <sidebar-menu :menu="menu" :relative="true" :width="'270px'"/>
        <div class="container mx-auto py-8 md:w-4/5 w-11/12 px-6 h-96">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners'
import { SidebarMenu } from 'vue-sidebar-menu'

export default {

    name: "AdminLayout",
    data() {
        return {
            isLoading: false,
            menu: [
                {
                    header: true,
                    title: 'Admin Dashboard',
                    hiddenOnCollapse: true,
                },
                {
                    href: '/admin',
                    title: 'Dashboard',
                    icon: 'fas fa-tachometer-alt',
                },
                {
                    href: '',
                    title: 'Users',
                    icon: 'fas fa-user',
                    child: [
                        {
                            href: '/admin/user/list',
                            title: 'List'
                        },
                        {
                            href: '/admin/user/create',
                            title: 'Create'
                        }
                    ]
                },
                {
                    href: '/admin/grade/list',
                    title: 'Grades',
                    icon: 'fas fa-address-card',
                },
                {
                    href: '/admin/tariff',
                    title: 'Tariffs',
                    icon: 'fas fa-list',
                },
            ]

        }
    },

    components: {
        HashLoader,
        SidebarMenu,
    },
}
</script>
