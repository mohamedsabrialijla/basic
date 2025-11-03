<template>
  <div class="card">
    <div class="row" style="margin-top:60px;">
      <!-- Stepper -->
      
      <div class="col-12 mb-4">
       

         <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
          <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
          
            <div class="d-flex align-items-center gap-2 gap-lg-3">
              
              <a href="#" class="btn btn-sm fw-bold btn-secondary" 
                @click="openList()">Return To List</a>

              <a href="#" class="btn btn-sm fw-bold btn-info" v-if="currentStep !== 0 "
                @click="setStep(currentStep -1)">Previous</a>

              <a href="#" class="btn btn-sm fw-bold btn-info" disabled="currentStep === steps.length - 1" v-if="currentStep < 3 " @click="nextStep">Next</a>



            </div>
          </div>
        </div>

        <div class="d-flex align-items-center flex-wrap d-grid gap-2" style="gap:3.5rem !important;width: 73%;margin: auto;">

          <div class="d-flex align-items-center"  v-for="(step, index) in steps" 
                :key="index" 
                
                @click="setStep(index)">
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
        </div>
      </div>

      
          
      <!-- Step 1: Kanban Board -->
      <div v-if="currentStep === 0" class="col-12">
         <div class="modal-body px-5 my-7" >
          
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
              <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                  <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">RFP Overview</h1>
                  


                  
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                  
                  <span v-if="formData && formData.status"  :class="getStatusClass(formData.status)" class="btn btn-sm ">
                    {{formData.status}}
                  </span>

             

                  <a href="#" class="btn btn-sm fw-bold btn-info" @click="Approve('approve')" v-if="formData.status =='Ready'">Confirm </a>
                  
     
                
                  
                  <a href="#" class="btn btn-sm fw-bold btn-info" v-if="currentStep == 1 && formData.status =='Ready'" @click="getModalCreate()" >Decline</a>
                </div>
              </div>
            </div>
             

            <div class="row">
             

              <div class="col-md-12">


                <div class="modal-body px-5 my-7">
                  
                  <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px" style="height: 500px;">

                      <WordFile></WordFile>

                    </div>
        
                </div>


 



              </div>
            </div>
        </div>
      </div>
 


      <!-- Step 2 -->
      <div v-if="currentStep === 1" class="col-12">
          
          <PricingSheetView></PricingSheetView>

      </div>



      <!-- Step 3 -->
      <div v-if="currentStep === 2" class="col-12">
        <TechnicalView></TechnicalView>
      </div>



      <!-- Step 4 -->
      <div v-if="currentStep === 3" class="col-12">
        <CompanyInformation></CompanyInformation>
      </div>



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
          <h2 class="fw-bold">Decline Justifications</h2>
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


              <div class="mb-10" v-if="formData">
                  <label class="required fw-semibold fs-6 mb-5">Select One of The Below Reasons</label>
                  <div class="d-flex flex-column fv-row fv-plugins-icon-container">
                      

                      <div
                        class="form-check form-check-custom form-check-solid mb-5"
                        v-for="(item, index) in ItemsReason"
                        :key="item.id"
                      >
                        <input 
                          class="form-check-input me-3"
                          type="radio"
                          :id="'reason_' + item.id"
                          :name="'reason_radio'"
                          :value="item.id"
                          v-model="formData.reason_id" 
                        />

                        <label class="form-check-label" :for="'reason_' + item.id">
                          <div class="fw-semibold text-gray-800">{{ item.name }}</div>
                        </label>
                      </div>




                      
                  </div>
              </div>
           
            

              <div class="fv-row mb-7" >
                <label class="required fw-semibold fs-6 mb-2">Explain More Details :</label>
                <textarea v-if="formData" rows="4" id="messageContent" maxlength="250"
                   v-model="formData.comment" value=""
                    placeholdr="Write Here..." class="form-control " >     
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
import WordFile from './WordFile.vue';
import PricingSheetView from './PricingSheetView.vue';
import TechnicalView from './TechnicalView.vue';
import CompanyInformation from './CompanyInformation.vue';

 Quill.register({
  'modules/better-table': QuillBetterTable
}, true);

