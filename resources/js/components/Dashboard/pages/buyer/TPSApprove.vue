<template>
  <div class="card">
    <div class="row" style="margin-top:60px;">
      <!-- Stepper -->
       

      <div class="col-12 mb-4">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
          <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Vendor SOI Response</h1>
              <span v-if="myStatus"  :class="getStatusClass(myStatus)" class="btn btn-sm ">
                {{myStatus}}
              </span>


 
              
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
              
              <a href="#" class="btn btn-sm fw-bold btn-secondary" 
                @click="openList()">Cancel</a>
              

              <a href="#" class="btn btn-sm fw-bold btn-info" v-if="myStatus == 'Ready' || myStatus == 'Overdue'" @click="getModalCreate('approve')">Confirm </a>
              
 
            
              
              <a href="#" class="btn btn-sm fw-bold btn-info" v-if="myStatus == 'Ready' || myStatus == 'Overdue'"  @click="getModalCreate('decline')">Return with Comment</a>
            </div>
          </div>
        </div>

        <div class="d-flex align-items-center flex-wrap d-grid gap-2" style="gap:3.5rem !important;width: 53%;margin: auto;">

          <!-- <div class="d-flex align-items-center"  v-for="(step, index) in steps" 
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
          </div> -->
        </div>
      </div>


       
          
 


      <!-- Step 2 -->
      <div class="col-12">
        

        <div class="modal-body px-5 my-7" >
            <div class="row">
             

              <div class="col-md-12">


                <div class="modal-body px-5 my-7">
                  
                  <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px" style="height: 500px;">

                       <TPS></TPS>

                    </div>
        
                </div>


                <div class="row">
     
    			        <div class="fv-row col-md-3" >
                    <label class="required fw-semibold fs-6 mb-2">Add SOI Response Deadline</label>
                    <input type="date" name="date"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Date Here" value="" :disabled="disabel==1" v-model="formDate.deadline" @input="selectTender()" required />
                  </div>

                  <div class="fv-row col-md-4">
                    <label class="required fw-semibold fs-6 mb-2">Buyer Team</label>
                    <multiselect v-if="ItemsUsers.length" class="" v-model="formDate.ItemsBuyerTender" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsUsers" :multiple="true" :taggable="false" :options-limit="10" :allow-empty="false" @select="selectTender()" @remove="selectTender()"  ></multiselect>

                  </div>
                </div>
 


                <table class="table" >
                    <thead class="thead-light" style="background: #f4f4f4;font-weight: bold;">
                      <tr>
                        <th scope="col">ReviewBy</th>
                        <th scope="col">Department</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Approved On</th>
                        <th scope="col" >Status </th> 
                        <th scope="col" >Comment </th> 
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item,index) in items" :key="item.id">
                        <td v-if="item" style="vertical-align: middle;">{{item?.user?.name}}</td>
                        <td v-if="item.department" style="vertical-align: middle;">{{item.department.name}}</td>
                        <td style="vertical-align: middle;">{{item.dead}}</td>
                        <td style="vertical-align: middle;">{{item.date_approved}}</td>
                        <!-- <td style="width: 410px;display: flex">
                        	<span :class="getStatusClass(item.status)" class="btn btn-sm">
	                            {{ item.status }}
	                          </span>&nbsp;&nbsp;&nbsp;&nbsp;

	                          <div class="form-check form-switch form-check-custom form-check-success form-check-solid" >
	                              <input v-model="item.answer" @change="ApproveForUser(item.id)" class="form-check-input " type="checkbox" value=""  id="kt_flexSwitchCustomDefault_1_1" style="cursor:pointer;"   :checked="item.criteria?.approve === 'true'">
 
	                             
	                          </div>


                        </td> -->


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
          <h2 class="fw-bold">{{titleModal}}</h2> 
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
                <label class="required fw-semibold fs-6 mb-2">Explain More Details :</label>
                <textarea v-if="formData" rows="4" id="messageContent" maxlength="250"
                   v-model="formData.comment" value=""
                    placeholdr="Write Here..." class="form-control " >     
                </textarea>
              </div>

            </div>
            <div class="text-center pt-10">
              <button type="submit" class="btn btn-info" @click.prevent="Approve(type)" :disabled="isLoading">
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
import { mapState } from 'vuex';
import VendorsResponseExcel from '../buyer/VendorsResponseExcel.vue';

import TPS from '../buyer/TPS.vue';
import Multiselect from 'vue-multiselect'


