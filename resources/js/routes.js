
import { createRouter, createWebHistory } from 'vue-router';

import Landing from './components/Website/pages/Landing.vue';
import Login from './components/Website/auth/Login.vue';
import AuthLayout from './components/Website/auth/AuthLayout.vue';
import Dashboard from './components/Dashboard/pages/Dashboard.vue';
import DashboardVendor from './components/Dashboard/pages/DashboardVendor.vue';
import Pricing from './components/Dashboard/pages/buyer/Pricing.vue';
import PricingSheet from './components/Dashboard/pages/buyer/PricingSheet.vue';
import PDFHtml from './components/Dashboard/pages/buyer/PDFHtml.vue';

import Users from './components/Dashboard/pages/UserManagement/Users.vue';
import Vendors from './components/Dashboard/pages/UserManagement/Vendors.vue';
import Roles from './components/Dashboard/pages/UserManagement/Roles.vue';

// HR Begin
import Department from './components/Dashboard/pages/HR/Department.vue';
import Section from './components/Dashboard/pages/HR/Section.vue';
import Position from './components/Dashboard/pages/HR/Position.vue';
import Employee from './components/Dashboard/pages/HR/Employee.vue';
import EmployeePosition from './components/Dashboard/pages/HR/EmployeePosition.vue';
import PositionHistory from './components/Dashboard/pages/HR/PositionHistory.vue';


// Master Data Begin
import ItemsCategories from './components/Dashboard/pages/MasterData/ItemsCategories.vue';
import ItemsObjects from './components/Dashboard/pages/MasterData/ItemsObjects.vue';
import Projects from './components/Dashboard/pages/MasterData/Projects.vue';
import RFPIndex from './components/Dashboard/pages/MasterData/IndexRFP.vue';
import RFPStep from './components/Dashboard/pages/MasterData/RFPStep.vue';
import Steps from './components/Dashboard/pages/MasterData/Steps.vue';
import RFP from './components/Dashboard/pages/MasterData/RFP.vue';
import StepTemplate from './components/Dashboard/pages/MasterData/StepTemplate.vue';



// Review Team

import IndexReview from './components/Dashboard/pages/Review/Index.vue';
import ReviewStep from './components/Dashboard/pages/Review/ReviewStep.vue';



// SOI Team

import IndexSOI from './components/Dashboard/pages/SOI/Index.vue';
import SOIStep from './components/Dashboard/pages/SOI/SOIStep.vue';




// Vendor Team

import IndexSVendor from './components/Dashboard/pages/Vendor/Index.vue';
import VendorStep from './components/Dashboard/pages/Vendor/VendorStep.vue';




// Buyer Team

import VendorsResponseIndex from './components/Dashboard/pages/buyer/VendorsResponseIndex.vue';
import VendorsResponseRfp from './components/Dashboard/pages/buyer/VendorsResponseRfp.vue';





