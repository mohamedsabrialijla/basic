<template>
    <div class="container" style="background:white;">
        <div class="col-md-6 pb-10 pb-lg-0" style="margin-top: 15px">
            <h2> hi , {{ user ? user.name : "Loading..." }}</h2>
        </div>

        <!--begin::Alert-->
 
        <!--end::Alert-->

        <div class="mb-5 hover-scroll-x">
            <div class="d-grid">
                <ul class="nav nav-tabs flex-nowrap text-nowrap">
                    <li class="nav-item">
                        <a
                            class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0"
                            data-bs-toggle="tab"
                            href="#kt_tab_pane_1"
                            id="tabpanel_1"
                            >Information</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0"
                            data-bs-toggle="tab"
                            href="#kt_tab_pane_2"
                            >Rest Password </a
                        >
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0"
                            data-bs-toggle="tab"
                            href="#kt_tab_pane_3"
                            >notes </a
                        >
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content" id="myTabContent">
            <div
                class="tab-pane fade show active"
                id="kt_tab_pane_1"
                role="tabpanel"
            >
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->

                    <!--begin::Card header-->
                    <!--begin::Content-->
                    <div
                        id="kt_account_settings_profile_details"
                        class="collapse show"
                    >
                        <!--begin::Form-->
                        <form
                          id="kt_account_profile_details_form"
                          class="form fv-plugins-bootstrap5 fv-plugins-framework"
                          novalidate="novalidate"
                        >
                          <div class="card-body border-top p-9">
                            <!-- صورة -->
                            <div class="row mb-6 align-items-center">
                              <!-- <label class="col-lg-2 col-form-label fw-semibold fs-6">Image</label> -->
                              <div class="col-lg-10">
                                <div class="image-input image-input-outline" data-kt-image-input="true">
                                  <div
                                    class="image-input-wrapper w-125px h-125px"
                                    :style="{
                                      'background-image':
                                        user.logo
                                          ? `url(${user.logo})`
                                          : 'url(/assets_user/media/avatars/blank.png)',
                                    }"
                                  ></div>

                                  <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change"
                                    data-bs-toggle="tooltip"
                                    aria-label="Change avatar"
                                    data-bs-original-title="Change avatar"
                                  >
                                    <i class="ki-outline ki-pencil fs-7"></i>
                                    <input
                                      type="file"
                                      accept=".png, .jpg, .jpeg"
                                      @change="onFileChange"
                                    />
                                  </label>

                                  <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove"
                                    aria-label="Remove avatar"
                                  >
                                    <i class="ki-outline ki-cross fs-2"></i>
                                  </span>
                                </div>
                                <div class="form-text">Allowed: PNG, JPG, JPEG</div>
                              </div>
                            </div>

                            <!-- الصف الأول -->

                            <h3 class="card-title align-items-start flex-column" style="border-bottom: 1px solid #ccc;margin-top: 30px;">
                              <span class="card-label fw-bold text-gray-800">Company Information</span>
                            </h3>


                            <div class="row mb-6" style="margin-top:10px;">
                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Company Name</label>
                                <input
                                  type="text"
                                  v-model="user.company_name"
                                  class="form-control form-control-solid"
                                  placeholder="Company Name"
                                  required
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Company CR Number</label>
                                <input
                                  type="text"
                                  v-model="user.company_cr"
                                  class="form-control form-control-solid"
                                  placeholder="Company CR NO."
                                  required
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Company Phone Number</label>
                                <input
                                  type="text"
                                  v-model="user.company_mobile"
                                  class="form-control form-control-solid"
                                  placeholder="Company Phone NO."
                                  required
                                />
                              </div>
                            </div>




                            <h3 class="card-title align-items-start flex-column" style="border-bottom: 1px solid #ccc;margin-top: 30px;">
                              <span class="card-label fw-bold text-gray-800">Company Address</span>
                            </h3>


                            <!-- الصف الثاني -->
                            <div class="row mb-6" style="margin-top:10px;">
                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Unit</label>
                                <input
                                  type="text"
                                  v-model="user.unit_address"
                                  class="form-control form-control-solid"
                                  placeholder="Unit Address"
                                  required
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Street</label>
                                <input
                                  type="text"
                                  v-model="user.street_address"
                                  class="form-control form-control-solid"
                                  placeholder="Street Address"
                                  required
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">City</label>
                                <input
                                  type="text"
                                  v-model="user.city_address"
                                  class="form-control form-control-solid"
                                  placeholder="City Address"
                                  required
                                />
                              </div>
                            </div>

                            <!-- الصف الثالث -->
                            <div class="row mb-6">
                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Zip Code</label>
                                <input
                                  type="text"
                                  v-model="user.zip_address"
                                  class="form-control form-control-solid"
                                  placeholder="Zip Code"
                                  required
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Country</label>
                                <input
                                  type="text"
                                  v-model="user.country_address"
                                  class="form-control form-control-solid"
                                  placeholder="Country"
                                  required
                                />
                              </div>

                            </div>







                            <h3 class="card-title align-items-start flex-column" style="border-bottom: 1px solid #ccc;margin-top: 30px;">
                              <span class="card-label fw-bold text-gray-800">Service Category</span>
                            </h3>
                            



                            <div class="row">
                              <div class="col-md-12">
                                <!-- <label class="required fw-semibold fs-6 mb-2">Services</label> -->
                                <textarea
                                  v-model="user.services"
                                  class="form-control form-control-solid"
                                  placeholder="write all your services categories in Details"
                                  maxlength="100"
                                  required
                                ></textarea>
                              </div>
                            </div>







                            <h3 class="card-title align-items-start flex-column" style="border-bottom: 1px solid #ccc;margin-top: 30px;">
                              <span class="card-label fw-bold text-gray-800">Account Manager (A Person Who Will Present The Company For All Projects)</span>
                            </h3>


                            <!-- الصف الرابع -->
                            <div class="row mb-6" style="margin-top:20px;">
                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Contact Person Name</label>
                                <input
                                  type="text"
                                  v-model="user.name"
                                  class="form-control form-control-solid"
                                  placeholder="Full Name"
                                  required
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Contact Person Email</label>
                                <input
                                  type="email"
                                  v-model="user.email"
                                  class="form-control form-control-solid"
                                  placeholder="example@domain.com"
                                  required
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Contact Person Mobile</label>
                                <input
                                  type="text"
                                  v-model="user.mobile"
                                  class="form-control form-control-solid"
                                  placeholder="EX:00966556625489"
                                  maxlength="12"
                                  required
                                />
                              </div>
                            </div>

                            <!-- الصف الخامس -->
                            <div class="row mb-6">
                              <div class="col-md-6">
                                <label class="required fw-semibold fs-6 mb-2">Authorized Signee Name</label>
                                <input
                                  type="text"
                                  v-model="user.signee_full_name"
                                  class="form-control form-control-solid"
                                  placeholder="Authorized Signee Full Name"
                                  required
                                />
                              </div>

                              <div class="col-md-6">
                                <label class="required fw-semibold fs-6 mb-2">Position</label>
                                <input
                                  type="text"
                                  v-model="user.position"
                                  class="form-control form-control-solid"
                                  placeholder="Position (Full Name)"
                                  required
                                />
                              </div>
                            </div>
                          </div>

                          <!-- Actions -->
                          <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button
                              type="submit"
                              class="btn btn-primary"
                              @click.prevent="EditInfo"
                              :disabled="isLoading"
                            >
                              <span class="indicator-label">Save</span>
                              <span class="indicator-progress"
                                >Wait Message
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                              </span>
                            </button>
                          </div>
                        </form>
 
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
            </div>

            <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                <div class="card mb-5 mb-xl-10">
                    <div
                        id="kt_account_settings_signin_method"
                        class="collapse show"
                    >
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Email Address-->

                            <!--end::Email Address-->
                            <!--begin::Separator-->
                            <!--end::Separator-->
                            <!--begin::Password-->
                            <div
                                class="d-flex flex-wrap align-items-center mb-10"
                            >
                                <!--begin::Label-->
                                <div id="kt_signin_password" class="d-none">
                                    <div class="fs-6 fw-bold mb-1">
                                        password 
                                    </div>
                                    <div class="fw-semibold text-gray-600">
                                        ************
                                    </div>
                                </div>
                                <!--end::Label-->
                                <!--begin::Edit-->
                                <div
                                    id="kt_signin_password_edit"
                                    class="flex-row-fluid"
                                >
                                    <!--begin::Form-->
                                    <form
                                        id="kt_signin_change_password"
                                        class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                        novalidate="novalidate"
                                    >
                                        <div class="row mb-1">
                                            
                                            <div class="col-lg-4">
                                                <div
                                                    class="fv-row mb-0 fv-plugins-icon-container"
                                                >
                                                    <label
                                                        for="newpassword"
                                                        class="form-label fs-6 fw-bold mb-3"
                                                        > Password </label
                                                    >
                                                    <input
                                                        type="password"
                                                        class="form-control form-control-lg form-control-solid"
                                                        name="newpassword"
                                                        id="newpassword"
                                                        v-model="formData.pass"
                                                    />
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                                                    ></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div
                                                    class="fv-row mb-0 fv-plugins-icon-container"
                                                >
                                                    <label
                                                        for="confirmpassword"
                                                        class="form-label fs-6 fw-bold mb-3"
                                                        >Confirm Password</label
                                                    >
                                                    <input
                                                        type="password"
                                                        class="form-control form-control-lg form-control-solid"
                                                        name="confirmpassword"
                                                        id="confirmpassword"
                                                        v-model="formData.cpass"
                                                    />
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                                                    ></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-text mb-5">
                                            Note
                                        </div>
                                        <div class="d-flex">
                                            <button
                                                type="submit"
                                                class="btn btn-primary"
                                                @click.prevent="
                                                    EditInfoPassword
                                                "
                                                :disabled="isLoading"
                                            >
                                                <span class="indicator-label"> Upate </span>
                                                <span class="indicator-progress"
                                                    >Wait Message
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"
                                                    ></span>
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Edit-->
                                <!--begin::Action-->
                                <div
                                    id="kt_signin_password_button"
                                    class="ms-auto d-none"
                                >
                                    <button
                                        class="btn btn-light btn-active-light-primary"
                                    >
                                        Reset Password
                                    </button>
                                </div>
                                <!--end::Action-->
                            </div>
                           
                            <!--end::Notice-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
            </div>

            <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                <div class="rounded border d-flex flex-column p-10">
                    <label for="" class="form-label">Note  </label>
                    <textarea
                        v-model="user.notes"
                        class="form-control"
                        data-kt-autosize="true"
                        style="min-height: 200px !important"
                    ></textarea>

                    
                </div>

             
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button
                        type="submit"
                        class="btn btn-primary"
                        @click.prevent="EditInfo"
                        :disabled="isLoading"
                    >
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress"
                            >Waite ...
                            <span
                                class="spinner-border spinner-border-sm align-middle ms-2"
                            ></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <!-- <Slider></Slider> -->
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
// import Slider from './Slider.vue';

