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
              <td colspan="7">Technical Evaluation Sheet</td>
              
              <td colspan="3" style="color: red;">Title:</td>
              <td colspan="7" style="color: red;"><input class="form-control" type="text" v-model="formData.st4Title"></td>
           
              <td colspan="2">Date: </td>
              <td colspan="2"><input class="form-control" type="date" v-model="formData.st4d"></td>
          </tr>
          <tr>
              <td colspan="7" rowspan="2" class="background2">Criteria</td>
              <td rowspan="2" colspan="3" class="background2">TE Pre-Set Conditions</td>
              <td  rowspan="2" class="background2">Pre-Set Score</td>
              <td  rowspan="2" class="background2">Total Score</td>
              <td  rowspan="2" class="background2" >Critical<br>Non-Critical</td>
              
              <td colspan="2" class="background3">BIDDER No. 1<br></td>
              <td colspan="2" class="background3">BIDDER No. 2<br></td>
              <td colspan="2" class="background3">BIDDER No. 3<br></td>
              <td colspan="2" class="background3">BIDDER No. 4<br></td>
          </tr>
          <tr>
           
              <td class="background4">Scores</td>
              <td class="background4">Jutifications</td>
              <td class="background4">Scores</td>
              <td class="background4">Jutifications</td>
              <td class="background4">Scores</td>
              <td class="background4">Jutifications</td>
              <td class="background4">Scores</td>
              <td class="background4">Jutifications</td>
          </tr>
          <template v-for="(criterion, criterionIndex) in ItemsTECriteria" :key="criterion.id">
          

          <tr class="background5" >
              <td>{{ criterionIndex + 1 }}.0</td>
              <td colspan="6">{{ criterion.name }}</td>
              
          
              <td colspan="3">Pre-Set Conditions</td>
              <td></td>              
              <td></td>              
              <td></td>              
              <td colspan="8"></td>
             
          </tr>

          <tr v-if="criterion.features" class="background6" v-for="(feature, featureIndex) in criterion.features" :key="feature.id">
              <td>{{ criterionIndex + 1 }}.{{ featureIndex + 1 }}</td>
              <td colspan="6">{{ feature.title }}</td>
              
             <td colspan="3">
                <span
                  v-for="(val, i) in feature.features_value"
                  :key="val.id || i"
                >
                  {{ val.name }} = {{ val.value }}<br />
                </span>
              </td>

              <td>
                {{
                  Math.max(
                    ...feature.features_value.map((f) => parseFloat(f.value || 0))
                  )
                }}
              </td>

              <td
                v-if="featureIndex === 0"
                :rowspan="criterion.features.length "
              >
                {{
                  criterion.features.reduce((acc, f) => {
                    const max = Math.max(
                      ...f.features_value.map((v) => parseFloat(v.value || 0))
                    );
                    return acc + (isFinite(max) ? max : 0);
                  }, 0)
                }}
              </td> 

              <td v-if="criterion.features.length > 1" :rowspan="criterion.features.length - 1" >
                      {{ feature.critiera }}
              </td>

               <td v-else :rowspan="criterion.features.length" >
                      {{ feature.critiera }}
              </td>
             

             <td v-for="b in 8" :key="b">
                <input
                  type="text"
                  class="form-control"
                  v-model="formData[`st4_${getRowIndex(criterionIndex, featureIndex)}_${b - 1}`]"
                  style="background: white;"
                />
              </td>

             
          </tr>


       
         
          </template>

          <tr>
              <td colspan="10">Total Score:</td>
              
              <td> Total Score</td>
              <td colspan="2">{{ totalScore }}</td>

<!-- <td colspan="2" v-for="(score, i) in bidderTotalScores" :key="`score-${i}`">
  {{ score }}
</td> -->

<!-- عرض Passed أو 0 لكل Bidder -->
<td v-for="(status, i) in biddersPassed" :key="`status-${i}`">
  {{ status }}
