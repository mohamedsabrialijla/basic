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
               #_NO
              </th>
              <th class="min-w-125px">Name</th>
              <th class="min-w-125px">Joined Date</th>
              <th class="text-center min-w-100px">Actions</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 fw-semibold">
            <tr v-for="(item, index) in items" :key="item.id">
              <td >
                {{index+1}}
              </td>


            


              <td class="align-items-center" style="margin-top: 15px;">
                <!--begin:: Avatar -->
               
                <!--end::Avatar-->
                <!--begin::User details-->
                <div class="d-flex flex-column">
                  <a href="#" class="text-gray-800 text-hover-primary mb-1">{{item.name}}</a>
                </div>
              </td>
              
              <td>{{item.created_at}}</td>
             

              <td class="text-end">
                 <div class="d-flex flex-center rounded p-4 h-80px mb-1 overlay">
                      <div class="overlay-wrapper text-gray-600">
                          <i @click="openStep(item)" class="ki-duotone ki-notepad-edit fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                            
                  </div>
              </td>
            </tr>
       
          </tbody>
        </table>

       

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
import { mapState } from 'vuex';
import Multiselect from 'vue-multiselect';

 
export default {
  components: {
    Multiselect,
    
  },
    data() {
        return {
            languages:{},
            selectedItems: [], // Selected items for deletion
            selectAll: false, // To track if all items are selected
            searchQuery: '', // الكلمة المفتاحية للبحث
            isLoading: false, // حالة التحميل
            items: [], 
            searchQuery: '',
            formData: {
                logo: '',
            },

            logo:'',

            
            ItemID: null,
            URL:'',

            Item: '',
            myData:{},
            step:null,
            showStep1: false,

        };
    },


    mounted() {
       
        this.fetchItems();
        
    },


   computed: {
          locale() {
              return this.$route.params.locale;
          }
      },
   
    methods: {

       

      openStep(Item){
        

        localStorage.setItem('itemStep',JSON.stringify(Item));
        this.$router.push({ path: `/${this.locale}/dashboard/master_data/projects/step-template` });
      },


        
       
 
        // getModalEdit(item){
        //   this.Item = item
        //     this.ItemID = item.id
        //     if(item.name == 'SOI'){
        //       this.showStep1 = true;
        //     }
        //     $('#kt_modal_add_item').modal('show');
        //     this.titleModal = 'Step'
        //     this.getItemByIdTest() 
        //     // this.URL = 'ItemsObjects/editItem'
        // },


      

        closeModal(){
            $('#kt_modal_add_item').modal('hide');
            this.URL = 'ItemsObjects/createItem'
            this.ItemID = null
            this.Item = null
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
          this.fetchItems(this.searchQuery); 
        },


        async fetchItems(query = '') {
            axios.get('/ItemsCategories/getAllItems?pagination=0', {
                params: {
                    search: this.searchQuery,  
                    pagination: 0,
                    type: 'documents'
                } 
            })
            .then(response => {
                this.items = response.data.items;
                this.isLoading = false;


            })
            .catch(error => {
                console.log(error);
            });
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