import { nextTick } from 'vue';
 
 
export default {
  components: {
    Pagination,Multiselect,WordFile,PricingSheetView,TechnicalView,CompanyInformation  
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
                reason_id:null,
                comment:null,
                rfp_id:null,
            },

            formDocument:{
              answer: null,
            },

            currentStep: 0,
            steps: ["RFP", "Pricing sheet", "Technical Acceptance criteria" ,"Company Information and Authorized Signee"],

            logo:'',
            quill: null,
            click:false,


            
            ItemID: null,
            URL:'VendorApprove/createItem', 

            formSection:{},
            ItemsCriteria:[],
            ItemsReason:[],
            file: '',

        };
    },


 
 

   mounted() {

        this.fetchItems()
        this.fetchItemsCriteria()

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
                return 'Vendor SOI Response';
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


     setStep(index) {
     
      this.currentStep = index;
    },



    async nextStep() {
      
        if (this.currentStep < this.steps.length - 1) {
            this.currentStep++;
        }
    },



    prevStep() {
      if (this.currentStep > 0) {
        this.currentStep--;
      }
    },





    swalFunction(type, text) {
        Swal.fire({
            text: text,
            icon: type,
            showConfirmButton: false, // إخفاء زر التأكيد
            timer: 2000, // يغلق تلقائياً بعد 2 ثانية
            timerProgressBar: true, // شريط مؤقت
            toast: true, // إشعار صغير مثل التوست
            position: 'top-end', // المكان: أعلى يمين
            customClass: {
                popup: 'bg-light shadow-sm',
            }
        });
    },
 

    onFileChange(e,id,answer) {
        this.file = e.target.files[0];
            const file = e.target.files[0];
            if (file) {
                this.formData.file = URL.createObjectURL(file);
            }

            this.ApproveDocument(id, answer, file);

        },



     getStatusClass(status) {
            switch (status) {
              case 'Completed':
                return 'btn-light-success';
              case 'Ready':
                return 'btn-light-warning';

              case 'Overdue':
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

            this.formData={
              reason_id:null,
              comment: null
            }

        },
        


        closeModal(){
            $('#kt_modal_add_item').modal('hide');
        },

  
   

      Approve(status=null){

        this.isLoading = true;  
        let rfp_id = JSON.parse(localStorage.getItem('RFPVendor'));
       
          if(status == 'approve'){
            this.formData.status = 'Completed';
          }

          this.formData.rfp_id = rfp_id?.id ?? null;

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
              axios.post(this.URL,{ ...this.formData })
                .then(() => {
                      $('#kt_modal_add_item').modal('hide');
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


 


      ApproveDocument(id, answer){

            this.isLoading = true;  
            let rfp_id = JSON.parse(localStorage.getItem('RFPVendor'));
        
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }


            let form = new FormData();
              form.append('rfp_id', rfp_id.id);
              form.append('criteria_id', id);
              form.append('type', 'vendorTeam');
              // form.append('approve_id', this.formData.id);
              form.append('approve', answer);
             
              if (this.file) {
                form.append('file', this.file);
              }


            axios.post('VendorApprove/createItemDocument',form,config).then((response)=>{
               this.isLoading = false;
              if(response.data.code==200){ 
                 this.swalFunction('info','The File uploaded successfully');
                 if(this.formData.comment){
                  $('#kt_modal_add_item').modal('hide');
                 }
                 // this.approves = response.data.items
                 this.fetchItems()
                 this.fetchItemsCriteria()

              }else{
                  this.swalFunction('info', response.data.message)
              }             
          
            }).catch(error => {
                this.isLoading = false;
                this.swalFunction('error','Error Happens')
              });

      },

  
   
 
      async fetchItems() {
          this.isLoading = true;
           let rfp_id = JSON.parse(localStorage.getItem('RFPVendor'));
            await axios.get('VendorApprove/getAllItems', {
                params: {
                  type:'vendorTeam',
                  rfp_id:rfp_id.id,
                }
              })
                .then(response => {
                    this.items = response.data.items;
                    this.isLoading = false;
                    this.formData = this.items

                    console.log(this.formData)

                })
                .catch(error => {
                   this.swalFunction('error','Error Happens')
                   this.isLoading = false;

                }); 

              
        }, 


        async fetchItemsCriteria() {
          this.isLoading = true;
          let rfp_id = JSON.parse(localStorage.getItem('RFPVendor'));

             await axios.get('ItemsCategories/getAllItems', {
                params: {
                  pagination: 0,
                  rfp_id:rfp_id.id,
                }
              }).then(response => {
                    this.items = response.data.items;
                    // this.ItemsVendors = this.items.filter(item => item.type && item.type.name === "vendors");
                    this.ItemsCriteria = this.items.filter(item => item.type && item.type.name === "criteria");
                    this.ItemsReason = this.items.filter(item => item.type && item.type.name === "reasons");
                    this.isLoading = false;
                })
                .catch(error => {
                  this.swalFunction('error','Error Happens 55')

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
