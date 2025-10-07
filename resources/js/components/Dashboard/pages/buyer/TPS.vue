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
        <table class="table table-bordered table-striped align-middle table excel-like-table" >
          <tr class="background">
            <td colspan="18" >TENDER / PROCUREMENT  PLAN SHEET (TPS)</td>
          </tr>
          <tr class="background">
              <td colspan="2">RFP Title</td>
              <td >RFP NO :</td>
              <td colspan="2">Customer <br>Department</td>
              
              <td colspan="3">Event Contract (Project) Duration </td>
            
              <td colspan="5">BUDGET</td>
              
              
              <td colspan="2">Reason for Approval</td>
              <td colspan="2">Technical Evaluation Committee (TEC)</td>
          </tr>
          <tr>
              <td colspan="2">{{RfpObject?.name}}</td>
              <td >{{RfpObject?.ID_rfp}}</td>
              <td colspan="2">
                  
              <div class="fv-row mb-7">
                {{RfpObject?.business_unite}}

              </div>




              </td>
             
              
              <td colspan="3"> {{RfpObject?.duration}} Month </td>
              <td colspan="2">{{RfpObject?.estimated_budget}} </td>
              <td colspan="3">  {{RfpObject?.description}}  </td>
              
              <td colspan="2"> Tender/Procurement Related Commities </td>
              <td class="background">Name</td>
              <td class="background">Department</td>
          </tr>
          <tr>
              <td colspan="2" class="background">Proposed Bidders</td>
              <td colspan="6" class="background">Event Project Description (Scope Overview): </td>
              
              <td colspan="7" rowspan="9"> <textarea @change="addEditItem" class="form-control" rows="40" v-model="formData.st8"></textarea><br></td>
             
              <td>{{technical_commite[0]?.name}}</td>
              <td>{{technical_commite[0]?.department?.name}}</td>
          </tr>
          <tr>
              <td colspan="1">Name</td>
              <td colspan="1">SIM</td>
              <td colspan="6" class="background">Tender Documents Chck list:</td>
             
             
              <td>{{technical_commite[1]?.name}}</td>
              <td>{{technical_commite[1]?.department?.name}}</td>
          </tr>
          <tr>
     
                
              <td>{{itemsBiddersVendor[0]?.name}} <p style="color:rgb(41 127 169)">(Pre-Qualified)</p></td>
              <td>{{itemsBiddersVendor[0]?.department?.name}}</td>

              <td colspan="5" class="background">Description</td>
            
              <td class="background">Yes / No</td>
              <!-- <td colspan="7"></td> -->
             
              <td>{{technical_commite[2]?.name}}</td>
              <td>{{technical_commite[2]?.department?.name}}</td>
          </tr>
          <tr>
               <td>{{itemsBiddersVendor[1]?.name}} <p style="color:rgb(41 127 169)">(Pre-Qualified)</p> </td>
              <td>{{itemsBiddersVendor[1]?.department?.name}}</td>

              <td colspan="5" class="background">Final RFP / Scope of Work Document</td>
              
              <td class="background text-success">{{ checkOne(RfpObject?.check_1) }}</td>
              <!-- <td colspan="7"></td> -->
             
              <td>{{technical_commite[3]?.name}}</td>
              <td>{{technical_commite[3]?.department?.name}}</td>
          </tr>
          <tr>
               <td>{{itemsBiddersVendor[2]?.name}} <p style="color:rgb(41 127 169)">(Pre-Qualified)</p></td>
              <td>{{itemsBiddersVendor[2]?.department?.name}}</td>
              <td colspan="5" class="background">BOQ/Deliverables (Pricings Sheet)</td>
              
              <td class="background text-success">{{ checkOne(RfpObject?.check_2) }}</td>
              <!-- <td colspan="7"></td> -->
             
              <td>{{technical_commite[4]?.name}}</td>
              <td>{{technical_commite[4]?.department?.name}}</td>
          </tr>
          <tr>
               <td>{{itemsBiddersVendor[3]?.name}} <p style="color:rgb(41 127 169)">(Pre-Qualified)</p></td>
              <td>{{itemsBiddersVendor[3]?.department?.name}}</td>              
              <td colspan="5" class="background">Technical Criteras in RFP</td>
             
              <td class="background text-success">{{ checkOne(RfpObject?.check_3) }}</td>
              <!-- <td colspan="7"></td> -->
             
              <td>{{technical_commite[5]?.name}}</td>
              <td>{{technical_commite[5]?.department?.name}}</td>
          </tr>
          <tr>
              <td>{{itemsBiddersVendor[4]?.name}} <p style="color:rgb(41 127 169)">(Pre-Qualified)</p></td>
              <td>{{itemsBiddersVendor[4]?.department?.name}}</td>

              <td colspan="5" class="background">Appendix to the RFP (Drawings/Datasheet Etc.)</td>
              
              <td class="background text-success">{{ checkOne(RfpObject?.check_4) }}</td>
              <!-- <td colspan="7"></td> -->
            
              <td>{{technical_commite[6]?.name}}</td>
              <td>{{technical_commite[6]?.department?.name}}</td>
          </tr>
          <tr>
               <td>{{itemsBiddersVendor[5]?.name}} <p style="color:rgb(41 127 169)">(Pre-Qualified)</p></td>
              <td>{{itemsBiddersVendor[5]?.department?.name}}</td>

              <td colspan="5" class="background">DACO General Cotract with T&amp;C</td>
              
              <td class="background text-success">{{ checkOne(RfpObject?.check_5) }}</td>
              <!-- <td colspan="7"></td> -->
             
              <td>{{technical_commite[7]?.name}}</td>
              <td>{{technical_commite[7]?.department?.name}}</td>
          </tr>
          <tr>
              <td>{{itemsBiddersVendor[6]?.name}} <p style="color:rgb(41 127 169)">(Pre-Qualified)</p></td>
              <td>{{itemsBiddersVendor[6]?.department?.name}}</td>

              <td colspan="5" class="background">Internal Technical Evaluation Sheet with Conditions &amp; score</td>
              
              <td class="background text-success">{{ checkOne(RfpObject?.check_6) }}</td>
              <!-- <td colspan="7"></td> -->
              
              <td>{{technical_commite[8]?.name}}</td>
              <td>{{technical_commite[8]?.department?.name}}</td>
          </tr>
          <tr>
               <td>{{itemsBiddersVendor[7]?.name}} <p style="color:rgb(41 127 169)">(Pre-Qualified)</p></td>
              <td>{{itemsBiddersVendor[7]?.department?.name}}</td>
              <td colspan="6" class="background"> 

                <div class="form-check form-check-custom form-check-success form-check-solid" style="gap:25px;color: #fff;">
                  Technical Evaluation & Weight:
                   <input  class="form-check-input" type="checkbox" value="" checked />
                   <label class="form-check-label" for="">
                       weight
                   </label>


                   <input  class="form-check-input" type="checkbox" value="" checked />
                   <label class="form-check-label" for="">
                       Min Price
                   </label>
               </div>

             </td>
              
              <td colspan="4">{{RfpObject?.techinical_passing_score }}%</td>
             
              <td colspan="2" class="background">Commercial Evaluation Weight</td>
              <td >{{100 - RfpObject?.techinical_passing_score }}%</td>
              <td></td>
              <td></td>
          </tr>
          <tr>
              <td></td>
              <td></td>
              <td colspan="6" class="background">Technical Passing Score :</td>
              
              <td colspan="7">{{RfpObject?.techinical_passing_score }} From 100 %</td>
              
              <td></td>
              <td></td>
          </tr>
          <tr>
              <td></td>
              <td></td>
              <td colspan="6" class="background">How many Contractors to be awarded? </td>
              
              <td colspan="2">{{RfpObject?.duration}}</td>
              <td colspan="2" class="background">Contract period </td>
              <td colspan="3">{{RfpObject?.number_contractor}}</td>
          
              <td></td>
              <td></td>
          </tr>
          <tr>
              <td colspan="2" class="background">RFP REVIEW TEAM</td>
              <td colspan="6"></td>
              
              <td colspan="7"></td>
              
              <td colspan="2" class="background">Commercial Evaluation Committee</td>
          </tr>
          <tr>
              <td>Name</td>
              <td>Department</td>
              <td colspan="6"></td>
             
              <td colspan="7"></td>
              
              <td>Name</td>
              <td>Department</td>
          </tr>
          <tr>
              <td>{{review_team[0]?.name}}</td>
              <td>{{review_team[0]?.department.name}}</td>
              


              <td colspan="6"></td>
            
              <td colspan="7"></td>
              
              <td>{{commercial_evaluation_committee[0]?.name}}</td>
              <td>{{commercial_evaluation_committee[0]?.department?.name}}</td>
          </tr>
          <tr>
              
              <td>{{review_team[1]?.name}}</td>
              <td>{{review_team[1]?.department.name}}</td>
              

              <td colspan="6"></td>
              
              <td colspan="7"></td>
             
              <td>{{commercial_evaluation_committee[1]?.name}}</td>
              <td>{{commercial_evaluation_committee[1]?.department?.name}}</td>
              
          </tr>
          <tr>
               <td>{{review_team[2]?.name}}</td>
               <td>{{review_team[2]?.department.name}}</td>

              <td colspan="6" class="background">Technical Evaluation :</td>
              
              <td colspan="7">As Aper Technical Cretirias in RFP & TE sheet</td>
              
              <td>{{commercial_evaluation_committee[2]?.name}}</td>
              <td>{{commercial_evaluation_committee[2]?.department?.name}}</td>
          </tr>
          <tr>
              
              <td>{{review_team[3]?.name}}</td>
              <td>{{review_team[3]?.department.name}}</td>


              <td colspan="6"></td>
              
              <td colspan="7"></td>
              
              <td>{{commercial_evaluation_committee[3]?.name}}</td>
              <td>{{commercial_evaluation_committee[3]?.department?.name}}</td>
              
          </tr>
          <tr>
               <td>{{review_team[4]?.name}}</td>
               <td>{{review_team[4]?.department.name}}</td>

              <td colspan="6" class="background">Contracting strategy:</td>
             
              <td colspan="7"> <input type="text" @change="addEditItem" class="form-control" v-model="formData.st14" placeholder=""></td>
              
              <td>{{commercial_evaluation_committee[4]?.name}}</td>
              <td>{{commercial_evaluation_committee[4]?.department?.name}}</td>
          </tr>
          <tr>
              <td>{{review_team[5]?.name}}</td>
              <td>{{review_team[5]?.department.name}}</td>

              <td colspan="6"></td>
              <td colspan="7"></td>
           
              
              <td colspan="2" class="background">Negotiation Team</td>
          </tr>
          <tr>
               <td>{{review_team[6]?.name}}</td>
               <td>{{review_team[6]?.department.name}}</td>

              <td colspan="6"></td>
            
              <td colspan="7"></td>
          
              <td>{{nogotiation_team[0]?.name}}</td>
              <td>{{nogotiation_team[0]?.department?.name}}</td>
          </tr>
          <tr>
              <td></td>
              <td></td>
              <td colspan="6" class="background"> Other comments:</td>
              
              <td colspan="7"><input type="text" @change="addEditItem" class="form-control" v-model="formData.comment" placeholder="Other Comments"/></td>
             
              <td>{{nogotiation_team[1]?.name}}</td>
              <td>{{nogotiation_team[1]?.department?.name}}</td>
          </tr>
          <tr>
              <td></td>
              <td></td>
              <td colspan="6" class="background">Negotiation Process</td>
              
              <td colspan="7"><input type="text" @change="addEditItem" class="form-control" v-model="formData.st21" placeholder="Negotiation Process "></td>
              
              <td>{{nogotiation_team[2]?.name}}</td>
              <td>{{nogotiation_team[2]?.department?.name}}</td>
          </tr>
          <tr>
              <td></td>
              <td></td>
              <td colspan="6" class="background">Cost Reduction Strategy (Alternative options)</td>
              
              <td colspan="7"><input @change="addEditItem" type="text" class="form-control" v-model="formData.st15" placeholder=""></td>
             
             <td>{{nogotiation_team[3]?.name}}</td>
              <td>{{nogotiation_team[3]?.department?.name}}</td>
          </tr>

          

          <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td colspan="7"></td>
            
              <td colspan="2">By TPC Team</td>
          </tr>
          <tr>
              <td colspan="17">PRELIMINARY PROCUREMENT TIMEFRAME</td>  
          </tr>
          <tr class="background">
            <td colspan="2">Milestone</td>
            <td v-for="(milestone, index) in milestones" :key="index" colspan="2">{{ milestone }}</td>
          </tr>
           <tr>
          <td colspan="2" class="background">Start Date</td>
          <td colspan="2">
            <input type="date" @change="addEditItem" v-model="formData.startDate" class="form-control" />
          </td>
          <td v-for="(d, index) in formData.days.slice(1)" :key="'date-' + index" colspan="2">
            {{ calculatedDates[index] }}
          </td>
        </tr>
      <tr>
        <td colspan="2" class="background">Working Days</td>
        <td v-for="(day, index) in formData.days" :key="'day-' + index" colspan="2">
          <input @change="addEditItem" type="number" class="form-control" v-model.number="formData.days[index]" min="0" />
        </td>
      </tr>
          <tr>
              <td colspan="14"></td>
              
           
              <td colspan="3">Total working Days:</td>
          </tr>



          



      <!-- <td :colspan="18/ItemsUsersApproval.length" class="label_text text-center" v-for="(user,index) in ItemsUsersApproval" :key="user.id">{{user.name}}<br>{{user.position}}</td>
       </tr>

       <tr>
           <td :colspan="18/ItemsUsersApproval.length" class="label_text text-center" v-for="(user,index) in ItemsUsersApproval" :key="user.id"><input type="text" class="form-control" v-model="formData['app' + user.id]" />________________</td>
           
       </tr> -->



        </table>
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
            RfpObject : null,
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
                

                startDate: '2024-11-17',
                days: [0, 0, 0, 0, 0, 0, 0,0],
                st14: null,
                comment: null,

                st21:'Negotiations will be initiated with lowest price, highest Techno-Commercial Scored bidders', 
                st15:'Objectives for the negotiation shall determine (but not limited to):A detailed negotiation mechanism shall be developed by Procurement department based on outcome of bid evaluation.',
                st8:'The key objective of the project is to provide services which include but not limited to assessment, design (Sliding door & Air curtains) & replacement of the existing auto sliding door, Installation, Integrate, Testing & Commissioning at KFIA Dammam Airport. The contractor must ensure the new system meets all relevant building codes, accessibility standards, and airport security requirements. The supplier is also responsible for evaluating the site conditions, such as existing infrastructure, power supply, and environmental factors, to inform the design of the new system. The key objectives for replacement of auto sliding doors at Passenger Terminal Building (PTB) including air curtain would be as mentioned below points, - Site Survey and Design of New Vestibules- Dismantling of Existing Doors & Air blowers- Construction of New Vestibules- Supply And Installation of Air Curtains- Supply And Installation of New Auto Sliding doors- Integration with Building Systems- Testing and Commissioning- As built Drawings Submission',
            },
 
            itemsDepartments:[],
            itemsUsersDefualt:[],
            itemsAllSteps:[],


            selectedValues:{},

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


            technical_commite: [],
            commercial_evaluation_committee:[],
            nogotiation_team:[],
            review_team:[],
            itemsBiddersVendor:[],

        };
    },  


    mounted() {
       let rfp = JSON.parse(localStorage.getItem('RFPBuyer'));
        this.rfp_id = rfp.id
        this.fetchItemsRFPObject()
      
      this.fetchItemsDepartments()
      this.fetchItemsUsers()
      this.fetchItemsBiddersVendor()
      // this.fetchItems()
      this.ItemsUsersApproval.forEach(user => {
        this.$set(this.formData, 'app' + user.id, '');
      });

    },

    computed: {
          locale() {
              return this.$route.params.locale;
          },

          calculatedDates() {
              let result = [];
              let current = this.formData.startDate ? new Date(this.formData.startDate) : null;

              for (let i = 0; i < this.formData.days.length; i++) {
                if (!current || !this.formData.days[i]) {
                  result.push('');
                  continue;
                }

                current = new Date(current); // clone current
                current.setDate(current.getDate() + this.formData.days[i]);
                result.push(current.toISOString().split('T')[0]);
              }

              return result;
          },

          
        
    },
   
    methods: {

    


      async fetchItemsRFPObject() {
 
          this.isLoading = true;

            await axios.get('RFPStep/getById', {
                params: {
                  ID:this.rfp_id,
                }
              })
                .then(response => { 
                    this.RfpObject = response.data.items;
                    this.formData = JSON.parse(this.RfpObject.data_json_tps);
                  
                    this.fetchItems();
                 
                })
                .catch(error => {
                   this.swalFunction('error','Error Happens 77')
                   this.isLoading = false;

                }); 
     
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



        checkOne(check) {
            if (check === 1) {
              return "Yes";
            } else if (check === 0) {
              return "No";
            }
            return "-";
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


        async fetchItemsBiddersVendor() {
          this.isLoading = true;
            await axios.get('BuyerApprove/getAllItemsResponseVendorInvited', {
                params: {
                  rfp_id: this.rfp_id,
                }
              }).then(response => {
                    this.itemsBiddersVendor = response.data.items;
                    this.isLoading = false;
                }).catch(error => {
                   this.swalFunction('error',error)
            

                   this.isLoading = false;
                });
        },
 


        async fetchItems() {
          this.technical_commite = JSON.parse(this.RfpObject.technical_commite)
          this.commercial_evaluation_committee = JSON.parse(this.RfpObject.commercial_commite)
          this.nogotiation_team = JSON.parse(this.RfpObject.nogotiation_team)
          this.review_team = JSON.parse(this.RfpObject.review_team)




          // const names = data.map(user => user.name);
          // console.log(names); 

          // const itUsers = data.filter(user => user.department_name === "IT");
          // console.log(itUsers);


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



                })
                .catch(error => {
                  
                  this.swalFunction('error','Error Happens 55')

                   this.isLoading = false;
                });
        },
 

      closeModal(){
          $('#kt_modal_add_item').modal('hide');
      },




       addEditItem() {

          this.isLoading = true;
          this.formData.rfp_id = this.RfpObject.id;

          axios.post('BuyerTps/createTPSData',this.formData).then((response)=>{
              this.isLoading = false;
              if(response.data.items){
                this.fetchItemsRFPObject()
                  // this.swalFunction('success','Doing Success')
              }else{
                 this.swalFunction('error',response.data.message)
              }             
            
            }).catch(error => {
                this.isLoading = false;
                this.swalFunction('error',error)
            });
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
</style>

