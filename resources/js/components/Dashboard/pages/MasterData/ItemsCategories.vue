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
            <input v-model="searchQuery" @input="searchItems" type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search Item ..." />
          </div>
          <!--end::Search-->
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
          <!--begin::Toolbar-->
          <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base" v-if="selectedItems.length === 0">
          
            <!--end::Menu 1-->
            <!--end::Filter-->
            <!--begin::Export-->
            <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_items">
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
              <th class="min-w-125px">Name</th>
              <th class="min-w-125px">Status</th>
              <th class="min-w-125px">Joined Date</th>
              <th class="text-center min-w-100px">Actions</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 fw-semibold">
            <tr v-for="(item, index) in items" :key="item.id">
              <td >
                <div class="form-check form-check-sm form-check-custom form-check-solid">
                  <input v-model="selectedItems" :value="item.id" class="form-check-input" type="checkbox"  />
                </div>
              </td>


              <td class="align-items-center" style="margin-top: 15px;">
                <!--begin:: Avatar -->
               
                <!--end::Avatar-->
                <!--begin::User details-->
                <div class="d-flex flex-column">
                  <a href="#" class="text-gray-800 text-hover-primary mb-1">{{item.name}}</a>
                  <!-- <span>{{item.code}} </span> -->
                </div>
                <!--begin::User details-->
              </td>
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

<div class="modal bg-body fade" tabindex="-1" id="kt_modal_add_item">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content shadow-none">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>



        <div class="modal-body">
          <form id="kt_modal_add_user_form" class="form" action="#">
            <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">


             
              <div class="fv-row mb-7" v-for="lang in languages" :key="lang.locale">
                <label class="required fw-semibold fs-6 mb-2" :for="'name_' + lang.locale"> Name</label>
                <input type="text" :name="'name_' + lang.locale" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Name" value="" v-model="formData['name_' + lang.lang]"   required />
              </div>
 
 

              <div class="fv-row mb-7" v-if="routeSegment == 'documents'">
                <label class="required fw-semibold fs-6 mb-2">Users Approval</label>
                <span>Please fill Users as order to approval</span>
                <multiselect class="" v-model="formData.users" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsers" :multiple="true" :taggable="false" :options-limit="20" :allow-empty="false" ></multiselect>

              </div>



              <div class="fv-row mb-7" >
                <label class="required fw-semibold fs-6 mb-2" > Order</label>
                <input type="number" :name="order" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Order " value="" v-model="formData.order"   required />
              </div>





            <div class="card p-5" v-if="routeSegment == 'te-criteria'">
                <h4 class="mb-4">Add Items</h4>

                <!-- تكرار الصفوف -->
                <div class="row align-items-end mb-4" v-for="(entry, index) in formEntries" :key="index">
                  <!-- employee -->
                  

                  <div class="col-md-5 mb-3">
                    

                        <input
                          type="text"
                          class="form-control form-control-solid"
                          placeholder="Title here..."
                          v-model="entry.title"
                          required
                        />
                  </div>


                  <div class="col-md-2 mb-3">

                    <multiselect
                      v-model="entry.features"
                      tag-placeholder="Write here"
                      placeholder="Search..."
                      label="name"
                      track-by="id"
                      :multiple="true"
                      :taggable="true"
                      :options-limit="20"
                      :allow-empty="true"
                      :options="features"
                      @tag="(newTag) => addTag(newTag, entry)"

                    />

                  </div>



                  <div class="col-md-1 mb-3">

                    <multiselect
                      v-model="entry.features_value"
                      tag-placeholder="Write here"
                      placeholder="Search..."
                      label="number"
                      track-by="id"
                      :multiple="true"
                      :taggable="true"
                      :options-limit="20"
                      :allow-empty="true"
                      :options="features_value"
                      @tag="(newTag) => addTagValue(newTag, entry)"
                    />

                  </div>

                  <div class="col-md-1 mb-3">
                    <select class="form-control" v-model="entry.critiera">
                      <option value="Critical">Critical</option>
                      <option value="non-Critical">Non Critical</option>
                    </select>
                  </div>


                
                  

                  <!-- Remove button -->
                 <div class="col-md-2 mb-3 d-flex">

                    <!-- زر الحذف -->
                    <button class="btn btn-light-danger d-flex align-items-center gap-2 me-2" @click="removeEntry(index)" style="width: 55px;">
                      <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <path opacity="0.3" d="M5 8H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V8Z" fill="currentColor"/>
                          <path d="M14 4H10V2H14V4ZM4 6H20V8H4V6Z" fill="currentColor"/>
                        </svg>
                      </span>
                    </button>

                    <!-- زر الإضافة -->
                    <a class="btn btn-light-primary d-flex align-items-center gap-2" v-if="index === formEntries.length - 1" @click="addNewEntry" style="width: 55px;">
                      <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <rect opacity="0.5" x="11" y="5" width="2" height="14" rx="1" fill="currentColor"/>
                          <rect x="5" y="11" width="14" height="2" rx="1" fill="currentColor"/>
                        </svg>
                      </span>
                    </a>

                 </div>
                  
                </div>

            </div>



     


            </div>
           
          </form>
        </div>

        <div class="modal-footer">
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

      </div>
           


    </div>
  </div>
<!--begin::Modal - Add task-->







             
</template>

<script>


