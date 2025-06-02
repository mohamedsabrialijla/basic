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
      <table class="table table-bordered table-striped align-middle table excel-like-table"
        v-if="ItemsCriteria.length > 0 && ItemsVendors.length > 0 ">

       <tr>
           <td class="label_text" colspan="2">SOI RECORDS</td>
          
           <td class="label_text" >Vendors Reached </td>
           <td class="label_text" >Vendors Responded </td>
           <td class="label_text" >Vendors Passed</td>
           <td class="label_text" >Vendors Faild</td>
           <td class="label_text">Vendors Declined</td>
           <td class="label_text" >Vendors Invited</td>
           <td></td>
           <td></td>
        
         
       </tr>
       <tr>
            <td class="label_text" colspan="2"></td>
           <td ><input type="text" class="form-control" v-model="formData.st1" /></td>
           <td ><input type="text" class="form-control" v-model="formData.st2" /></td>
           <td ><input type="text" class="form-control" v-model="formData.st3" /></td>
           <td ><input type="text" class="form-control" v-model="formData.st4" /></td>
           <td ><input type="text" class="form-control" v-model="formData.st10" /></td>
           <td ><input type="text" class="form-control" v-model="formData.st11" /></td>
          
          <td></td>
          <td></td>
          
        
       </tr>
      
       <tr>
           
       
          
           <td colspan="11" class="label_text">Vendor SOI (Solicitation Of Interest)</td>
           
         
         
       </tr>
       <tr>
           <td class="label_text" >Project Title: </td>
           <td colspan="3"><input type="text" class="form-control" v-model="formData.st5" /></td>
           

           <td class="label_text" >Scope Overview: </td>
           <td colspan="3"><input type="text" class="form-control" v-model="formData.st20" /></td>
           
    
           <td class="label_text">Date:</td>
           
           <td colspan="3"><input type="date" class="form-control" v-model="formData.st6" /></td>
        
       </tr>
       <tr>
           <td></td>
           
           <td></td>
           
           <td colspan="14" class="label_text text-center">Vendors</td>
           
         
          
       </tr>
       <tr>
           <td class="label_text">S.N</td>
           <td class="label_text">SOI Criteria&#39;s</td>
           <td v-for="(vendor,index) in ItemsVendors" :key="vendor.id">{{vendor.name}}</td>
           <!-- <td></td> -->
           
          
       </tr>
       <tr v-for="(critiera,index) in ItemsCriteria" :key="critiera.id" >
           <td class="label_text">{{index+1}}</td>
           <td>{{critiera.name}}</td>
           <td v-for="(vendor,index) in ItemsVendors" :key="vendor.id" >
              
               <div class="form-check form-check-custom form-check-success form-check-solid">
                   <input v-if="ItemsCriteria.length > 0 && ItemsVendors.length > 0 "  v-model="formData.selectedValues[critiera.id][vendor.id]" class="form-check-input" type="checkbox" value="" checked />
                   <label class="form-check-label" for="">
                       Yes
                   </label>
               </div>

           </td>
          
           <!-- <td v-if="index == ItemsCriteria.length - 1">Declined to participate</td>
           <td v-else></td> -->
          
           
       </tr>
     
       <tr>
           <td>Remarks</td>
           <td></td>
           <td>Confirmed by SOI email to participate</td>
           <td>Confirmed by SOI email to participate</td>
           <td>Confirmed by SOI email to participate</td>
           <td>Confirmed by SOI email to participate</td>
           <td>Confirmed by SOI email to participate</td>
           <td>Confirmed by SOI email to participate</td>
           <td>Confirmed by SOI email to participate</td>
           <td>Confirmed by SOI email to participate</td>
           <!-- <td>Declined to participate due to Commitement with other clients and Lack of Resources</td> -->
           
       </tr>
       <tr>
          
           <td colspan="11" class="text-center label_text">DISCLAIMER:<br>The SOI cannot be changed once signed completely which means any addition or removal of the vendors is not allowed.</td>
           
       
        
       </tr>


       <tr>
         
           <td colspan="11" class="text-center label_text"></td>
           
       
        
       </tr>

       <tr>
           <td colspan="4" class="label_text text-center" v-for="(user,index) in ItemsUsers" :key="user.id">{{user.name}}<br>{{user.position}}</td>
       </tr>

       <tr>
           <td colspan="4" class="label_text text-center"><input type="text" class="form-control" v-model="formData.st7" />________________</td>
           <td colspan="4" class="label_text text-center"><input type="text" class="form-control" v-model="formData.st8" />________________</td>
           <td colspan="4" class="label_text text-center"><input type="text" class="form-control" v-model="formData.st9" />________________</td>
      
          
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
            ItemsUsers:[],
            formData: {
                selectedValues:{},
                st1: '',
                st2: '',
                st3: '',
                st4: '',
                st5: '',
                st6: '',
                st7: '',
                st8: '',
                st9: '',
                st10: '',
                st11: '',
                step: 1,
            },


            selectedValues:{},

            logo:'',

            
            ItemID: null,
            URL:'ItemsObjects/createItem',

            itemStep:{},
            isTableReady: false,

        };
    },  


    mounted() {
       
        this.fetchItems();

         if (!this.formData.st6 || this.formData.st6 == null) {
                const d = new Date();
                this.formData.st6 = d.toISOString().split('T')[0];
              }

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

                        this.ItemsUsers = this.itemStep.users;
                    }

                     this.formData.selectedValues = {};

                     this.ItemsCriteria.forEach(criterion => {
                       this.formData.selectedValues[criterion.id] = {};

                       this.ItemsVendors.forEach(vendor => {
                         this.formData.selectedValues[criterion.id][vendor.id] = true;
                       });
                     });



                     console.log(this.myData)
                     
                    let parsedData = {};


                    if(this.myData.data_json){
                    if (typeof this.myData.data_json === 'string') {
                      parsedData = JSON.parse(this.myData.data_json);
                    } else if (typeof this.myData.data_json === 'object') {
                      parsedData = this.myData.data_json;
                    }

                    this.formData = parsedData;

                }


                })
                .catch(error => {
                  console.log(error)
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
watch: {
  'formData.st6': {
    immediate: true,
    handler(val) {
      if (!val) {
        const d = new Date();
        this.formData.st6 = d.toISOString().split('T')[0]; // YYYY-MM-DD
      }
    }
  }
}

 

 
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

</style>

