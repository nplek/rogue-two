
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueSession from 'vue-session'
window.Vue.use(VueRouter);
window.Vue.use(VueSession);

import HomeIndex from './components/homeIndex.vue';
import DashboardsIndex from './components/dashboards/DashboardsIndex.vue';
import UsersIndex from './components/users/UsersIndex.vue';
import UsersCreate from './components/users/UsersCreate.vue';
import UsersEdit from './components/users/UsersEdit.vue';
import RolesIndex from './components/roles/RolesIndex.vue';
import RolesCreate from './components/roles/RolesCreate.vue';
import RolesEdit from './components/roles/RolesEdit.vue';
import PermissionsIndex from './components/permissions/PermissionsIndex.vue';
import PermissionsCreate from './components/permissions/PermissionsCreate.vue';
import PermissionsEdit from './components/permissions/PermissionsEdit.vue';
import TeamsIndex from './components/teams/TeamsIndex.vue';
import TeamsCreate from './components/teams/TeamsCreate.vue';
import TeamsEdit from './components/teams/TeamsEdit.vue';
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
import EmployeesIndex from './components/employees/EmployeesIndex.vue';
import EmployeesEdit from './components/employees/EmployeesEdit.vue';
import EmployeesShow from './components/employees/EmployeesShow.vue';
import ActivityLogsIndex from './components/logs/ActivityLogsIndex.vue';
import AccessLogsIndex from './components/logs/AccessLogsIndex.vue';
import SecurityLogsIndex from './components/logs/SecurityLogsIndex.vue';
import LoginPage from './components/auth/LoginPage.vue';

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);
const routes = [
    {
        path: '/',
        components: {
            homeIndex: HomeIndex,
            loginPage: LoginPage,
            dashboardsIndex: DashboardsIndex,
            usersIndex: UsersIndex,
            rolesIndex: RolesIndex,
            permissionsIndex: PermissionsIndex,
            teamsIndex: TeamsIndex,
            activityLogsIndex: ActivityLogsIndex,
            accessLogsIndex: AccessLogsIndex,
            securityLogsIndex: SecurityLogsIndex,
            companiesIndex: CompaniesIndex,
            departmentsIndex: DepartmentsIndex,
            locationsIndex: LocationsIndex,
            projectsIndex: ProjectsIndex,
            positionsIndex: PositionsIndex,
            employeesIndex: EmployeesIndex,
        }
    },
    {path: '/admin/users/create', component: UsersCreate, name: 'createUser'},
    {path: '/admin/users/edit/:id', component: UsersEdit, name: 'editUser'},
    {path: '/admin/roles/create', component: RolesCreate, name: 'createRole'},
    {path: '/admin/roles/edit/:id', component: RolesEdit, name: 'editRole'},
    {path: '/admin/permissions/create', component: PermissionsCreate, name: 'createPermission'},
    {path: '/admin/permissions/edit/:id', component: PermissionsEdit, name: 'editPermission'},
    {path: '/admin/teams/create', component: TeamsCreate, name: 'createTeam'},
    {path: '/admin/teams/edit/:id', component: TeamsEdit, name: 'editTeam'},
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
    {path: '/admin/employees/edit/:id', component: EmployeesEdit, name: 'editEmployee'},
    {path: '/admin/employees/show/:id', component: EmployeesShow, name: 'showEmployee'},
]

const router = new VueRouter({ routes })
const app = new Vue({ router }).$mount('#app')