import axios from 'axios';
import Pagination from '../../layout/pagination.vue';
import { mapState } from 'vuex';
import Multiselect from 'vue-multiselect'


 
export default {
   props: ['category'],
  components: {
    Pagination,Multiselect
  },
    data() {
        return {
            languages:{},
            totalItems: 0, // إجمالي العناصر (يمكن تحديثه بناءً على الاستجابة)
            currentPage: 1,
            selectedItems: [], // Selected items for deletion
            selectAll: false, // To track if all items are selected
            searchQuery: '', // الكلمة المفتاحية للبحث
            isLoading: false, // حالة التحميل
            items: [], 
            searchQuery: '',
            formData: {
                type_id:'',
                code: '',
            },

            itemsUsers:[],

            formEntries: [
              { title: '', features: [], features_value: [] , critiera : null},
            ],

           
            features: [
               
              ],

            features_value: [
                
              ],

            
            ItemID: null,
            URL:'ItemsCategories/createItem',
            routeSegment: this.category,
        };
    },


    mounted() {
       
        this.fetchItems(this.currentPage);
        
        
    },


   
    methods: {


       addTag(newTag, entry) {
        const newOption = { id: Date.now(), name: newTag };
        this.features.push(newOption);

        if (!Array.isArray(entry.features)) {
          entry.features = [];
        }

        entry.features.push(newOption);
      },


      addTagValue(newTag, entry) {
        const newOption = { id: Date.now(), number: newTag };
        this.features_value.push(newOption);

        if (!Array.isArray(entry.features_value)) {
          entry.features_value = [];
        }

        entry.features_value.push(newOption);
      },


      



       addNewEntry() {
      this.formEntries.push({  title: '', features: [], features_value: [] , critiera: null });
      },
      removeEntry(index) {
        this.formEntries.splice(index, 1);
      },


    
        getModalCreate(){
          this.URL = 'ItemsCategories/createItem'
          this.resetItem();
          $('#kt_modal_add_item').modal('show');
          this.titleModal = 'Add New'
          this.fetchItemsUsers();
          this.formEntries =  [
              { title: '', features: [], features_value: [] , critiera : null },
            ];


        },
 
 
        getModalEdit(item){
            this.ItemID = item.id
            this.resetItem();
            $('#kt_modal_add_item').modal('show');
            this.titleModal = 'Edit Item'
            this.getItemById() 
            this.URL = 'ItemsCategories/editItem'
            this.fetchItemsUsers();
        },


      

        closeModal(){
            $('#kt_modal_add_item').modal('hide');
            this.URL = 'ItemsCategories/createItem'
            this.ItemID = null
            this.fetchItemsUsers();
            // this.resetMark();
        },


      

        resetItem(){
          this.formData =  {
                code: '',
                order: '',
            }
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


        async fetchItems(page,query = '') {
          this.currentPage = page;
          this.isLoading = true;
            await axios.get('ItemsCategories/getAllItems', {
                params: {
                  search: this.searchQuery,  // تمرير قيمة البحث
                  pagination: 1,
                  page:page,
                  type: this.routeSegment,
                }
              })
                .then(response => {
                    this.items = response.data.items.data;
                    this.isLoading = false;
                    this.totalItems = response.data.items.total
                    this.languages = this.$store.state.languages ;
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

        async fetchItemsUsers() {
            const typeList = ['category'];
            axios.get('Users/getAllItems', {
                params: {
                    pagination: 0,
                }
            })
            .then(response => {
                this.itemsUsers = response.data.items;
            })
            .catch(error => {
                console.log(error);
            });
        },


    
        

      addEditItem() {

          
          this.isLoading = true;

           
            if(this.ItemID != ''){
               this.formData.Item_id = this.ItemID;
            }

            this.formData.type = this.routeSegment

            if(this.routeSegment=='documents'){
              const userIds = this.formData.users.map(user => user.id);
              this.formData.users = userIds
            }


            if(this.formEntries){
              this.formData.forms = this.formEntries
            }

            

             
          axios.post(this.URL,this.formData).then((response)=>{
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

            axios.get('ItemsCategories/getById', { params: { ID: this.ItemID } }).then(response => {
                if(response.data){
                  let data = response.data.items
                  let translations = response.data.items.translations
                  this.formData.users = data.users
                  this.resetItem()

                  this.formData = data;
                   translations.forEach((element) => { 
                              this.formData['name_'+element.locale] = element.name; 
                              this.formData['description_'+element.locale] = element.description; 
                        });

                   this.formEntries = data.features.map((feature, index) => {
                      return {
                        title: feature.title,
                        critiera: feature.critiera,
                        features: feature.features_value.map(fv => ({
                          id: fv.id,
                          name: fv.name
                        })),
                        features_value: feature.features_value.map(fv => ({
                          id: fv.id,
                          number: fv.value
                        })),

                        

                      };
                    });

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
              axios.delete(`ItemsCategories/deleteItem/${id}`)
                .then(() => {
                  // this.items = this.items.filter(i => i.id !== item.id);
                  // this.ItemID = ''
                  this.swalFunction('success','The item has been deleted successfully.')
                  this.fetchItems()
                })
                .catch(error => {
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
          this.selectedItems.forEach(id => {
            this.deleteItem(id);
          });
          this.selectedItems = [];
          this.selectAll = false;
        },
      
     
  },


   watch: {
    // راقب تغيير المسار للتحديث عند الانتقال بين الصفحات
    '$route.params.category': {
      immediate: true, // تشغيل التحديث عند تحميل الصفحة
      handler(newVal) {
        // تحديث الـ breadcrumb بناءً على قيمة :object الجديدة
        this.$route.meta.breadcrumb = `${newVal.charAt(0).toUpperCase() + newVal.slice(1)} Category Management`;
      }
    }
  },

 
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



  .mb-3 {
    margin-bottom: 2.75rem !important;
  }
</style>

