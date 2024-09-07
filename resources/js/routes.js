import Dashboard from "../components/Admin/Dashboard.vue"
import ListAppointments from "../components/Admin/Pages/Appointments/ListAppointments.vue"
import Appointment from "../components/Admin/Pages/Appointments/Appointment.vue"
import ListUsers from "../components/Admin/Pages/Users/ListUsers.vue"
import UpdateSettings from "../components/Admin/Pages/Settings/UpdateSettings.vue"
import Profile from "../components/Admin/Pages/Profile/UpdateProfile.vue"
import Logout from "../components/Admin/Logout.vue"
import Chat from "../components/Admin/Pages/chat/chat.vue"
export default[


    {
        path:'/admin/dashboard',
        name: 'admin.dashboard',
        component: Dashboard,
    },

    {
        path:'/admin/appointments',
        name: 'admin.listAppointments',
        component: ListAppointments,
    },
    {
        path:'/admin/appointments/create',
        name: 'admin.appointment.create',
        component: Appointment,
    },
    {
        path:'/admin/appointments/:id/edit',
        name: 'admin.appointment.edit',
        component: Appointment,
    },
    {
        path:'/admin/listUsers',
        name: 'admin.listUsers',
        component: ListUsers,
    },
    {
        path:'/admin/chat',
        name: 'admin.chat',
        component: Chat,
    },
    {
        path:'/admin/updateSettings',
        name: 'admin.updateSettings',
        component: UpdateSettings,
    },
    {
        path:'/admin/profile',
        name: 'admin.profile',
        component: Profile,
    },
    {
        path:'/admin/logout',
        name: 'admin.logout',
        component: Logout,
    },
]
