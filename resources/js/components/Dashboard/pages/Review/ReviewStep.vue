


<template>
  <div class="card">
    <div class="row" style="margin-top:60px;">
      <!-- Stepper -->
      

      <div class="col-12 mb-4">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
          <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">RFP Dashboard</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="index.html" class="text-muted text-hover-info">RFP</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                
                <li class="breadcrumb-item text-muted">{{ breadcrumbLabel }}</li>

              </ul>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
              
              <a href="#" class="btn btn-sm fw-bold btn-secondary" 
                @click="openList()">Cancel</a>
              

              <a href="#" class="btn btn-sm fw-bold btn-info" @click="Approve2('approve')">Approve</a>
              
 
            
              
              <a href="#" class="btn btn-sm fw-bold btn-info" v-if="currentStep == 1" @click="getModalCreate()">Return To Comment</a>
            </div>
          </div>
        </div> 

       <!--  <div class="d-flex align-items-center flex-wrap d-grid gap-2" style="gap:3.5rem !important;width: 53%;margin: auto;">

          <div class="d-flex align-items-center"  v-for="(step, index) in steps" 
                :key="index"  @click="setStep(index)">
            <div class="symbol symbol-30px symbol-circle me-3">
              <span class="symbol-label bg-light-info" >
                  
                  <i class="ki-duotone ki-black-right fs-2 text-gray-500" v-if="currentStep === index"></i>
                  <l v-else>{{index+1}}</l>

              </span>
            </div>
            <div class="m-0">
              <span class="fw-semibold text-gray-500 d-block fs-8" style="cursor:pointer;"> {{ step }}</span>
            </div>
          </div>
        </div> -->
      </div>


       
          
      <!-- Step 1: Kanban Board -->
      <div v-if="currentStep === 0" class="col-12">
         Step One
      </div>



      <!-- Step 2 -->
      <div v-if="currentStep === 1" class="col-12">
        

        <div class="modal-body px-5 my-7" >
        
         

            <div class="row">
             

              <div class="col-md-12">


                <div class="modal-body px-5 my-7">
                  
                  <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px" style="height: 500px;">

                      <WordFile></WordFile>

                    </div>
        
                </div>




                  <table class="table table-bordered">
                    <thead class="thead-light" style="background: #f4f4f4;font-weight: bold;">
                      <tr>
                        <th scope="col">ReviewBy</th>
                        <th scope="col">Department</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Action On Decline/Approve</th>
                        <th scope="col" >Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  KPI</th>
                        <th scope="col">Comment </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item,index) in items" :key="item.id">
                        <td v-if="item.user">{{item.user.name}}</td>
                        <td v-if="item.department">{{item.department.name}}</td>
                        <td>{{item.dead}}</td>
                        <td :class="getDateClass(item.overdue)">{{item.approv}}</td>
                        <td> 

                          <span :class="getStatusClass(item.status)" class="btn btn-sm">
                            {{ item.status }}
                          </span>
                          &nbsp;&nbsp;&nbsp;&nbsp;
                          <span :class="getKPIClass(item.kpi)" style="height: calc(1.5em + 0.55rem + 2px); margin-top:6px;" class="btn btn-icon me-2 mb-2">
                            {{ item.kpi }}
                          </span>

                        </td>
                        <td>{{item.comment}}</td>
                      </tr>
                      
                    </tbody>
                  </table>



              </div>
            </div>
        </div>
           
      </div>


        
      </div>

      <!-- Step 3 -->
      <div v-if="currentStep === 2" class="col-12">

        step three

      </div>



    </div>








<!--begin::Modal - Add task-->
  <div class="modal fade" id="kt_modal_add_item" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
      <!--begin::Modal content-->
      <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header" id="kt_modal_add_user_header">
          <!--begin::Modal title-->
          <h2 class="fw-bold">Send Comment</h2>
          <!--end::Modal title-->
          <!--begin::Close-->
          <div class="btn btn-icon btn-sm btn-active-icon-info" data-kt-users-modal-action="close" @click="closeModal">
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



           
            

              <div class="fv-row mb-7" >
                <label class="required fw-semibold fs-6 mb-2">Comment</label>
                <textarea rows="6" id="messageContent" maxlength="250"
                   v-model="formData.comment" value=""
                    placeholdr="Comment" class="form-control " >     
                </textarea>
              </div>



            </div>
            <div class="text-center pt-10">
              <button type="submit" class="btn btn-info" @click.prevent="Approve('comment')" :disabled="isLoading">
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
import { mapState } from 'vuex';
import Multiselect from 'vue-multiselect'
import Quill from 'quill';
import QuillBetterTable from 'quill-better-table';
import 'quill/dist/quill.snow.css';
import 'quill-better-table/dist/quill-better-table.css';
import WordFile from '../Review/WordFile.vue';

 Quill.register({
  'modules/better-table': QuillBetterTable
}, true);

