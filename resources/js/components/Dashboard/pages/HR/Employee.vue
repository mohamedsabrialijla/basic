<template>
           
  <!--begin::Post-->
  <div class="content flex-column-fluid" id="kt_content">
    <!--begin::Card-->
    <div class="card">
      <!--begin::Card header-->
      <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
          <!--begin::Search-->
          <div class="d-flex align-items-center position-relative my-1">
            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
              <span class="path1"></span>
              <span class="path2"></span>
            </i>
            <input v-model="searchQuery" @input="searchItems" type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search ..." />
          </div>
          <!--end::Search-->
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
          <!--begin::Toolbar-->
          <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base" v-if="selectedItems.length === 0">
            <!-- <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <i class="ki-duotone ki-filter fs-2">
              <span class="path1"></span>
              <span class="path2"></span>
            </i>Filter</button> -->
            <!-- <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
              <div class="px-7 py-5">
                <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
              </div>
             
              <div class="separator border-gray-200"></div>
              
              <div class="px-7 py-5" data-kt-user-table-filter="form">
                <div class="mb-10">
                  <label class="form-label fs-6 fw-semibold">Role:</label>
                  <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true">
                    <option></option>
                    <option value="Administrator">Administrator</option>
                    <option value="Analyst">Analyst</option>
                    <option value="Developer">Developer</option>
                    <option value="Support">Support</option>
                    <option value="Trial">Trial</option>
                  </select>
                </div>
                
                <div class="mb-10">
                  <label class="form-label fs-6 fw-semibold">Two Step Verification:</label>
                  <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="two-step" data-hide-search="true">
                    <option></option>
                    <option value="Enabled">Enabled</option>
                  </select>
                </div>
                
                <div class="d-flex justify-content-end">
                  <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
                  <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Apply</button>
                </div>
              </div>
            </div> -->
            <!--end::Menu 1-->
            <!--end::Filter-->
            <!--begin::Export-->
            <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_users">
            <i class="ki-duotone ki-exit-up fs-2">
              <span class="path1"></span>
              <span class="path2"></span>
            </i>Export</button>
            <!--end::Export-->
            <!--begin::Add user-->
            <button @click="getModalCreate()" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_item">
            <i class="ki-duotone ki-plus fs-2"></i>Add New</button>
            <!--end::Add user-->
          </div>
          <!--end::Toolbar-->
          <!--begin::Group actions-->
          <div class="d-flex justify-content-end align-items-center " v-if="selectedItems.length != 0" >
            <div class="fw-bold me-5">
            <span class="me-2" >{{ selectedItems.length }}</span>Selected</div>
            <button type="button" class="btn btn-danger"  @click="deleteSelected">Delete Selected</button>
          </div>
          <!--end::Group actions-->
          
         
        </div>
        <!--end::Card toolbar-->
      </div>
      <!--end::Card header-->
      <!--begin::Card body-->
      <div class="card-body py-4">
        <!--begin::Table-->
        <div v-if="isLoading">
          please wait ...
        </div>
        <table v-else class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
          <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
              <th class="w-10px pe-2">
                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                  <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" v-model="selectAll" @change="toggleAll" />
                </div>
              </th>
              <th class="min-w-125px">Logo</th>
              <th class="min-w-125px">Employee</th>
              <th class="min-w-125px">Position</th>
              <th class="min-w-125px">Status</th>
              <th class="min-w-125px">Joined Date</th>
              <th class="text-center min-w-100px">Actions</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 fw-semibold">
            <tr v-if="items.length > 0 " v-for="(item, index) in items" :key="item.id">
              <td >
                <div class="form-check form-check-sm form-check-custom form-check-solid">
                  <input v-model="selectedItems" :value="item.id" class="form-check-input" type="checkbox"  />
                </div>
              </td>

              <td>
                 <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                  <a href="#">
                    <div class="symbol-label">
                      <img :src="item.logo" :alt="item.name" class="w-100" />
                    </div>
                  </a>
                </div> 
              </td>
              <td class="d-flex align-items-center">
                <div class="d-flex flex-column">
                  <a href="#" class="text-gray-800 text-hover-primary mb-1" style="margin-top:27px;">{{item.full_name}}</a>
                  <span>{{item.code}}</span>
                </div>
                <!--begin::User details-->
              </td>
              <td>{{item.position.name}}</td>
              <td>
                <div v-if="item.status=='active'" class="badge badge-light-success fw-bold">{{item.status}}</div>
                <div v-else class="badge badge-light-danger fw-bold">{{item.status}}</div>
              </td>
              <td>{{item.created_at}}</td>
             

              <td class="text-end">
                 <div class="d-flex flex-center rounded p-4 h-80px mb-1 overlay">
                      <div class="overlay-wrapper text-gray-600">
                          <i @click="getModalEdit(item)" class="ki-duotone ki-notepad-edit fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>


                        <div class="overlay-wrapper text-gray-600">
                          <i @click="deleteItem(item.id)" class="ki-duotone ki-trash-square fs-2x">
                           <span class="path1"></span>
                           <span class="path2"></span>
                           <span class="path3"></span>
                           <span class="path4"></span>
                          </i>
                        </div>
                            
                  </div>
              </td>
            </tr>

            <tr v-else class="d-flex align-items-center">
                  Empty 

            </tr>
       
          </tbody>
        </table>

        <!-- <pagination begin  -->
        <pagination :totalItems="totalItems" :currentPage="currentPage" @page-changed="fetchItems"></pagination>
        <!-- <pagination end  -->

        <!--end::Table-->
      </div>
      <!--end::Card body-->
    </div>
    <!--end::Card-->
  </div>
  <!--end::Post-->









