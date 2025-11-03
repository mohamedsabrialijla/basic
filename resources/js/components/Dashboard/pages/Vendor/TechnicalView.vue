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
        
        <!--    <button @click="getModalCreate()" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_item">
            <i class="ki-duotone ki-plus fs-2"></i>Add New
          </button>
        -->
   
 
      <div class="table-responsive" style="margin-top: 20px;">
        
        <table class="table table-bordered table-striped excel-like-table">
      
          <tr>
              <td colspan="7" rowspan="2" class="background2">Criteria</td>
              <td  rowspan="2" class="background2" >Weightage %</td>
              <td  rowspan="2" class="background2" >Attatchment</td>
              <td  rowspan="2" class="background2" >Status</td>
              
          </tr>
          <br/>
          
          <template v-for="(criterion, criterionIndex) in ItemsTECriteria" :key="criterion.id">
          

          <tr class="background5" >
              <td>{{ criterionIndex + 1 }}.0</td>
              <td colspan="9">{{ criterion.name }}</td>
              
          
            
                    
             
          </tr>

          <tr v-if="criterion.features" class="background6" v-for="(feature, featureIndex) in criterion.features" :key="feature.id">
              <td>{{ criterionIndex + 1 }}.{{ featureIndex + 1 }}</td>
              <td colspan="6">{{ feature.title }}</td>
              
             <td >  {{ feature.features_value.reduce((sum, v) => sum + parseFloat(v.value || 0), 0) }}</td> 
             
             <td v-if="feature.file" >
               <i class="bi bi-file-earmark fs-2x"></i>
             </td> 
             <td v-else ><input type="file" @change="onFileChange($event, feature.id, criterion.id)" class="form-control" style="width: 54%;"></td> 
             


             <td v-if="feature.file"> <span class="badge badge-light-success" style="background-color: none;">Completed </span> </td> 
             <td v-else ><span class="badge badge-light-danger">Ready</span></td> 

          </tr>


       
         
          </template>

 
          <tr>
              <td colspan="8">Passing Score:</td>
              
              <!-- <td> total score</td> -->
              <td colspan="2">{{object?.techinical_passing_score}}</td>
             
            
          </tr>


        
       
        
          
         
           

        
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
            formData: {},
 
            itemsUsersDefualt:[],
            itemsAllSteps:[],
            ItemsTECriteria:[],
            logo:'',
            ItemID: null,
            URL:'ItemsObjects/createItem',
            itemStep:{},
            features: [],
            features_value: [],
            object:{},
            formDataDocument:[],
            file: '',



        };
    },  


    mounted() {
       
      this.fetchItems()
      this.fetchItemCretiria()
   
      this.object = JSON.parse(localStorage.getItem("object_rfp"));

    },


  watch: {
    user(newUser) {
      if (newUser) {
        setTimeout(() => {
        }, 500); // تأخير لمدة 500 ميلي ثانية
      }
    },
  }, 
    computed: {
          locale() {
              return this.$route.params.locale;
          },

          ...mapState(['user']),
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
           

      

          passingScore() {
            return 70;
          },

    
                 
    },
   
    methods: {


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
        let rfp_id = JSON.parse(localStorage.getItem('RFPReview'));
        this.isLoading = true;
           await axios.get('ItemsTechnicals/getAllItems', {
              params: {
                pagination: 0,
                rfp_id: rfp_id.id,
              }
            })
              .then(response => {
                  this.ItemsTECriteria = response.data.items;
                  console.log(this.ItemsTECriteria)
                  this.isLoading = false;




              })
              .catch(error => {
                
                this.swalFunction('error','Error Happens 55')

                 this.isLoading = false;
              });
      },



      onFileChange(e,feature_id,cretiria_id) {
        this.file = e.target.files[0];
            const file = e.target.files[0];
            if (file) {
                this.formDataDocument.file = URL.createObjectURL(file);
            }

            this.sendDocument(feature_id,cretiria_id, file);

        },


    


      sendDocument(feature_id,cretiria_id) {

        this.isLoading = true;

        const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

        let rfp_id = JSON.parse(localStorage.getItem('RFPReview'));
        let form = new FormData();

        form.append('rfp_id', rfp_id.id);
        form.append('feature_id', feature_id);
        form.append('cretiria_id', cretiria_id);
       
        if (this.file) {
          form.append('file', this.file);
        }
 
        axios.post('ItemsTechnicals/createItemDocument',form,config).then((response)=>{
            this.isLoading = false;
            if(response.data.items){
              this.fetchItemCretiria()
                this.swalFunction('success','uploaded Successfully')
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

.background6{
  background: #ffffff;
}




.multiselect__select{
  display: none;
}

/*.table > :not(caption) > * > * {
     padding: 0rem 0rem
    }*/
</style>

