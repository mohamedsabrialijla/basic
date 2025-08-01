<template>
           
 <!--begin::Post-->
  <div class="content flex-column-fluid" id="kt_content">
    <!--begin::Card-->
    <div class="card">
     
      <div class="card-body py-4" style="padding: 0px;">
        <!--begin::Table-->
        <div v-if="isLoading">
          please wait ...
        </div>
        
          <button @click="getModalCreate()" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#kt_modal_add_item">
            <i class="ki-duotone ki-plus fs-2"></i>Add New
          </button>
 
   
 
      <div class="table-responsive" style="margin-top: 20px;">
        
        <table class="table table-bordered table-striped excel-like-table">
      
          <tr>
              <td colspan="7" rowspan="2" class="background2">Criteria</td>
              <td rowspan="2" colspan="3" class="background2">TE Pre-Set Conditions</td>
              <td  rowspan="2" class="background2">Pre-Set Score</td>
              <td  rowspan="2" class="background2">Total Score</td>
              <td  rowspan="2" class="background2" >Critical<br>Non-Critical</td>
              <td  rowspan="2" class="background2" >Actions</td>
              
          </tr>
          <br/>
          
          <template v-for="(criterion, criterionIndex) in ItemsTECriteria" :key="criterion.id">
          

          <tr class="background5" >
              <td>{{ criterionIndex + 1 }}.0</td>
              <td colspan="6">{{ criterion.name }}</td>
              
          
              <td colspan="3">Pre-Set Conditions</td>
              <td colspan="3"></td>    
              <td style="background: white ;">

                <div class="d-flex flex-center rounded  mb-1 overlay">
                <div class="overlay-wrapper text-gray-600">
                    <i @click="getModalEdit(criterion)" class="ki-duotone ki-notepad-edit fs-2x"><span class="path1"></span><span class="path2"></span></i>
                  </div>

                  


                  <div class="overlay-wrapper text-gray-600">
                    <i @click="deleteItem(criterion.id)" class="ki-duotone ki-trash-square fs-2x">
                     <span class="path1"></span>
                     <span class="path2"></span>
                     <span class="path3"></span>
                     <span class="path4"></span>
                    </i>
                  </div>
                      
            </div> 
              </td>          
                    
             
          </tr>

          <tr v-if="criterion.features"  v-for="(feature, featureIndex) in criterion.features" :key="feature.id">
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
             

          
             
          </tr>


       
         
          </template>

          <tr>
              <td colspan="10">Total Score:</td>
              
              <td> Total Score</td>
              <td colspan="2">{{ totalScore }}</td>

         
          
          </tr>


          <tr>
              <td colspan="10">Passing Score:</td>
              
              <td> total score</td>
              <td colspan="2">{{object.techinical_passing_score}}</td>
             
            
          </tr>


        
       
        
          
         
           

        
        </table>

      </div>




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
                <div class="btn btn-icon btn-sm btn-active-light-info ms-2" data-bs-dismiss="modal" aria-label="Close">
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
 
 




              <div class="fv-row mb-7" >
                <label class="required fw-semibold fs-6 mb-2" > Order</label>
                <input type="number" :name="order" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Order " value="" v-model="formData.order"   required />
              </div>





            <div class="card p-5">
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
                    <a class="btn btn-light-info d-flex align-items-center gap-2" v-if="index === formEntries.length - 1" @click="addNewEntry" style="width: 55px;">
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
          <button type="submit" class="btn btn-info" @click.prevent="addEditItem" :disabled="isLoading">
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


             formEntries: [
              { title: '', features: [], features_value: [] , critiera : null},
            ],

           
            features: [
               
              ],

            features_value: [
                
              ],
            object:{},


        };
    },  


    mounted() {
       
      // this.fetchItemsAllSteps()
      this.getItemsWithdrowFromMaster();
      this.fetchItems()
      this.fetchItemCretiria()
      this.fetchItemsDepartments()
      this.fetchItemsUsers()
   
      if (!this.formData.st4d || this.formData.st4d == null) {
        const d = new Date();
        this.formData.st4d = d.toISOString().split('T')[0];
      }

      

        this.ItemsUsersApproval.forEach(user => {
          this.$set(this.formData.st3, user.id, '');
        });


        this.object = JSON.parse(localStorage.getItem("object_rfp"));



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




      resetItem(){
          this.formData =  {
                code: '',
                order: '',
            }
        },


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
        },


      

        closeModal(){
            $('#kt_modal_add_item').modal('hide');
            this.URL = 'ItemsCategories/createItem'
            this.ItemID = null
        },



        async getItemById(){
            axios.get('ItemsTechnicals/getById', { params: { ID: this.ItemID } }).then(response => {
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
                            confirmButton: "btn btn-info"
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


        async getItemsWithdrowFromMaster(){

            let rfp_id = JSON.parse(localStorage.getItem('RFPItem'));

            axios.get('ItemsTechnicals/Withdrow', { params: { ID: rfp_id.id } }).then(response => {
                if(response.data.code == 200){
                  let data = response.data.items

                  this.ItemsTECriteria = data;
                 
                }else{
                    return false;
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
              confirmButton: "btn btn-info",
              denyButton: "btn btn-light-danger"
            }
          }).then((result) => {
            if (result.isConfirmed) {
              // إذا تم تأكيد الحذف
              axios.delete(`ItemsTechnicals/deleteItem/${id}`)
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

         addEditItem() {

          
          this.isLoading = true;

           
            if(this.ItemID != ''){
               this.formData.Item_id = this.ItemID;
               this.urlTech = 'ItemsTechnicals/editItem' ;

            }else{
              this.urlTech = 'ItemsTechnicals/createItem' ;
            }



            if(this.formEntries){
              this.formData.forms = this.formEntries
            }

            

             
          axios.post(this.urlTech,this.formData).then((response)=>{
                 this.isLoading = false;
                if(response.data.items){
                  
                    this.closeModal()
                    this.fetchItemCretiria()           

                }else{
                    this.swalFunction('info','Error Happens Please try again.')
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




    // end te creitiria 

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
                    confirmButton: "btn btn-info"
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
                    confirmButton: "btn btn-info"
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
                    confirmButton: "btn btn-info"
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
                    // this.ItemsTECriteria = this.items.filter(item => item.type && item.type.name === "te-criteria");
                    this.isLoading = false;




                })
                .catch(error => {
                  
                  this.swalFunction('error','Error Happens 55')

                   this.isLoading = false;
                });
        },




        async fetchItemCretiria() {
          let rfp_id = JSON.parse(localStorage.getItem('RFPItem'));
          this.isLoading = true;
             await axios.get('ItemsTechnicals/getAllItems', {
                params: {
                  pagination: 0,
                  rfp_id: rfp_id.id,
                }
              })
                .then(response => {
                    this.ItemsTECriteria = response.data.items;
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
    text-align: left;
/*    vertical-align: middle;*/
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
  background: #7239EA;
}





.multiselect__select{
  display: none;
}

/*.table > :not(caption) > * > * {
     padding: 0rem 0rem
    }*/
</style>