import { nextTick } from 'vue';

 
export default {
  components: {
    Pagination,Multiselect,WordFile
  },
    data() {
        return {
            languages:{},
            totalItems: 0, 
            currentPage: 1,
            selectedItems: [], 
            selectAll: false, 
            searchQuery: '', 
            isLoading: false, 
            items: [], 
            itemsCategories: [],
            ItemsContracts: [],
            sections :[],
            ItemsUsers:[],
            ItemsVendors:[],
            ItemsTypeEvents:[],

            searchQuery: '',
            formData: {
                type:'',
            },

            currentStep: 1,
            steps: ["Information RFP", "RFP Sheet", "RFP"],

            logo:'',
            quill: null,
            click:false,


            
            ItemID: null,
            URL:'ReviewApprove/createItem',

            formSection:{},

        };
    },



 

   mounted() {

        this.fetchItems()
        this.fetchItems()
    }, 

    computed: {
      locale() {
              return this.$route.params.locale;
          },


           breadcrumbLabel() {
            switch (this.currentStep) {
              case 0:
                return 'Event';
              case 1:
                return 'Review Approval';
              case 2:
                return 'Publish';
              case 3:
                return 'Done';
              default:
                return 'Dashboards';
            }
          },


          

        },

  methods: {


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
 

     getStatusClass(status) {
            switch (status) {
              case 'Completed':
                return 'btn-light-success';
              case 'Ready':
                return 'btn-light-warning';

              case 'Overdue':
                return 'btn-light-danger';

              case 'Decline':
                return 'btn-light-danger';
              
              default:
                return 'btn-light-secondary';
            }
          },


          getKPIClass(kpi) {
            if (kpi >= 0 && kpi != null) {
              return 'btn-success';
            } else if (kpi < 0 && kpi != null ) {
              return 'btn-danger';
            } else if (kpi == null ) {
              return 'btn-secondary';
            
            } else {
              return 'btn-secondary';
            }
          },



          getDateClass(overdue) {
            switch (overdue) {
              case '1':
                return 'text-danger';
              
              default:
                return 'text-black';
            }
          },
    


        getModalCreate(){
            $('#kt_modal_add_item').modal('show');

        },
        


        closeModal(){
            $('#kt_modal_add_item').modal('hide');
        },

  
  

      Approve(type){

        this.isLoading = true;  
        let rfp_id = JSON.parse(localStorage.getItem('RFPReview'));
        if(this.ItemID && this.ItemID != ''){
           this.URL = 'ReviewApprove/editItem'
        }

          this.formData.type = type
        

        this.formData.rfp_id = rfp_id.id 
        axios.post(this.URL,this.formData).then((response)=>{
               this.isLoading = false;
              if(response.data.code==200){ 
                 this.formData.type=''
                 if(this.formData.comment){
                  $('#kt_modal_add_item').modal('hide');
                 }
                 // this.approves = response.data.items
                 this.fetchItems()
                 this.swalFunction('success', 'Approved successfully')

              }else{
                  this.swalFunction('info', response.data.message)
              }             
          
        }).catch(error => {
                this.isLoading = false;
                this.swalFunction('error','Error Happens')
              });

      },


      Approve2(type){

        this.isLoading = true;  
        let rfp_id = JSON.parse(localStorage.getItem('RFPReview'));
        if(this.ItemID && this.ItemID != ''){
           this.URL = 'ReviewApprove/editItem'
        }

          this.formData.type = type
        

        this.formData.rfp_id = rfp_id.id 


        swal.fire({
            text: "Are you sure ?",
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
              axios.post(this.URL,this.formData)
                .then(() => {
                     this.formData.type=''
                     this.fetchItems()
                     this.swalFunction('success', 'Approved successfully')
 
                })
                .catch(error => {
                  swal.fire({
                    text: 'Error Approve the item. Please try again.', 
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
                text: 'The Approved has been canceled.', 
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











 
     




      async fetchItems() {
          this.isLoading = true;
           let rfp_id = JSON.parse(localStorage.getItem('RFPReview'));
            await axios.get('ReviewApprove/getAllItems', {
                params: {
                  type:'reviewTeam',
                  rfp_id:rfp_id.id,
                }
              })
                .then(response => {
                    this.items = response.data.items;
                    this.isLoading = false;
                })
                .catch(error => {
                   this.swalFunction('error','Error Happens')
                   this.isLoading = false;

                });

              
        },

    



      



    


 

  





  },
};
</script>



<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>

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


.stepper {
  list-style: none;
  display: flex;
  justify-content: space-between;
  padding: 0;
  margin: 0 0 20px 0;
}

.stepper li {
  padding: 10px 20px;
  background-color: #f0f0f0;
  border-radius: 5px;
  cursor: pointer;
  flex: 1;
  text-align: center;
  margin-right: 10px;
  transition: background-color 0.3s;
}

.stepper li:last-child {
  margin-right: 0;
}

.stepper li.active {
  background-color: #007bff;
  color: white;
}

.stepper-footer {
  display: flex;
  justify-content: space-between;
}



.card-header {
  background-color: #ffffff;
}
.custom-header{
  min-height: 45px !important;
  padding: 0 1.25rem !important;
}
.menu-tasks {
  display: flex;
  flex-direction: column;
}

.activeBackground{
  background-color: #7239ea ;
}

.task-column{
  min-height: 150px;
}


.card .card-body{
  padding-left: none !important;
}











</style>
