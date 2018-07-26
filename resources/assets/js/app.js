
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';

window.Vue.use(VueRouter);
import DashboardsIndex from './components/dashboards/DashboardsIndex.vue';
import UsersIndex from './components/users/UsersIndex.vue';
import UsersCreate from './components/users/UsersCreate.vue';
import UsersEdit from './components/users/UsersEdit.vue';
import CompaniesIndex from './components/companies/CompaniesIndex.vue';
import CompaniesCreate from './components/companies/CompaniesCreate.vue';
import CompaniesEdit from './components/companies/CompaniesEdit.vue';
import DepartmentsIndex from './components/departments/DepartmentsIndex.vue';
import DepartmentsCreate from './components/departments/DepartmentsCreate.vue';
import DepartmentsEdit from './components/departments/DepartmentsEdit.vue';
import LocationsIndex from './components/locations/LocationsIndex.vue';
import LocationsCreate from './components/locations/LocationsCreate.vue';
import LocationsEdit from './components/locations/LocationsEdit.vue';
import ProjectsIndex from './components/projects/ProjectsIndex.vue';
import ProjectsCreate from './components/projects/ProjectsCreate.vue';
import ProjectsEdit from './components/projects/ProjectsEdit.vue';
import PositionsIndex from './components/positions/PositionsIndex.vue';
import PositionsCreate from './components/positions/PositionsCreate.vue';
import PositionsEdit from './components/positions/PositionsEdit.vue';
const routes = [
    {
        path: '/',
        components: {
            dashboardsIndex: DashboardsIndex,
            usersIndex: UsersIndex,
            companiesIndex: CompaniesIndex,
            departmentsIndex: DepartmentsIndex,
            locationsIndex: LocationsIndex,
            projectsIndex: ProjectsIndex,
            positionsIndex: PositionsIndex,
        }
    },
    {path: '/admin/users/create', component: UsersCreate, name: 'createUser'},
    {path: '/admin/users/edit/:id', component: UsersEdit, name: 'editUser'},
    {path: '/admin/companies/create', component: CompaniesCreate, name: 'createCompany'},
    {path: '/admin/companies/edit/:id', component: CompaniesEdit, name: 'editCompany'},
    {path: '/admin/departments/create', component: DepartmentsCreate, name: 'createDepartment'},
    {path: '/admin/departments/edit/:id', component: DepartmentsEdit, name: 'editDepartment'},
    {path: '/admin/locations/create', component: LocationsCreate, name: 'createLocation'},
    {path: '/admin/locations/edit/:id', component: LocationsEdit, name: 'editLocation'},
    {path: '/admin/projects/create', component: ProjectsCreate, name: 'createProject'},
    {path: '/admin/projects/edit/:id', component: ProjectsEdit, name: 'editProject'},
    {path: '/admin/positions/create', component: PositionsCreate, name: 'createPosition'},
    {path: '/admin/positions/edit/:id', component: PositionsEdit, name: 'editPosition'},
]

const router = new VueRouter({ routes })
const app = new Vue({ router }).$mount('#app')