<!--begin::Modal - Add task-->
  <div class="modal fade" id="kt_modal_add_item" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
      <!--begin::Modal content-->
      <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header" id="kt_modal_add_user_header">
          <!--begin::Modal title-->
          <h2 class="fw-bold">Add User</h2>
          <!--end::Modal title-->
          <!--begin::Close-->
          <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" @click="closeModal">
            <i class="ki-duotone ki-cross fs-1">
              <span class="path1"></span>
              <span class="path2"></span>
            </i>
          </div>
          <!--end::Close-->
        </div>


        <div class="modal-body px-5 my-7">
          <form id="kt_modal_add_user_form" class="form" action="#">
            <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">



              <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="d-block fw-semibold fs-6 mb-5">Image</label>
              
                <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                  <!--begin::Preview existing avatar-->

                  <div class="image-input-wrapper w-125px h-125px" :style="{'background-image': formData.logo ? `url(${formData.logo})` : 'url(/assets/avatar.svg)'}"></div>


                
                  <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                    <i class="ki-duotone ki-pencil fs-7">
                      <span class="path1"></span>
                      <span class="path2"></span>
                    </i>
                    <input type="file" name="avatar" @change="onFileChange" accept=".png, .jpg, .jpeg" />
                    <input type="hidden" name="avatar_remove" />
                  </label>
                  <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                    <i class="ki-duotone ki-cross fs-2">
                      <span class="path1"></span>
                      <span class="path2"></span>
                    </i>
                  </span>
                  <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                    <i class="ki-duotone ki-cross fs-2">
                      <span class="path1"></span>
                      <span class="path2"></span>
                    </i>
                  </span>
                </div>
                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
              </div>



              <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Code</label>
                <input type="text" name="code"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Employee Code" value="" v-model="formData.code" required />
              </div>
             
              <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">First Name</label>
                <input type="text" name="first_name"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="First name" value="" v-model="formData.first_name" required />
              </div>

              <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Middle Name</label>
                <input type="text" name="first_name"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Middle name" value="" v-model="formData.middle_name" required />
              </div>


              <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Last Name</label>
                <input type="text" name="first_name"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Last name" value="" v-model="formData.last_name" required />
              </div>
             
             

              <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Mobile</label>
                <input type="text" name="mobile" v-model="formData.mobile" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="EX:00966556625489" maxlength="12" value="" required />
              </div>


              <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Idintification Number</label>
                <input type="text" name="id_number" v-model="formData.id_number" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Idintification Number" maxlength="12" value="" required />
              </div>

          




               <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Position</label>
                <multiselect class="" v-model="formData.position" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsPosition" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" ></multiselect>

              </div>


            </div>
            <div class="text-center pt-10">
              <button type="submit" class="btn btn-primary" @click.prevent="addEditItem" :disabled="isLoading">
              <span  class="indicator-label">Submit</span>
              <span  class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
              </span>
            </button>


            <button style="margin: 7px;" type="submit" class="btn btn-secondary" @click.prevent="closeModal">
              <span  class="indicator-label">Canacel</span>
              
            </button>

            </div>
          </form>
        </div>


      </div>
    </div>
  </div>