</td>
          </tr>


          <tr>
              <td colspan="10">Passing Score:</td>
              
              <td> total score</td>
              <td colspan="2">70.00</td>
             
            
          </tr>


      
          <tr>
              <td colspan="13">Total Evaluated Score:</td>
              
          </tr>


          <tr>
            <td colspan="21" ></td>
          </tr>


           <tr>
              <td colspan="21" class="background">PART 2: Bid Opening Personnel </td>
             
          </tr>
          <tr>
              <td colspan="10"> Name  </td>
              
              <td colspan="7">Department</td>
             
              <td colspan="4">Signature  </td>
             
          </tr>
         
            <tr v-for="i in 9" :key="i">
                <td colspan="10">
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

                <td colspan="7">
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

                <td colspan="4"><input type="text" class="form-control" v-model="formData[`TS${i}`]"></td>
              </tr>
 
              

        
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
                st4d:'',
                st4Title:'',
                
                step: 4,

                R41:'',
                R42:'',
                R43:'',
                R44:'',
                R45:'',
                R46:'',
                R47:'',
                R48:'',
                R49:'',


                R1:'',
                R2:'',
                R3:'',
                R4:'',
                R5:'',
                R6:'',
                R7:'',
                R8:'',
                R9:'',
                
                Ts1:'',
                Ts2:'',
                Ts3:'',
                Ts4:'',
                Ts5:'',
                Ts6:'',
                Ts7:'',
                Ts8:'',
                Ts9:'',
               

           
            },
 
            itemsDepartments:[],
            itemsUsersDefualt:[],
            itemsAllSteps:[],
            ItemsTECriteria:[],


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
   
      if (!this.formData.st4d || this.formData.st4d == null) {
        const d = new Date();
        this.formData.st4d = d.toISOString().split('T')[0];
      }

      

        this.ItemsUsersApproval.forEach(user => {
          this.$set(this.formData.st3, user.id, '');
        });





    },

    computed: {
          locale() {
              return this.$route.params.locale;
          },


          bidderInputs() {
            return Array.from({ length: 8 }, (_, i) => this.formData[`st4${i}`] || '');
          },


          totalScore() {
            if (!this.ItemsTECriteria) return 0;

            return this.ItemsTECriteria.reduce((criteriaSum, criterion) => {
              const featureSum = (criterion.features || []).reduce((sum, feature) => {
                const max = Math.max(...(feature.features_value || []).map(v => parseFloat(v.value || 0)));
                return sum + (isFinite(max) ? max : 0);
              }, 0);
              return criteriaSum + featureSum;
            }, 0).toFixed(2); // ترجع المجموع النهائي بصيغة رقم عشري مثل 87.50
          },
         

  bidderTotalScores() {
    const numBidders = 8;
    const totals = Array(numBidders).fill(0);

    const totalRows = this.ItemsTECriteria.reduce((acc, criterion) => {
      return acc + (criterion.features?.length || 0);
    }, 0);

    for (let row = 0; row < totalRows; row++) {
      for (let col = 0; col < numBidders; col++) {
        const key = `st4_${row}_${col}`;
        const val = parseFloat(this.formData[key]) || 0;
        totals[col] += val;
      }
    }

    return totals.map(t => t.toFixed(2));
  },

  passingScore() {
    return 70;
  },

  biddersPassed() {
    return this.bidderTotalScores.map(score =>
      parseFloat(score) >= this.passingScore ? "passed" : "0"
    );
  }


         
    },
   
    methods: {

    getRowIndex(criterionIndex, featureIndex) {
    let index = 0;
    for (let i = 0; i < criterionIndex; i++) {
      index += this.ItemsTECriteria[i].features?.length || 0;
    }
    return index + featureIndex;
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
                    this.ItemsTECriteria = this.items.filter(item => item.type && item.type.name === "te-criteria");
                    console.log(this.ItemsTECriteria)
                    this.isLoading = false;

                    console.log(this.ItemsTECriteria)

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



                            if (data.st5 && this.formData.st5 != '') {
                              this.formData.st4Title =  data.st5;
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


.background2{

  background: #babfe1 !important;
/*  color: #FFF;*/
}



.background3{

  background: #fef2cb !important;
  color: red !important;
}


.background4{

  background: #cbcbcb !important;
/*  color: red !important;*/
}

.background5{
  background: #00b0f0;
}

.background6{
  background: #d8d8d8;
}




.multiselect__select{
  display: none;
}

/*.table > :not(caption) > * > * {
     padding: 0rem 0rem
    }*/
</style>

