<template>
  <div class="card shadow-sm">
    <!-- Header -->
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
                            <div class="row mb-6">
                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Company Name</label>
                                <input
                                  type="text" disabled
                                  v-model="user.company_name"
                                  class="form-control form-control-solid"
                                  placeholder="Company Name"
                                  required
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Company CR Number</label>
                                <input
                                  type="text" disabled
                                  v-model="user.company_cr"
                                  class="form-control form-control-solid"
                                  placeholder="Company CR NO."
                                  required
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Company Phone Number</label>
                                <input
                                  type="text" disabled
                                  v-model="user.company_mobile"
                                  class="form-control form-control-solid"
                                  placeholder="Company Phone NO."
                                  required
                                />
                              </div>
                            </div>

                            <!-- الصف الثاني -->
                            <div class="row mb-6">
                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Unit Address</label>
                                <input
                                  type="text" disabled
                                  v-model="user.unit_address"
                                  class="form-control form-control-solid"
                                  placeholder="Unit Address"
                                  required
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Street Address</label>
                                <input
                                  type="text" disabled
                                  v-model="user.street_address"
                                  class="form-control form-control-solid"
                                  placeholder="Street Address"
                                  required
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">City Address</label>
                                <input
                                  type="text" disabled
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
                                  type="text" disabled
                                  v-model="user.zip_address"
                                  class="form-control form-control-solid"
                                  placeholder="Zip Code"
                                  required
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Country</label>
                                <input
                                  type="text" disabled
                                  v-model="user.country_address"
                                  class="form-control form-control-solid"
                                  placeholder="Country"
                                  required
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Services</label>
                                <input
                                  type="text" disabled
                                  v-model="user.services"
                                  class="form-control form-control-solid"
                                  placeholder="All Service Categories"
                                  maxlength="100"
                                  required
                                />
                              </div>
                            </div>

                            <!-- الصف الرابع -->
                            <div class="row mb-6">
                              <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Contact Person Name</label>
                                <input
                                  type="text" disabled
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
                                  type="text" disabled
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
                                  type="text" disabled
                                  v-model="user.signee_full_name"
                                  class="form-control form-control-solid"
                                  placeholder="Authorized Signee Full Name"
                                  required
                                />
                              </div>

                              <div class="col-md-6">
                                <label class="required fw-semibold fs-6 mb-2">Position</label>
                                <input
                                  type="text" disabled
                                  v-model="user.position"
                                  class="form-control form-control-solid"
                                  placeholder="Position (Full Name)"
                                  required
                                />
                              </div>
                            </div>
                          </div>

                          <!-- Actions -->
                        
                        </form>

    <!-- Footer -->
    <div class="card-footer bg-light d-flex justify-content-end">
      <button class="btn btn-light me-3" @click="goBack">Back</button>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  name: 'UserProfile',

  computed: {
    user() {
            return this.$store.getters.getUser || {};
        },

  },

  mounted() {
        this.$store.dispatch("fetchUser");
    },

  methods: {
    goBack() {
      this.$router.go(-1)
    },
    
  },
}
</script>

<style scoped>
.card {
  border-radius: 1rem;
}
.border-bottom {
  border-bottom: 1px solid #e5e5e5 !important;
}
</style>