const routes = [
    { 
        path: '/:locale/',
        component: Landing 
    },
    
    {
        path: '/:locale/login',
        component: AuthLayout,
        children: [
            { path: '', component: Login } // صفحة تسجيل الدخول بدون هيدر وفوتر
        ]
    },

    { 
        path: '/:locale/dashboard', 
        component: Dashboard, 
        meta: { requiresAuth: true } 
    },

    { 
        path: '/:locale/vendor', 
        component: DashboardVendor, 
        meta: { requiresAuth: true } 
    },


    { 
        path: '/:locale/dashboard/buyer/pricing', 
        component: Pricing, 
        meta: { requiresAuth: true } 
    },


    { 
        path: '/:locale/dashboard/buyer/pricing-sheet', 
        component: PricingSheet, 
        meta: { requiresAuth: true } 
    },

    { 
        path: '/:locale/dashboard/buyer/pdf-html', 
        component: PDFHtml, 
        meta: { requiresAuth: true } 
    },
    
    { 
        path: '/:locale/dashboard/user_management/users', 
        component: Users, 
        meta: { requiresAuth: true , breadcrumb: 'Users Management' } 
    },

    { 
        path: '/:locale/dashboard/user_management/vendors', 
        component: Vendors, 
        meta: { requiresAuth: true , breadcrumb: 'Vendors Management' } 
    },


    { 
        path: '/:locale/dashboard/user_management/roles', 
        component: Roles, 
        meta: { requiresAuth: true, breadcrumb: 'Roles Management' } 
    },




    { 
        path: '/:locale/dashboard/HR/departments', 
        component: Department, 
        meta: { requiresAuth: true, breadcrumb: 'Departments Management' } 
    },


    { 
        path: '/:locale/dashboard/HR/sections', 
        component: Section, 
        meta: { requiresAuth: true, breadcrumb: 'Sections Management' } 
    },


    { 
        path: '/:locale/dashboard/HR/positions', 
        component: Position, 
        meta: { requiresAuth: true, breadcrumb: 'Positions Management' } 
    },

    { 
        path: '/:locale/dashboard/HR/employees', 
        component: Employee, 
        meta: { requiresAuth: true, breadcrumb: 'Employees Management' } 
    },

    { 
        path: '/:locale/dashboard/HR/employee_positions', 
        component: EmployeePosition, 
        meta: { requiresAuth: true, breadcrumb: 'Employees Positions Management' } 
    },

    { 
        path: '/:locale/dashboard/HR/PositionHistory', 
        component: PositionHistory, 
        meta: { requiresAuth: true, breadcrumb: 'PositionHistory Management' } 
    },


    // { 
    //     path: '/:locale/dashboard/master_data/categories', 
    //     component: ItemsCategories, 
    //     meta: { requiresAuth: true, breadcrumb: 'Categories Management' } 
    // },

    
    {
    path: '/:locale/dashboard/master_data/category/:category',
    component: ItemsCategories,
    props: true,
    meta: { requiresAuth: true },
        beforeEnter: (to, from, next) => {
            to.meta.breadcrumb = `${to.params.category.charAt(0).toUpperCase() + to.params.category.slice(1)} Category Management`;
            next();
        }
    },




    { 
        path: '/:locale/dashboard/master_data/projects/list', 
        component: Projects, 
        meta: { requiresAuth: true, breadcrumb: 'Projects Management' } 
    },



    { 
        path: '/:locale/dashboard/master_data/projects/rfp-index', 
        component: RFPIndex, 
        meta: { requiresAuth: true, breadcrumb: 'RFP Management' } 
    },


    { 
        path: '/:locale/dashboard/master_data/projects/rfp-step', 
        component: RFPStep, 
        meta: { requiresAuth: true, breadcrumb: 'RFP Management' } 
    },


    { 
        path: '/:locale/dashboard/master_data/projects/steps', 
        component: Steps, 
        meta: { requiresAuth: true, breadcrumb: 'Steps Management' } 
    },


    { 
        path: '/:locale/dashboard/master_data/projects/rfp', 
        component: RFP, 
        meta: { requiresAuth: true, breadcrumb: 'RFP File Management' } 
    },


    { 
        path: '/:locale/dashboard/master_data/projects/step-template', 
        component: StepTemplate, 
        meta: { requiresAuth: true, breadcrumb: 'Steps Management' } 
    },




    { 
        path: '/:locale/dashboard/review/rfp', 
        component: IndexReview, 
        meta: { requiresAuth: true, breadcrumb: 'RFP Management' } 
    },


    { 
        path: '/:locale/dashboard/review/rfp-step', 
        component: ReviewStep, 
        meta: { requiresAuth: true, breadcrumb: 'RFP Management' } 
    },



    { 
        path: '/:locale/dashboard/soi/rfp', 
        component: IndexSOI, 
        meta: { requiresAuth: true, breadcrumb: 'RFP Management' } 
    },


    { 
        path: '/:locale/dashboard/soi/rfp-step', 
        component: SOIStep, 
        meta: { requiresAuth: true, breadcrumb: 'RFP Management' } 
    },




    { 
        path: '/:locale/dashboard/vendor/rfp', 
        component: IndexSVendor, 
        meta: { requiresAuth: true, breadcrumb: 'RFP Management' } 
    },


    { 
        path: '/:locale/dashboard/vendor/rfp-step', 
        component: VendorStep, 
        meta: { requiresAuth: true, breadcrumb: 'RFP Management' } 
    },


    { 
        path: '/:locale/dashboard/buyer/vendors-response-index', 
        component: VendorsResponseIndex, 
        meta: { requiresAuth: true, breadcrumb: 'RFP Management' } 
    },


    { 
        path: '/:locale/dashboard/buyer/vendors-response-rfp', 
        component: VendorsResponseRfp, 
        meta: { requiresAuth: true, breadcrumb: 'RFP Management' } 
    },




    // {
    // path: '/:locale/dashboard/master_data/:object',
    // component: ItemsObjects,
    // props: true,
    // meta: { requiresAuth: true },
    //     beforeEnter: (to, from, next) => {
    //         // قم بتحديث breadcrumb بناءً على قيمة :object من الرابط
    //         to.meta.breadcrumb = `${to.params.object.charAt(0).toUpperCase() + to.params.object.slice(1)} Management`;
    //         next();
    //     }
    // },









];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Middleware للتحقق من اللغة والتحقق من المصادقة
router.beforeEach((to, from, next) => {
    const locale = to.params.locale || 'en'; // تحديد اللغة الافتراضية
    
    // التحقق من أن اللغة صحيحة (ar أو en)
    if (!['en', 'ar'].includes(locale)) {
        return next('/en'); // إعادة التوجيه للغة الافتراضية إذا كانت اللغة غير صالحة
    }

    // التحقق من المصادقة إذا كانت مطلوبة
    const isAuthenticated = localStorage.getItem('authToken');
    if (to.meta.requiresAuth && !isAuthenticated) {
        // return next(`/${locale}/login`);
        let url = window.location.origin ;
        window.open(url+'/login',"_self") 
    }

    // السماح بالانتقال إلى الصفحة
    next();
});

export default router;




