<template>
 

 <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
      <!--begin::Page-->
      <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <!--begin::Header-->
        



           <!--begin::Header-->
            <HeaderDashboard></HeaderDashboard>
            <!--end::Header-->







          <!-- Menu -->

        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
          


          <!--begin::Aside-->
          <component :is="menuComponent" :userType="userType" />
          <!--end::Aside-->



          <!--begin::Main-->
          <div style="padding: 30px 0px 0px 30px;">
                <router-view :key="$route.fullPath"></router-view>
          </div>
          <!--end:::Main-->




          
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Page-->
    </div>



</template>

<script>
import HeaderDashboard from './HeaderDashboard.vue';
import FooterDashboard from './FooterDashboard.vue';
import Breadcrumb from './Breadcrumb.vue';
import Menu from './Menu.vue';
import MenuReview from './MenuReview.vue';
import MenuVendor from './MenuVendor.vue';
import MenuVendorManagement from './MenuVendorManagement.vue';
import MenuBuyer from './MenuBuyer.vue';
import MenuSOI from './MenuSOI.vue';

import DashboardReview from '../pages/DashboardReview.vue';
import DashboardVendor from '../pages/DashboardVendor.vue';
import DashboardVendorManagement from '../pages/DashboardVendorManagement.vue';
import DashboardBuyer from '../pages/DashboardBuyer.vue';
import DashboardSOI from '../pages/DashboardSOI.vue';
import DashboardAdmin from '../pages/Dashboard.vue';
import { mapGetters } from 'vuex';

import { mapActions, mapState } from 'vuex';

export default {
  components: {
    HeaderDashboard,
    FooterDashboard,
    Breadcrumb,
    Menu,
    MenuReview,
    MenuVendor,
    MenuVendorManagement,
    DashboardVendorManagement,
    MenuBuyer,
    DashboardReview,
    DashboardVendor,
    DashboardBuyer,
    DashboardAdmin,
    DashboardSOI,
    MenuSOI
  }, 

   data() {
    return {
      userType: localStorage.getItem('user_type') || '', // أو من Vuex لاحقًا
    }
  },

  computed: {
    ...mapGetters(['getUser']),
 
    user() {
      return this.getUser;
    },

    // اختار المينيو المناسب
    menuComponent() {

      if (this.userType === 'vendor') return 'MenuVendor';
      if (this.userType === 'vendor_management') return 'MenuVendorManagement';
      if (this.userType === 'buyer') return 'MenuBuyer';
      if (this.userType === 'review') return 'MenuReview';
      if (this.userType === 'soi') return 'MenuSOI';
      return 'Menu';
    },

    contentComponent() {
      if (this.userType === 'vendor') return 'DashboardVendor';
      if (this.userType === 'vendor_management') return 'DashboardVendorManagement';
      if (this.userType === 'buyer') return 'DashboardBuyer';
      if (this.userType === 'review') return 'DashboardReview';
      if (this.userType === 'soi') return 'DashboardSOI';
      return 'Dashboard';
    }
  },

  mounted() {
    const url = window.location.origin;
    this.loadScript(url + '/assets/js/custom/apps/user-management/users/list/table.js');

    this.fetchLanguages();
    this.fetchUser();

  },

  methods: {
    ...mapActions(['fetchLanguages', 'fetchUser']),

    loadScript(src) {
      const script = document.createElement('script');
      script.src = src;
      script.async = true;
      document.body.appendChild(script);
    }
  },


    watch: {
    user(newUser) {
      if (newUser) {
        setTimeout(() => {
        }, 500); // تأخير لمدة 500 ميلي ثانية
      }
    },
  },


}
</script>
<style type="text/css">
  .px-5{
    padding: 0 px !important;
  }
</style>