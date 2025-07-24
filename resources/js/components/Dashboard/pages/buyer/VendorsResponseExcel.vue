<template>
  <div class="card">
    <div class="row" style="margin-top:60px;">
      

  
  <div class="documents-list">
    <div class="table-responsive">
      

      <table class="table table-bordered table-striped align-middle table excel-like-table"
       v-if="ItemsCriteria.length > 0 && ItemsVendors.length > 0">

  <!-- Header معلومات عامة -->
  <tr>
    <td class="label_text" colspan="2" rowspan="2">SOI RECORDS</td>
    <td class="label_text">Vendors Reached</td>
    <td class="label_text">Vendors Responded</td>
    <td class="label_text">Vendors Passed</td>
    <td class="label_text">Vendors Failed</td>
    <td class="label_text">Vendors Declined</td>
    <td class="label_text">Vendors Invited</td>
    <td colspan="2" rowspan="2"></td>
  </tr>

  <tr>
    <td class="bb">{{staticitics.rashed}}</td>
    <td class="bb">{{staticitics.response}}</td>
    <td class="bb">{{staticitics.passed}}</td>
    <td class="bb">{{staticitics.fail}}</td>
    <td class="bb">{{staticitics.decline}}</td>
    <td class="bb">{{staticitics.invited}}</td>
    
  </tr>

  <tr>
    <td class="label_text" colspan="3">Project Title: </td>
    <td colspan="7">{{ object.name }}</td>
  </tr>

  <tr>
    <td></td>
    <td></td>
    <td colspan="14" class="label_text text-center">Vendors</td>
  </tr>

  <tr>
    <td class="label_text">S.N</td>
    <td class="label_text">SOI Criteria</td>
    <td v-for="(vendor, index) in ItemsVendors" :key="vendor.id">{{ vendor.name }}</td>
  </tr>

  <!-- جدول الـ criteria -->
  <tr v-for="(row, rowIndex) in ItemsCriteria" :key="row.id">
    <td class="label_text">{{ rowIndex + 1 }}</td>
    <td>{{ row.name }}</td>
    <td v-for="vendor in ItemsVendors" :key="vendor.id">
      <div class="form-check form-switch form-check-custom form-check-success form-check-solid">
        <input v-if="formData[row.id]"
          class="form-check-input"
          type="checkbox"
          :id="`switch_${row.id}_${vendor.id}`"
          style="cursor:pointer;"
          v-model="formData[row.id][vendor.id]"
          :true-value="'YES'"
          :false-value="'NO'"
          @change="saveResponseAuto(row.id, vendor.id, formData[row.id][vendor.id])"
        >
        <label class="form-check-label" :for="`switch_${row.id}_${vendor.id}`">
          {{ formData[row.id][vendor.id] === 'YES' ? 'Yes' : 'No' }}
        </label>
      </div>
    </td>
  </tr>

  <!-- تأكيد الاستجابة -->
  <tr>
    <td colspan="2">Response Confirm/Decline</td>
    <td v-for="vendor in ItemsVendors" :key="'confirm_' + vendor.id">Confirmed</td>
  </tr>

</table>




   </div>

  </div>

    

        
    </div>

    


  </div>

</template>





<script>



import axios from 'axios';
import { mapState } from 'vuex';

 
import { nextTick } from 'vue';

 
export default {
  components: {
    
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
            ItemsVendors:[],
            ItemsCriteria:[],
          

            sections:[],
            object:[],


            tables: [],
            formData: {},
            responses:[],

            staticitics:null,

        };
    },



 

   mounted() {
        this.fetchItems(); 
        this.loadAllDataInOrder();
        this.fetchItemsStaticitics()



       
    }, 

    computed: {
      locale() {
              return this.$route.params.locale;
          },

    },



  methods: {

async loadAllDataInOrder() {
    await this.fetchItemsBase();     // ← ننتظر انتهاء تحميل الفندور والـ criteria
    await this.fetchItemsResponse(); // ← بعدين نحمل responses ونبني الفورم
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
 

    

    initializeFormData() {


    this.ItemsCriteria.forEach(criterion => {
    this.formData[criterion.id] = {};
      this.ItemsVendors.forEach(vendor => {
        const existing = this.responses.find(r =>
          r.criteria_id === criterion.id &&
          r.vendor_id === vendor.id
        );
                  
        this.formData[criterion.id][vendor.id] = existing ? existing.response : 'NO';
      });
    });
  },



    



     async fetchItems() {
      let rfp_id = JSON.parse(localStorage.getItem('RFPReview'));
      this.object = rfp_id
        this.isLoading = true;
          await axios.get('BuyerApprove/excelResponse', {
              params: {
                rfp_id: rfp_id.id,
              }
            })
              .then(response => {
                  this.tables = response.data.items;
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


      async fetchItemsBase() {
          this.isLoading = true;
             await axios.get('ItemsCategories/getAllItems', {
                params: {
                  pagination: 0,
                }
              })
                .then(response => {
                    this.items = response.data.items;
                    let rfp_id = JSON.parse(localStorage.getItem('RFPReview'));
                    this.ItemsVendors = JSON.parse(rfp_id.vendors);
                    this.ItemsCriteria = this.items.filter(item => item.type && item.type.name === "criteria");
                   
                    this.isLoading = false;

                })
                .catch(error => {
                  this.swalFunction('error','Error Happens 55')

                   this.isLoading = false;
                });
        },



     async fetchItemsResponse() {
      let rfp_id = JSON.parse(localStorage.getItem('RFPReview'));
      this.object = rfp_id
        this.isLoading = true;
          await axios.get('BuyerApprove/getAllItemsResponseVendor', {
              params: {
                rfp_id: rfp_id.id,
              }
            })
              .then(response => {
                  this.responses  = response.data.items;

                  this.isLoading = false;
                  this.initializeFormData();


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


      saveResponseAuto(criteria_id, vendor_id, value) {

        let rfp_id = JSON.parse(localStorage.getItem('RFPReview'));
        const payload = {
          rfp_id: rfp_id.id,
          criteria_id: criteria_id,
          vendor_id: vendor_id,
          response: value
        };

        axios.post('BuyerApprove/Store', payload)
          .then(response => {
            this.swalFunction('success', 'saved successfully');
          })
          .catch(error => {
            console.error("فشل الحفظ ❌", error);
          });
      
      },



      async fetchItemsStaticitics() {
      let rfp_id = JSON.parse(localStorage.getItem('RFPReview'));
      this.object = rfp_id
        this.isLoading = true;
          await axios.get('BuyerApprove/getAllItemsStaticitics', {
              params: {
                rfp_id: rfp_id.id,
                type: 'vendorTeam',
              }
            })
              .then(response => {
                  this.staticitics  = response.data.items;
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


.documents-list {
  max-width: 800px;
  margin: auto;
}
.document-item img {
  max-width: 100%;
  height: auto;
  display: block;
}

.bb{
  background: #f7f3f3;
}






</style>