import { nextTick } from 'vue';
 
 
export default {
  components: {
    VendorsResponseExcel,TPS,Multiselect
  },
    data() {
        return {
            languages:{},
            
            rfp_id: null,
            formData: {
                reason_id: null,
                comment: null,
                rfp_id:null,

            },

            formDate: {
                deadline: null,
                rfp_id:null,
                user_id:null,
                ItemsBuyerTender:null,

            },
            disabel:null,
            myStatus:null,

           ItemsBuyerTender:[],
           ItemsBuyerTenderList:[],

           ItemsUsers:[],
           RfpObjectJ:null,
           type:null,
           titleModal:null,
           items:[],


            

             
            URL:'BuyerTps/createItem', 

            
        };
    },


 

   mounted() {

        let rfp = JSON.parse(localStorage.getItem('RFPBuyer'));
        this.rfp_id = rfp.id

        this.fetchItems();
        this.fetchItemsRFPObject()
        this.fetchItemsUsers();


    }, 
 
    computed: {
      locale() {
              return this.$route.params.locale;
          },

           ...mapState(['user']),

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
    


    getModalCreate(type){
        $('#kt_modal_add_item').modal('show');
        if(type=='approve'){
          this.titleModal= 'Approve Justifications'
        }else{
          this.titleModal= 'Decline Justifications'
        }

      this.type= type;
    },
        


    closeModal(){
        $('#kt_modal_add_item').modal('hide');
    },

  
    
 
    Approve(status=null){

      this.isLoading = true;  


        if(status == 'approve'){
          this.formData.status = 'Completed';
        }

        this.formData.rfp_id = this.RfpObject.id;
        this.formData.type = "buyerTpsTeam";

       swal.fire({
          text: "Are you sure " + status + "?",
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
            axios.post(this.URL,{ ...this.formData })
              .then(() => {
                    $('#kt_modal_add_item').modal('hide');
                    this.fetchItems()
                    this.swalFunction('success', 'Action successfully')

              })
              .catch(error => {
                swal.fire({
                  text: 'Error Action the item. Please try again.', 
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
              text: 'The Action has been canceled.', 
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

  
 
   
   async fetchItemsRFPObject() {

      this.isLoading = true;

        await axios.get('RFPStep/getById', {
            params: {
              ID:this.rfp_id,
            }
          })
            .then(response => { 
                this.RfpObject = response.data.items;
               this.ItemsBuyerTender = this.RfpObject.buyer_tender_team
               this.formDate.ItemsBuyerTender = this.RfpObject.buyer_tender_team

                this.formDate.deadline = this.RfpObject.deadline_tps_buyer
               // this.ItemsBuyerTenderList = this.ItemsBuyerTender

               


            })
            .catch(error => {
              console.log(error)
               this.swalFunction('error','Error Happens 7')
               this.isLoading = false;

            }); 
 
   },
 
    async fetchItems() {

        this.isLoading = true;
        
          await axios.get('BuyerTps/getAllItems', {
              params: {
                type:'BuyerTpsTeam',
                rfp_id:this.rfp_id,
              }
            })
              .then(response => { 
                  this.items = response.data.items;
                  this.myStatus = this.items.find(item => item.user_id === this.user.id)?.status || null;
                  this.isLoading = false;
                  this.formData = this.items
                  if(this.formData.length > 0){
                  	this.formDate.deadline = this.formData[0].deadline
                  	this.disabel = response.data.message ;             	
                  }

              })
              .catch(error => {
                console.log(error)
                 this.swalFunction('error','Error Happens 6')
                 this.isLoading = false;

              }); 
   
    },


    async fetchItemsUsers() {
        this.isLoading = true;
          await axios.get('Users/getAllItems', {
              params: {
                pagination: 0,
              }
            })
              .then(response => {
                  this.ItemsUsers = response.data.items;


                  // this.RfpObjectJ = JSON.parse(localStorage.getItem('RFPBuyer'));

                  if(!this.RfpObject.buyer_tender_team || this.RfpObject.buyer_tender_team == '' ){
                    return ;
                  }
 
                  this.ItemsBuyerTenderList =  JSON.parse(this.RfpObject.buyer_tender_team)

                  // console.log(this.ItemsBuyerTenderList)

                  let selectedFromDb =  this.ItemsBuyerTenderList


                  this.formDate.ItemsBuyerTender = this.ItemsUsers.filter(u =>
                    selectedFromDb.map(d => d.id).includes(u.id)
                  );


                  // this.ItemsBuyerTenderList = this.formDate.ItemsBuyerTender
                  this.isLoading = false;
              })
              .catch(error => {
                  
                  this.swalFunction('error',error)

                 this.isLoading = false;
              });
    },
 
 
    async selectTender(){
       
        await axios.post('BuyerTps/createItemApprove', {

                rfp_id: this.rfp_id,
                buyer_tender_team: this.formDate.ItemsBuyerTender,
                deadline: this.formDate.deadline
              }
            )
              .then(response => {

                  this.RfpObject = response.data.items;
                  this.formDate.deadline = this.RfpObject.deadline_tps_buyer

                  this.fetchItemsRFPObject()
                  this.fetchItems()
                  this.fetchItemsUsers()

                  this.isLoading = false;
              })
              .catch(error => {
                this.swalFunction('error',error)
               })
    },


 
  }
};
</script>


<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>


    .multiselect__option--highlight {
      background-color: transparent !important; /* Remove background highlight */
      color: inherit !important; /* Keep text color default */
  }

  .multiselect__option::after {
      content: "" !important;
  }



            
.multiselect__option--highlight {
    background: rgb(214,162,48) !important;
    outline: none;
    color: #fff;}

    .multiselect__tag {
    background: rgb(214,162,48);}

    .multiselect__tag-icon:after {
    color: #fff;
    }


    .multiselect--above{
      background: rgb(214,162,48);
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
