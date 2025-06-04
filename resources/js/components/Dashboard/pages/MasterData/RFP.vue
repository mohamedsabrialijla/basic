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
              <th class="min-w-125px">section</th>
              <th class="min-w-125px">type</th>
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
                  <a href="#" class="text-gray-800 text-hover-primary mb-1">{{item.title}}</a>
                </div>
              </td>

              <td>
                 <div class="d-flex flex-column">
                  <a href="#" class="text-gray-800 text-hover-primary mb-1 text-uppercase">{{item.type}}</a>
                </div>
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
                <h5 class="modal-title">Add Edit Informations</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>


        <div class="modal-body px-5 my-7">
          <form id="kt_modal_add_user_form" class="form" action="#">
            <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">



              
            <div style="display: flex; gap: 10px;">
             


              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2" for="name"> Type</label>
                <select class="form-control" v-model="formData.type">
                  <option value="text">Text</option>
                  <option value="sheet">Sheet</option>
                </select>
              </div>

                <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2" for="name"> Title</label>
                <input type="text" :name="'name'" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Name" value="" v-model="formData.title"   required />
              </div>


               <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2" for="name"> Order</label>
                <input type="text" :name="'name'" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Order" value="" v-model="formData.order"   required />
              </div>

            </div>


            <div class="row">
              
            


              <div class="fv-row col-md-12">
                <label class="required fw-semibold fs-6 mb-2" for="name"> Description</label>
                 <div id="kt_docs_quill_basic" name="kt_docs_quill_basic">
                
            </div>
              </div>

            </div>


           




            </div>
           


            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="addEditItem()">Save changes</button>
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
import { mapState } from 'vuex';
import Multiselect from 'vue-multiselect'
import Quill from 'quill';
import QuillBetterTable from 'quill-better-table';
import 'quill/dist/quill.snow.css';
import 'quill-better-table/dist/quill-better-table.css';

 Quill.register({
  'modules/better-table': QuillBetterTable
}, true);

 
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
            quill: null,

            logo:'',

            
            ItemID: null,
            URL:'Project/createItem',

            routeSegment: this.object,
        };
    },


    mounted() {
       
        this.fetchItems(this.currentPage);


        this.quill = new Quill('#kt_docs_quill_basic', {
  theme: 'snow',
  modules: {
    toolbar: [
      [{ header: [1, 2, false] }],
      ['bold', 'italic', 'underline'],
      [{ color: [] }, { background: [] }],
      ['image', 'code-block'],
      ['table'] // مخصص، تحتاج لإضافة زر مخصص لهذا
    ],
    'better-table': {
      operationMenu: {
        items: {
          unmergeCells: {
            text: 'Unmerge Cells',
          }
        },
        color: {
          colors: ['red', 'green', 'yellow', 'blue', 'white'],
          text: 'Background Colors:'
        }
      }
    }
  }
});

        
    },

      computed: {
          locale() {
              return this.$route.params.locale;
          }
      },
   
    methods: {
 
      
        openSteps(ID){

            localStorage.setItem('ProjectID',ID);
            this.$router.push({ path: `/${this.locale}/dashboard/master_data/projects/steps` });


        },



        openSteps(ID){

            localStorage.setItem('ProjectID',ID);
            this.$router.push({ path: `/${this.locale}/dashboard/master_data/projects/rfp` });


        },



        getModalCreate(){
          this.quill.root.innerHTML = ''
          this.URL = 'Project/createItem'
          this.resetItem();
          $('#kt_modal_add_item').modal('show');
          this.titleModal = 'Add New'


        },

 
        getModalEdit(item){
            this.ItemID = item.id
            this.resetItem();
            $('#kt_modal_add_item').modal('show');
            this.titleModal = 'Edit Item'
            this.getItemById() 
            this.URL = 'Project/editItem'
        },


      

        closeModal(){
            $('#kt_modal_add_item').modal('hide');
            this.URL = 'Project/createItem'
            this.ItemID = null
            // this.resetMark();
        },


      

        resetItem(){
          this.formData =  {
                code:'',
                title:'',
                name: '',
                type: '',
                description: '',
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
            await axios.get('Project/getAllItems', {
                params: {
                  search: this.searchQuery,  // تمرير قيمة البحث
                  pagination: 1,
                  page:page,
                  object: this.routeSegment,
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

    
       

        addEditItem() {

          
          this.isLoading = true;

           
           const config = {
                  headers: {
                      'content-type': 'multipart/form-data'
                  }
              }

             let form = new FormData();
              form.append('code', this.formData.code);
              form.append('name', this.formData.name);
              form.append('title', this.formData.title);
              form.append('order', this.formData.order);
              
              form.append('type', this.formData.type);
              form.append('type_item', 'rfp');
              console.log(this.quill.root.innerHTML);

              let content = this.quill.root.innerHTML; 
              form.append('description', content);
              
             

             
           
            if(this.ItemID != ''){
               form.append('Item_id', this.ItemID);
            }
             
          axios.post(this.URL,form,config).then((response)=>{
                 this.isLoading = false;
                if(response.data.items){
                   swal.fire({
                    text: "Doning successfully",
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


            axios.get('Project/getById', { params: { ID: this.ItemID } }).then(response => {
                if(response.data){
                  let data = response.data.items
                  this.resetItem()
                  this.formData = data

                  this.quill.root.innerHTML = data.description


                }else{
                    Swal.fire({
                        text: "Error happens 3",
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
                    text: 'Error happens 4',
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
              axios.delete(`ItemsObjects/deleteItem/${id}`)
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

