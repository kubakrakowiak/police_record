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

    name: "InvestigationLayout",
    data() {
        return {
            isLoading: false,
            menu: [
                {
                    header: true,
                    title: 'Investigation Management',
                    hiddenOnCollapse: true,
                },
                {
                    href: '/investigation',
                    title: 'Dashboard',
                    icon: 'fas fa-tachometer-alt',
                },
                {
                    href: '/investigation/list',
                    title: 'List',
                    icon: 'fas fa-list',
                },
                {
                    href: '/investigation/create',
                    title: 'Create',
                    icon: 'fas fa-plus',
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
