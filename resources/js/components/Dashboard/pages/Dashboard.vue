<template>
  <div>
    <component :is="currentDashboardComponent" />
  </div>
</template>

<script>
import DashboardAdmin from './DashboardAdmin.vue';
import DashboardVendor from './DashboardVendor.vue';
import DashboardVendorManagement from './DashboardVendorManagement.vue';
import DashboardBuyer from './DashboardBuyer.vue';
import DashboardReview from './DashboardReview.vue';
import { mapGetters } from 'vuex';

export default {
  components: {
    DashboardAdmin,
    DashboardVendor,
    DashboardVendorManagement,
    DashboardBuyer
  },


   data() {
    return {
      userType: localStorage.getItem('user_type') || '', // أو من Vuex لاحقًا
    }
  },
  
  computed: {
    // ...mapGetters(['getUser']),

    // userType() {
    //   // جلب نوع المستخدم من Vuex أو localStorage
    //   return this.getUser?.type || localStorage.getItem('userType');
    // },

    currentDashboardComponent() {

      switch (this.userType) {
      case 'review':
          // return 'DashboardReview';
          return 'DashboardVendor';
        case 'vendor':
          return 'DashboardVendorManagement';
        case 'vendor_management':
          return 'DashboardVendor';
        case 'buyer':
          return 'DashboardBuyer';
        default:
          return 'DashboardAdmin';
      }
    }
  }
};
</script>

