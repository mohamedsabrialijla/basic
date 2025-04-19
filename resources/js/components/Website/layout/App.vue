<template>
    <div id="app">
       <!--  <component :is="isDashboard ? 'HeaderDashboard' : 'HeaderWebsite'"></component>
        <router-view></router-view>
        <component :is="isDashboard ? 'FooterDashboard' : 'FooterWebsite'"></component> -->

        





         <div class="d-flex flex-column flex-root">
            <!--begin::Header Section-->
                <HeaderWebsite  v-if="!isLoginPage"></HeaderWebsite>
            <!--end::Header Section-->

                <router-view :key="$route.fullPath"></router-view>
            
            <!--begin::Footer Section-->
                <FooterWebsite  v-if="!isLoginPage"></FooterWebsite>
            <!--end::Footer Section-->
            <!--begin::Scrolltop-->
            <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
                <i class="ki-duotone ki-arrow-up">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
            <!--end::Scrolltop-->
        </div>
        <!--end::Root-->
        <!--end::Main-->
        <!--begin::Scrolltop-->
        <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
            <i class="ki-duotone ki-arrow-up">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>


    </div>
</template>

<script>
 

import HeaderWebsite from './Header.vue';
import FooterWebsite from './Footer.vue';

export default {
    components: {
        HeaderWebsite,
        FooterWebsite,
      
    },

     computed: {
    // isDashboard() {
    //   return this.$route.path.includes('/dashboard');
    // }

        isLoginPage() {
            return this.$route.path.includes('/login');
           //   || 
           // this.$route.path.includes('/register') || 
           // this.$route.path.includes('/password/reset');
        }
  }
};
</script>



