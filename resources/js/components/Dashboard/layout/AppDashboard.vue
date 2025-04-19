<template>
  
        <div class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="page d-flex flex-row flex-column-fluid">
                <!--begin::Wrapper-->
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    
                    <!--begin::Header-->
                            
                            <HeaderDashboard></HeaderDashboard>

                    <!--end::Header-->


                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Aside-->
                        <Menu></Menu>
                        <!--end::Aside-->
                        <!--begin::Container-->
                        <div class="d-flex flex-column flex-column-fluid container-fluid">
                            <!--begin::Toolbar-->
                              <Breadcrumb></Breadcrumb>
                            <!--end::Toolbar-->                            

                                <router-view :key="$route.fullPath"></router-view>


                            <!--begin::Footer-->
                            
                            <FooterDashboard></FooterDashboard>

                            <!--end::Footer-->



                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Content wrapper-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::Root-->

    
</template>

<script>
import HeaderDashboard from './HeaderDashboard.vue';
import FooterDashboard from './FooterDashboard.vue';
import Breadcrumb from './Breadcrumb.vue';
import Menu from './Menu.vue';
import store from './../../../store';

import { mapActions } from 'vuex';

export default {
    components: {
        HeaderDashboard,
        FooterDashboard,
        Menu,
        Breadcrumb,
        store,
    },




     
 
    mounted() {

        let url = window.location.origin ;
        this.loadScript(url+'/assets/js/custom/apps/user-management/users/list/table.js');
        
        // this.loadScript(url+'/assets/js/custom/apps/user-management/users/list/export-users.js');
        // this.loadScript(url+'/assets/js/custom/apps/user-management/users/list/add.js');
        


        this.fetchLanguages();
        this.fetchUser();





    },

   methods: {

    ...mapActions(['fetchLanguages']), // ربط دالة fetchLanguages هنا
    ...mapActions(['fetchUser']), // ربط دالة fetchLanguages هنا

    
    loadScript(src) {
      let script = document.createElement('script');
      script.src = src;
      script.async = true; // جعل التحميل غير متزامن لتحسين الأداء
      document.body.appendChild(script);
    }
  }
};
</script>

