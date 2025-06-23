<template>
   
       <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
            <!--begin::Logo-->
            <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
              <!--begin::Logo image-->
              <a href="index.html">
                <img alt="Logo" src="/assets/media/logos/default-dark.png" class="h-25px app-sidebar-logo-default" />
                <img alt="Logo" src="/assets/media/logos/default-dark.png" class="h-20px app-sidebar-logo-minimize" />
              </a>
              
              <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
                <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                  <span class="path1"></span>
                  <span class="path2"></span>
                </i>
              </div>
              <!--end::Sidebar toggle-->
            </div>
            <!--end::Logo-->
            <!--begin::sidebar menu-->
            <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
              <!--begin::Menu wrapper-->
              <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
                <!--begin::Scroll wrapper-->
                <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                  <!--begin::Menu-->
                  <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                    <!--begin:Menu item-->
           
               
            
                  
                  
             
               
              
             
              
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                            <!--begin:Menu link-->
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-address-book fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">User Management</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <router-link :to="`/${locale}/dashboard/user_management/users`" class="menu-link">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Users List</span>
                                            </router-link>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <router-link :to="`/${locale}/dashboard/HR/departments`" class="menu-link">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Departments</span>
                                            </router-link>
                                            <!--end:Menu link-->
                                        </div>
                                      
                                     
                                        <!--end:Menu item-->
                                    </div>
                                    <!--end:Menu sub-->
                                </div>


                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                            <!--begin:Menu link-->
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-address-book fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">Master Data </span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <router-link :to="`/${locale}/dashboard/master_data/category/criteria`" class="menu-link">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">SOI Criteria List</span>
                                            </router-link>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <router-link :to="`/${locale}/dashboard/master_data/category/vendors`" class="menu-link">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Vendors List</span>
                                            </router-link>
                                            <!--end:Menu link-->
                                        </div>




                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <router-link :to="`/${locale}/dashboard/master_data/category/category`" class="menu-link">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Category RFP</span>
                                            </router-link>
                                            <!--end:Menu link-->
                                        </div>


                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <router-link :to="`/${locale}/dashboard/master_data/category/contract`" class="menu-link">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Contract RFP</span>
                                            </router-link>
                                            <!--end:Menu link-->
                                        </div>



                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <router-link :to="`/${locale}/dashboard/master_data/category/documents`" class="menu-link">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Documents List</span>
                                            </router-link>
                                            <!--end:Menu link-->
                                        </div>




                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <router-link :to="`/${locale}/dashboard/master_data/category/te-criteria`" class="menu-link">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">TECh Criteria List</span>
                                            </router-link>
                                            <!--end:Menu link-->
                                        </div>


                                      
                                     
                                        <!--end:Menu item-->
                                    </div>
                                    <!--end:Menu sub-->
                                </div>



                                  <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-abstract-28 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Steps Management</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion">
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                    <!--begin:Menu link-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->


                                        <router-link :to="`/${locale}/dashboard/master_data/projects/rfp`" class="menu-link">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">RFP File</span>
                                        </router-link>


                                        <router-link :to="`/${locale}/dashboard/master_data/projects/list`" class="menu-link">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Projects</span>
                                        </router-link>
                                        <!--end:Menu link-->

                                        <router-link :to="`/${locale}/dashboard/master_data/projects/rfp-index`" class="menu-link">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">RFP</span>
                                        </router-link>



                                    </div>


                            

                                </div>
                                <!--end:Menu item-->
                              
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        

         
                  
                   
                  



                  </div>
                  <!--end::Menu-->
                </div>
                <!--end::Scroll wrapper-->
              </div>
              <!--end::Menu wrapper-->
            </div>
      
            <!--end::Footer-->
          </div>

</template>

<script>
    export default {
       name : 'Menu',

       computed: {
    locale() {
        return this.$route.params.locale;
    }
}
    }
</script>