export default {
    name: "Header",
    components: {
        // Slider,
    },

    data() {
        return { 
            urlEditInfo: "Users/editItem",
            urlEditPassword: "Users/editItemPassword",
            isLoading: false,
            logo: "",
            logo_preview: "./../assets/media/avatars/300-1.jpg",

            formData: {
                pass: "",
                cpass: "",
            },

            result: [],
            percentage: 0,
            sections: [],
        };
    },

    computed: {
        user() {
            return this.$store.getters.getUser || {};
        },

        locale() {
            return this.$route.params.locale;
        },

     
    },

    mounted() {
        this.$store.dispatch("fetchUser");
        this.activateFirstTab();
    },

    methods: {
        
      

        activateFirstTab() {
            const firstTab = document.querySelector("#tabpanel_1");
            if (firstTab) {
                firstTab.click();
            }
        },

        onFileChange(e) {
            this.logo = e.target.files[0];
            const file = e.target.files[0];
            if (file) {
                this.formData.logo = URL.createObjectURL(file);
            }
        },
        swalFunction(type, text) {
            Swal.fire({
                text: text,
                icon: type,
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary",
                },
            });
        },

        EditInfo() {
            this.isLoading = true;

            const config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            };

            let form = new FormData();

            // بيانات الشركة
            form.append("company_name", this.user.company_name);
            form.append("company_cr", this.user.company_cr);
            form.append("company_mobile", this.user.company_mobile);

            // العنوان
            form.append("unit_address", this.user.unit_address);
            form.append("street_address", this.user.street_address);
            form.append("city_address", this.user.city_address);
            form.append("zip_address", this.user.zip_address);
            form.append("country_address", this.user.country_address);

            // الخدمات
            form.append("services", this.user.services);

            // معلومات الشخص المسؤول
            form.append("name", this.user.name);
            form.append("email", this.user.email);
            form.append("mobile", this.user.mobile);

            // بيانات الشخص المفوض بالتوقيع
            form.append("signee_full_name", this.user.signee_full_name);
            form.append("position", this.user.position);
            

            form.append("Item_id", this.user.id);
            form.append("user_type", this.user.user_type);

            if (this.logo) {
                form.append("logo", this.logo);
            }

            axios
                .post(this.urlEditInfo, form, config)
                .then((response) => {
                    this.isLoading = false;

                    if (response.data.items) {
                        this.swalFunction("success", "Updated successfully!");
                        this.$store.dispatch("fetchUser");
                    } else {
                        this.swalFunction("error", "An error occurred while saving.");
                    }
                })
                .catch((error) => {
                    console.error(error);
                    this.isLoading = false;
                    this.swalFunction("error", "An error occurred while saving.");
                });
        },


        EditInfoPassword() {
            this.isLoading = true;

            let form = new FormData();
            form.append("password", this.formData.pass);
            form.append("confirm_password", this.formData.cpass);

            axios
                .post(this.urlEditPassword, form)
                .then((response) => {
                    this.isLoading = false;
                    if (response.data.code == 200) {
                        this.isLoading = false;
                        this.formData.pass = "";
                        this.formData.cpass = "";
                        this.swalFunction("success", "Doing successfully");
                        this.$store.dispatch("fetchUser");
                    } else {
                        this.isLoading = false;
                        this.swalFunction("error", response.data.message);
                    }
                })
                .catch((error) => {
                    this.isLoading = false;
                    this.swalFunction("error", "Error happens");
                });
        },
    },
};
</script>
<style type="text/css" scoped>
    #kt_toolbar{
        background: white;
    }
</style>