<!--begin::Modal - Add task-->


             
</template>

<script>
import axios from 'axios';
import Pagination from '../../layout/pagination.vue';
import Multiselect from 'vue-multiselect'

export default {
  components: {
    Pagination,Multiselect
  },
    data() {
        return {
            totalItems: 0, // إجمالي العناصر (يمكن تحديثه بناءً على الاستجابة)
            currentPage: 1,
            selectedItems: [], // Selected items for deletion
            selectAll: false, // To track if all items are selected
            searchQuery: '', // الكلمة المفتاحية للبحث
            isLoading: false, // حالة التحميل
            items: [], 
            itemsPosition: [], 
            searchQuery: '',
            formData: {
                code: '',
                first_name: '',
                middle_name: '',
                last_name: '',
                position_id: '',
                id_number: '',
                logo: '',
                logo_preview  :'./../assets/media/avatars/300-1.jpg',
            },

           

            ItemID: null, // المستخدم الذي يتم تعديله
            URL:'Employees/createItem',
        };
    },

    mounted() {
      this.fetchItems(this.currentPage); // استدعاء جلب المستخدمين عند تحميل الصفحة

    },


    // created() {
    //       this.fetchItems(); // تحميل العناصر بدون فلترة في البداية

    // },
    methods: {

       onFileChange(e) {
        this.logo = e.target.files[0];
            const file = e.target.files[0];
            if (file) {
                this.formData.logo = URL.createObjectURL(file);
            }
        },




        getModalCreate(){
            this.fetchItemsPosition();
            this.resetItem();
            $('#kt_modal_add_item').modal('show');
            this.titleModal = 'اضافة جديد '
        },


        getModalEdit(item){
            this.ItemID = item.id
            this.fetchItemsPosition();
            this.resetItem();
            $('#kt_modal_add_item').modal('show');
            this.titleModal = 'تعديل البيانات'
            this.URL = 'Employees/editItem'
            this.getItemById() 
        },


      

        closeModal(){
            $('#kt_modal_add_item').modal('hide');
            this.URL = 'Employees/createItem'
            this.ItemID = null
            // this.resetMark();
        },


        closeModalPassword(){
            $('#kt_modal_add_item_password').modal('hide');
            this.ItemID = null
        },

        resetItem(){
          this.URL = 'Employees/createItem'
          this.formData.code=''
          this.formData.mobile=''
          this.formData.email=''
          this.formData.name=''
          this.formData.position_id=''
          this.formData.logo=''
          this.logo_preview ='./../assets/companies/img/store-logo.jpg'

        },



         resetItemPassword(){
          this.formData.password=''
          this.formData.confirm_password=''
          

        },



        swalFunction(type , text){
          Swal.fire({
                text: text,
                icon: type,
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        },


        searchItems() {
          this.fetchItems(this.searchQuery); // استدعاء الدالة مع الكلمة المفتاحية
        },


        // جلب جميع المستخدمين
        async fetchItems(page,query = '') {
          this.currentPage = page;
          this.isLoading = true;
            await axios.get('Employees/getAllItems', {
                params: {
                  search: this.searchQuery,  // تمرير قيمة البحث
                  pagination: 1,
                  page:page,
                }
              })
                .then(response => {
                    this.items = response.data.items.data;
                    this.isLoading = false;
                    this.totalItems = response.data.items.total
                })
                .catch(error => {
                   Swal.fire({
                text: error,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });

                   this.isLoading = false;
                }); 
        },


        async fetchItemsPosition() {
            axios.get('/Positions/getAllItems?pagination=0')
                .then(response => {
                    this.itemsPosition = response.data.items;
                })
                .catch(error => {
                    this.swalFunction('error','Error Happens')
                });
        },

       


        // إضافة مستخدم جديد
        addEditItem() {

          
          this.isLoading = true;

          const config = {
                  headers: {
                      'content-type': 'multipart/form-data'
                  }
              }
 
            let form = new FormData();
              form.append('code', this.formData.code);
              form.append('first_name', this.formData.first_name);
              form.append('middle_name', this.formData.middle_name);
              form.append('last_name', this.formData.last_name);
              form.append('mobile', this.formData.mobile);
              form.append('id_number', this.formData.id_number);
              form.append('position_id', this.formData.position.id);

              if (this.logo) {
                form.append('logo', this.logo);
              }
           
            if(this.ItemID != ''){
               form.append('Item_id', this.ItemID);
            }

             
          axios.post(this.URL,form,config).then((response)=>{
                 this.isLoading = false;
                if(response.data.items){
                   swal.fire({
                    text: "تم حفظ التغييرات بنجاح",
                    icon: "success",
                    timer: 2000,
                    button: false
                    }); 
                    this.closeModal()
                    this.fetchItems()           

                }else{
                  this.isLoading = false;
                    swal.fire({
                    text: response.data.message,
                    icon: 'error',
                    timer: false,
                    button: true
                    });

                }             
            
          }).catch(error => {
            this.isLoading = false;
                    swal.fire({
                    text: error,
                    icon: 'error',
                    timer: false,
                    button: true
                    });
                });

          
        },


        
        async getItemById(){

            axios.get('Employees/getById', { params: { ID: this.ItemID } }).then(response => {
                if(response.data){
                  let data = response.data.items
                   this.formData = data;

                }else{
                    Swal.fire({
                        text: "Error happens",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            }).catch((error)=>{

                    swal({
                    text: 'Error happens',
                    icon: 'error',
                    timer: false,
                    button: true
                    });         
            });
        },


      


      deleteItem(id) {
        swal.fire({
          text: "Are you sure you want to delete this item?",
          icon: "warning",
          buttonsStyling: false,
          showDenyButton: true,
          confirmButtonText: "Yes",
          denyButtonText: 'No',
          customClass: {
            confirmButton: "btn btn-primary",
            denyButton: "btn btn-light-danger"
          }
        }).then((result) => {
          if (result.isConfirmed) {
            // إذا تم تأكيد الحذف
            axios.delete(`Employees/deleteItem/${id}`)
              .then(() => {
                this.fetchItems()
                
                swal.fire({
                  text: 'The item has been deleted successfully.', 
                  icon: 'success',
                  confirmButtonText: "Ok",
                  buttonsStyling: false,
                  customClass: {
                    confirmButton: "btn btn-light-primary"
                  }
                });
              })
              .catch(error => {
                console.error(error);
                // عرض رسالة خطأ في حال فشل الطلب
                swal.fire({
                  text: 'Error deleting the item. Please try again.', 
                  icon: 'error',
                  confirmButtonText: "Ok",
                  buttonsStyling: false,
                  customClass: {
                    confirmButton: "btn btn-light-primary"
                  }
                });
              });
          } else if (result.isDenied) {
            // إذا تم رفض الحذف
            swal.fire({
              text: 'The deletion has been canceled.', 
              icon: 'info',
              confirmButtonText: "Ok",
              buttonsStyling: false,
              customClass: {
                confirmButton: "btn btn-light-primary"
              }
            });
          }
        });
      },

     toggleAll() {
        if (this.selectAll) {
          this.selectedItems = this.items.map(item => item.id);
        } else {
          this.selectedItems = [];
        }

      },
    
      deleteSelected() {
        this.selectedItems.forEach(item => {
          this.deleteItem(item);
        });
        this.selectedItems = [];
        this.selectAll = false;
      },


     

        

        
     
    },

  //    watch: {
  //     selectedItems() {
  //       this.selectAll = this.selectedItems.length === this.items.length;
  //     }
  // }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>

.multiselect__option--highlight {
    background: #3ebdb1 !important;
    outline: none;
    color: #fff;}

    .multiselect__tag {
    background: #3ebdb1;}

    .multiselect__tag-icon:after {
    color: ##33a196;
    }




    ol, p, ul {
        line-height: 1.0;
    }


  .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }



</style>