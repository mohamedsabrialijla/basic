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
            <button type="button" class="btn btn-light-info me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_items">
            <i class="ki-duotone ki-exit-up fs-2">
              <span class="path1"></span>
              <span class="path2"></span>
            </i>Export</button>
            <!--end::Export-->
            <!--begin::Add user-->
            <button @click="openRFPSteper()" type="button" class="btn btn-info" >
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
              <th class="min-w-125px">ID Number</th>
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
                <div class="d-flex flex-column">
                  <a href="#" class="text-gray-800 text-hover-info mb-1">{{item.ID_rfp}}</a>
                </div>
              </td>


              <td class="align-items-center" style="margin-top: 15px;">
                <!--begin:: Avatar -->
               
                <!--end::Avatar-->
                <!--begin::User details-->
                <div class="d-flex flex-column">
                  <a href="#" class="text-gray-800 text-hover-info mb-1">{{item.name}}</a>
                  <!-- <span>{{item.code}} </span> -->
                </div>
                <!--begin::User details-->
              </td>
               
              <td>
                  <div v-if="item.draft== 0 " class="badge badge-light-danger fw-bold">Saved</div>
                  <div v-if="item.draft== 1 " class="badge badge-light-info fw-bold">Draft</div>
                  <div v-else-if="item.draft== 2" class="badge badge-light-success fw-bold">Sent To Review Team</div>
              </td>

              <td>{{item.created_at}}</td>
             

              <td class="text-end">
                 <div class="d-flex flex-center rounded p-4 h-80px mb-1 overlay">
                      <div class="overlay-wrapper text-gray-600">
                          <i @click="openRFPSteperForEdit(item)" class="ki-duotone ki-notepad-edit fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>



                        <div class="overlay-wrapper text-gray-600">

                          <i @click="openTpsBuyer(item)" class="ki-duotone ki-exit-right fs-2"><span class="path1"></span><span class="path2"></span></i>
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














             
</template>

<script>


import axios from 'axios';
import Pagination from '../../layout/pagination.vue';
import { mapState } from 'vuex';
import Multiselect from 'vue-multiselect'


 
export default {
  props: ['object'],
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
            itemsCategories: [], 
            searchQuery: '',
            formData: {
                type:'',
                code: '',
                title: '',
                name: '',
                description: '',
            },
            // quill: null,

            logo:'',

            
            ItemID: null,
            URL:'RFPStep/createItem',

            routeSegment: this.object,
        };
    },


    mounted() {
       
        this.fetchItems(this.currentPage);


      //   this.quill = new Quill('#kt_docs_quill_basic', {
      //     modules: {
      //         toolbar: [
      //             [{ header: [1, 2, false] }],
      //             ['bold', 'italic', 'underline'],
      //             [{ color: [] }, { background: [] }], // ✅ أدوات الألوان
      //             ['image', 'code-block']
      //         ]
      //     },
      //     placeholder: 'Type your text here...',
      //     theme: 'snow'
      // });

        
    },

      computed: {
          locale() {
              return this.$route.params.locale;
          }
      },
   
    methods: {
 
      
    



        openRFPSteper(){

          localStorage.setItem('RFPItem', ''); 

          this.$router.push({ path: `/${this.locale}/dashboard/master_data/projects/rfp-step` });
        },

 



        openRFPSteperForEdit(RFPItem){
          localStorage.setItem('RFPItem', JSON.stringify(RFPItem)); 
          localStorage.setItem('RFPBuyer', JSON.stringify(RFPItem)); 
          localStorage.setItem('RFPReview', JSON.stringify(RFPItem)); 
          localStorage.setItem('object_rfp', JSON.stringify(RFPItem)); 

          this.$router.push({ path: `/${this.locale}/dashboard/master_data/projects/rfp-step` });
        },
 

        openTpsBuyer(RFPItem){
          localStorage.setItem('RFPItem', JSON.stringify(RFPItem)); 
          localStorage.setItem('RFPBuyer', JSON.stringify(RFPItem)); 
          localStorage.setItem('RFPReview', JSON.stringify(RFPItem));
          localStorage.setItem('object_rfp', JSON.stringify(RFPItem));
          this.$router.push({ path: `/${this.locale}/dashboard/buyer/tps` });
        },


        



       


      
        

        swalFunction(type , text){
          Swal.fire({
                text: text,
                icon: type,
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-info"
                }
            });
        },


        searchItems() {
          this.fetchItems(this.searchQuery); // استدعاء الدالة مع الكلمة المفتاحية
        },


        async fetchItems(page,query = '') {
          this.currentPage = page;
          this.isLoading = true;
            await axios.get('RFPStep/getAllItems', {
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
                    this.languages = this.$store.state.languages ;
                })
                .catch(error => {
                   Swal.fire({
                text: error,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-info"
                }
            });

                   this.isLoading = false;
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
              confirmButton: "btn btn-info",
              denyButton: "btn btn-light-danger"
            }
          }).then((result) => {
            if (result.isConfirmed) {
              // إذا تم تأكيد الحذف
              axios.delete(`RFPStep/deleteItem/${id}`)
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
                      confirmButton: "btn btn-light-info"
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
                  confirmButton: "btn btn-light-info"
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

