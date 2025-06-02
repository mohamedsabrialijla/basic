<template>
           
 <!--begin::Post-->
  <div class="content flex-column-fluid" id="kt_content">
    <!--begin::Card-->
    <div class="card">
     
      <div class="card-body py-4">
        <!--begin::Table-->
        <div v-if="isLoading">
          please wait ...
        </div>
        

 
   
 
      <div class="table-responsive">
        
        <table class="table table-bordered table-striped align-middle table excel-like-table">
          <tr>
              <td colspan="10" class="background">Bid Opening Form</td>

          </tr>
          <tr>
              
              <td class="background">Bid Title</td>
              <td colspan="5"><input type="text" class="form-control" v-model="formData.st31"></td>
             
              <td colspan="2" class="background">Time:</td>
              <td colspan="3"><input type="time" class="form-control" v-model="formData.st33"></td>
              
          </tr>
          <tr>
              <td class="background">PR Number</td>
              <td colspan="5"><input type="text" class="form-control" v-model="formData.st32"></td>
             
              <td colspan="2" class="background">Date:</td>
              <td colspan="3"><input type="date" class="form-control" v-model="formData.st34"></td>
             
          </tr>

          <tr>
              <td colspan="10">   </td>
             
          </tr>


          <tr>
              <td colspan="10" class="background"> PART 1: Record of Bid Opened and Details Read Out  </td>
             
          </tr>
          <tr class="background">
              <td>No.</td>
              <td colspan="2">Name of Bidder from step one with can delete any itm </td>
              
              <td colspan="2">Bids Sealed? <br/> (Y/N)</td>
              <td colspan="3">Bids clearly Marked <br/> (Y/N)</td>
             
              <td >Number of envelopes</td>
              
              <td>Status</td>
          </tr>
 

          <tr v-for= "(vendor,index) in ItemsVendors" :key="vendor.id" >
              <td>{{index+1}}</td>
              <td colspan="2">{{vendor.name}}</td>


              
             <td v-for="(title,index) in ItemsTitle" :key="title.id" colspan="2">
              
               <div class="form-check form-check-custom form-check-success form-check-solid" v-if="title.type=='check'">
                   <input v-if="ItemsVendors.length > 0 "  v-model="formData.selectedValues3[vendor.id][title.id]" class="form-check-input" type="checkbox" value="" checked />
                   <label class="form-check-label" for="">
                       Yes
                   </label>
               </div>

               <div class="" v-if="title.type=='text'">
                   <input v-if="ItemsVendors.length > 0 "  v-model="formData.selectedValues3[vendor.id][title.id]" class="form-control" type="text" placeholder="" />
               
               </div>

           </td>
              
              
          </tr>
        


         <tr>
              <td colspan="10"></td>
              
          </tr>


          <tr>
              <td colspan="10" class="background">PART 2: Bid Opening Personnel </td>
             
          </tr>
          <tr>
              <td colspan="4"> Name  </td>
              
              <td colspan="4">Department</td>
             
              <td colspan="2">Signature  </td>
             
          </tr>
         
            <tr v-for="i in 9" :key="i">
                <td colspan="4">
                  <multiselect
                    class=""
                    v-model="formData[`R${i}`]"
                    tag-placeholder="Select"
                    placeholder="Search ..."
                    label="name"
                    track-by="id"
                    :options="itemsUsersDefualt"
                    :multiple="false"
                    :taggable="false"
                    :options-limit="10"
                    :allow-empty="false"
                  />
                </td>

                <td colspan="4">
                  <multiselect
                    disabled
                    class=""
                    v-model="formData[`R${i}`]"
                    tag-placeholder="Select"
                    placeholder="Search ..."
                    label="department_name"
                    track-by="id"
                    :options="itemsUsersDefualt"
                    :multiple="false"
                    :taggable="false"
                    :options-limit="10"
                    :allow-empty="false"
                  />
                </td>

                <td colspan="2"><input type="text" class="form-control" v-model="formData[`S${i}`]"></td>
              </tr>
 
              
              
           
       <tr>
         <td colspan="10" class="background"> PART 3: Bids Handover Information </td>
       </tr>


       <tr>
         <td colspan="5"></td>
         <td colspan="5">Technical Proposal</td>
       </tr>


       <tr>
         <td colspan="5">Name : </td>
         <td colspan="5">
           <multiselect class="" v-model="formData.st37" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
         </td>
       </tr>


       <tr>
         <td colspan="5">Number of Evaluation</td>
         <td colspan="5"><input type="number" class="form-control" placeholder="" v-model="formData.st38"></td>
       </tr>

       <tr>
         <td colspan="5">Signature</td>
         <td colspan="5"><input type="text" class="form-control" placeholder="Signature" v-model="formData.st39"></td>
       </tr>

     <!--   <tr >
           <td v-for="(user,index) in ItemsUsersApproval" :key="user.id" colspan="4" class="label_text text-center"><input type="text" class="form-control" v-model="formData.st3[user.id]" />________________</td>
         
      
       </tr> -->
         
      </table>

      </div>


    <div class="text-center pt-10">
            <button type="submit" class="btn btn-primary" @click.prevent="addEditItem" :disabled="isLoading">
              <span  class="indicator-label">Submit</span>
              <span  class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
              </span>
            </button>

              <button style="margin: 7px;" type="submit" class="btn btn-secondary" @click.prevent="closeModal">
              <router-link :to="`/${locale}/dashboard/master_data/projects/steps`"  class="indicator-label">Back</router-link>
              
            </button>

            </div>


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
import Multiselect from 'vue-multiselect'


 
export default {
  props: {
    myData: {
      type: Object,
      required: false 
    }
  },

  components: {
    Multiselect
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
            searchQuery: '',
            ItemsVendors:[],
            ItemsCriteria:[],
            ItemsUsersApproval:[],
            ItemsUsers:[],
            formData: {
                selectedValues3:{},
                st31: '',
                st32: '',
                st33: '',
                st34: '',
                st35: '',
                st36: '',
                st37: '',
                st38: '',
                st39: '',
                st3:{},
             
                step: 3,

             

                S1:'',
                S2:'',
                S3:'',
                S4:'',
                S5:'',
                S6:'',
                S7:'',
                S8:'',
                S9:'',


                R1:'',
                R2:'',
                R3:'',
                R4:'',
                R5:'',
                R6:'',
                R7:'',
                R8:'',
                R9:'',
               

           
            },
 
            itemsDepartments:[],
            itemsUsersDefualt:[],
            itemsAllSteps:[],


            ItemsTitle: [
              { id: 1, name: 'Bids Sealed?(Y/N)' , type:'check' },
              { id: 2, name: 'Bids clearly Marked(Y/N)' , type:'check'},
              { id: 3, name: 'Number of envelopes' , type:'text'},
              { id: 4, name: 'status' , type:'text'},
            ],


            logo:'',

            
            ItemID: null,
            URL:'ItemsObjects/createItem',

            itemStep:{},


            
            milestones: [
              'RFP Release',
              'Job-X | Q&A ',
              'BCD / Extension',
              'TE',
              'PCF (If <3 TE Qual)',
              'Negotiations',
              'PCE',
              'Contract / PO NOA',
              
            ],

        };
    },  


    mounted() {
       
      // this.fetchItemsAllSteps()
      this.fetchItems()
      this.fetchItemsDepartments()
      this.fetchItemsUsers()
   
      if (!this.formData.st34 || this.formData.st34 == null) {
        const d = new Date();
        this.formData.st34 = d.toISOString().split('T')[0];
      }

      if (!this.formData.st33 || this.formData.st33 == null) {
          const d = new Date();
          const hours = String(d.getHours()).padStart(2, '0');
          const minutes = String(d.getMinutes()).padStart(2, '0');
          this.formData.st33 = `${hours}:${minutes}`;
        }


        this.ItemsUsersApproval.forEach(user => {
          this.$set(this.formData.st3, user.id, '');
        });


    },

    computed: {
          locale() {
              return this.$route.params.locale;
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
                    confirmButton: "btn btn-primary"
                }
            });
        },



        async fetchItemsDepartments() {
          this.isLoading = true;
            await axios.get('Departments/getAllItems', {
                params: {
                  pagination: 0,
                }
              })
                .then(response => {
                    this.itemsDepartments = response.data.items;
                    this.isLoading = false;
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
          this.isLoading = true;
            await axios.get('Users/getAllItems', {
                params: {
                  pagination: 0,
                }
              })
                .then(response => {
                    this.itemsUsersDefualt = response.data.items;
                    this.isLoading = false;
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
 


        async fetchItems() {
          this.isLoading = true;
             await axios.get('ItemsCategories/getAllItems', {
                params: {
                  pagination: 0,
                }
              })
                .then(response => {
                    this.items = response.data.items;
                    this.ItemsVendors = this.items.filter(item => item.type && item.type.name === "vendors");
                    this.ItemsCriteria = this.items.filter(item => item.type && item.type.name === "criteria");
                    this.isLoading = false;

                    const raw = localStorage.getItem('itemStep');
                      if (raw) {
                        this.itemStep = JSON.parse(raw);

                        this.ItemsUsersApproval = this.itemStep.users;
                    }



                    this.formData.selectedValues3 = {};

                    this.ItemsVendors.forEach(vendor => {
                      this.formData.selectedValues3[vendor.id] = {};

                      this.ItemsTitle.forEach(title => {
                        if(title.type == 'check'){
                          this.formData.selectedValues3[vendor.id][title.id] = false;
                        
                        } else {
                          this.formData.selectedValues3[vendor.id][title.id] = '';
                        } 
                      });
                    });

                  
                     
                    let parsedData = {};


                    if(this.myData.data_json){
                    if (typeof this.myData.data_json === 'string') {
                      parsedData = JSON.parse(this.myData.data_json);
                    } else if (typeof this.myData.data_json === 'object') {
                      parsedData = this.myData.data_json;
                    }

                    this.formData = parsedData;
                    
                    }   



                    axios.get('Project/getAllItemsAllSteps', {
                      params: {
                        project_id: localStorage.getItem('ProjectID'),
                      }
                    })
                      .then(response => {
                          this.itemsAllSteps = response.data.items;
                          this.isLoading = false;


                          this.itemsAllSteps.forEach(item => {
                            let data = JSON.parse(item.data_json);
                           
                            

                            for (let i = 1; i <= 9; i++) {
                              const key = `R${i}`;
                              if (data[key] && !this.formData[key]) {
                                this.formData[key] = data[key];
                              }
                            }



                            




                            if (data.R10 && this.formData.st37 != '') {
                              this.formData.st37 =  data.R10;
                            }


                            // for (let key in data) {
                            //   console.log(`Key: ${key} | Value:`, data[key]);
                            // }
                            
                          });




                })




                })
                .catch(error => {
                  
                  this.swalFunction('error','Error Happens 55')

                   this.isLoading = false;
                });
        },
 

        // async fetchItemsAllSteps() {
        //   this.isLoading = true;
        //      await axios.get('Project/getAllItemsAllSteps', {
        //         params: {
        //           project_id: localStorage.getItem('ProjectID'),
        //         }
        //       })
        //         .then(response => {
        //             this.itemsAllSteps = response.data.items;
        //             this.isLoading = false;


        //             this.itemsAllSteps.forEach(item => {
        //               let data = JSON.parse(item.data_json);
                     

        //               if (this.formData.st1) {
        //                 this.formData.st1 =  data.st5 ;
        //               }


        //               if (data.R1 && data.R1.name) {
        //                 console.log(`step ${item.step} has R1 user:`, data.R1.name);
        //               }


        //               for (let key in data) {
        //                 console.log(`Key: ${key} | Value:`, data[key]);
        //               }

        //             });




        //         })
        //         .catch(error => {
                  
        //           this.swalFunction('error','Error Happens 55')

        //            this.isLoading = false;
        //         });
        // },








        addEditItem() {

          
          this.isLoading = true;

            
            if(this.ItemID != ''){
               this.formData.Item_id = this.ItemID;
            }
            

         this.formData.project_id = localStorage.getItem('ProjectID');

          axios.post('Steps/createItem',this.formData).then((response)=>{
                 this.isLoading = false;
                if(response.data.items){
                    this.swalFunction('success','Doing Success')
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




        closeModal(){
            $('#kt_modal_add_item').modal('hide');
        },



       


  },

 

 
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
.fw-bold_2 {
  background: #744bcb;
}

.fw-bold_3{
   background: #d0d2d5;
} 



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




.image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); } [data-bs-theme="dark"] 
.image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }



.label_text{
  font-size: 15px;
    font-weight: bold;
    color: #817a7a;
}


.excel-like-table td, .excel-like-table th {
    border: 1px solid #dee2e6 !important;
    padding: 8px;
    text-align: center;
    vertical-align: middle;
  }


input{
   border: 1px solid #ccc !important;
}
.background{

  background: #7030a0;
  color: #FFF;
}

.multiselect__select{
  display: none;
}

/*.table > :not(caption) > * > * {
     padding: 0rem 0rem
    }*/
</style>

