import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './pages/Home.vue';
import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import Dashboard from './pages/Dashboard.vue';
import Policemans from './pages/Policemans.vue';
import Dispatch from "./layouts/Dispatch";
import DispatchIndex from "./pages/Dispatch/Index";
import DispatchUnit from "./pages/Dispatch/Unit";
import Management from "./pages/Dispatch/Management";
import Investigation from "./layouts/Investigation";
import InvestigationIndex from "./pages/Investigation/Index";
import InvestigationList from "./pages/Investigation/List";
import InvestigationCreate from "./pages/Investigation/Create";
import InvestigationShow from "./pages/Investigation/Show";
import Crime from "./layouts/Crime";
import CrimeIndex from "./pages/Crime/Index";
import CrimeList from "./pages/Crime/List";
import CrimeCreate from "./pages/Crime/Create";
import CrimeCriminals from "./pages/Crime/Criminals";
import CrimeShow from "./pages/Crime/Show";
import Others from "./layouts/Others.vue";
import CharacterIndex from "./pages/Others/Character/Index";
import CharacterShow from "./pages/Others/Character/Show";
import LicensesIndex from "./pages/Others/Licenses/Index";
import LicensesList from "./pages/Others/Licenses/List";
import LicensesHistory from "./pages/Others/Licenses/History";
import OthersIndex from "./pages/Others/Index";
import OthersList from "./pages/Others/List";
import OthersCreate from "./pages/Others/Create";
import OthersShow from "./pages/Others/Show";
import Admin from "./layouts/Admin";
import AdminIndex from "./pages/Admin/Index";
import AdminCreateUser from "./pages/Admin/User/Create";
import AdminListUser from "./pages/Admin/User/List";
import AdminEditUser from "./pages/Admin/User/Edit";
import AdminListGrade from "./pages/Admin/Grade/List";
import AdminListTariff from "./pages/Admin/Tariff/List";


Vue.use(VueRouter);

const guard = async function(to, from, next) {
    if(this.$root.user){
        next()
    }
    console.log('blad')
};

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        // {
        //     path: '/register',
        //     name: 'register',
        //     component: Register
        // },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
        },
        {
            path: '/policemans',
            name: 'policemans',
            component: Policemans,
            // beforeEnter: (to, from, next) => {
            //     guard(to, from, next)
            // }
        },
        {
            path: '/dispatch',
            component: Dispatch,
            children: [
                {
                    path: '',
                    component: DispatchIndex,
                    name: 'dispatch',
                },
                {
                    path: 'unit',
                    component: DispatchUnit,
                    name: 'dispatchUnit',
                },
                {
                    path: 'manage',
                    component: Management,
                    name: 'management',
                }],
        },
        {
            path: '/investigation',
            component: Investigation,
            children: [
                {
                    path: '',
                    component: InvestigationIndex,
                    name: 'investigation',
                },
                {
                    path: 'list',
                    component: InvestigationList,
                    name: 'investigationList',
                },
                {
                    path: 'create',
                    component: InvestigationCreate,
                    name: 'investigationCreate',
                },
                {
                    path: ':id',
                    component: InvestigationShow,
                    name: "investigationShow"
                }
            ],
        },
        {
            path: '/crime',
            component: Crime,
            children: [
                {
                    path: '',
                    component: CrimeIndex,
                    name: 'crime',
                },
                {
                    path: 'list',
                    component: CrimeList,
                    name: 'crimeList',
                },
                {
                    path: 'create',
                    component: CrimeCreate,
                    name: 'crimeCreate',
                },
                {
                    path: 'criminals',
                    component: CrimeCriminals,
                    name: 'crimeCriminals',
                },
                {
                    path: ':id',
                    component: CrimeShow,
                    name: "crimeShow"
                }
            ],
        },
        {
            path: '/others',
            component: Others,
            name: "others",
            children: [
                {
                    path: '',
                    name: 'othersIndex',
                    component: OthersIndex,
                },
                {
                    path: 'character',
                    component: CharacterIndex,
                    name: 'othersCharacters',
                },
                {
                    path: 'character/:id',
                    component: CharacterShow,
                    name: 'othersCharacterShow',
                },
                {
                    path: 'licenses',
                    name: 'licenses',
                    component: LicensesIndex,
                    children: [
                        {
                            path: 'list',
                            component: LicensesList,
                            name: 'licensesList',
                        },
                        {
                            path: 'history',
                            component: LicensesHistory,
                            name: 'licensesHistory',
                        }
                        ]
                },
            ],
        },
        {
            path: '/admin',
            component: Admin,
            children: [
                {
                    path: '',
                    component: AdminIndex,
                    name: 'admin',
                },
                {
                    path: 'user/create',
                    component: AdminCreateUser,
                    name: 'adminCreateUser',
                },
                {
                    path: 'user/list',
                    component: AdminListUser,
                    name: 'adminListUser',
                },
                {
                    path: 'user/:id',
                    component: AdminEditUser,
                    name: 'adminEditUser',
                },
                {
                    path: 'grade/list',
                    component: AdminListGrade,
                    name: 'adminListGrade',
                },
                {
                    path: 'tariff',
                    component: AdminListTariff,
                    name: 'adminListTariff',
                },
            ],
        },
    ]
});

export default router;
