<template>
           
    <div>
        
        <Step_1 v-if="showStep1" :myData="myData" />
        <Step_2 v-if="showStep2" :myData="myData" />
        <Step_3 v-if="showStep3" :myData="myData" />
        <Step_4 v-if="showStep4" :myData="myData" />
        <Step_5 v-if="showStep5" :myData="myData" />

    </div>

     
             
</template>

<script>


import axios from 'axios';
import { mapState } from 'vuex';
import Multiselect from 'vue-multiselect'
import Step_1 from './Step_1.vue';
import Step_2 from './Step_2.vue';
import Step_3 from './Step_3.vue';
import Step_4 from './Step_4.vue';
import Step_5 from './Step_5.vue';


 
export default {
  

  components: {
    Multiselect,
    Step_1,
    Step_2,
    Step_3,
    Step_4,
    Step_5,

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
            searchQuery: '',



            logo:'',

            
            ItemID: null,
       
            step: null ,
            showStep1:false,
            showStep2:false,
            showStep3:false,
            showStep4:false,
            showStep5:false,

            myData:{},



        };
    },


    mounted() {
      const raw = localStorage.getItem('itemStep');
      if (raw) {
        this.itemStep = JSON.parse(raw); // 👈 تحليل البيانات
        

        if (this.itemStep.slug === 'soi') {
          this.showStep1 = true;
          this.step = 1 ;
          this.getItemByIdTest();

        }else if(this.itemStep.slug === 'tps-internal'){
          this.showStep2 = true;
          this.step = 2 ;
          this.getItemByIdTest();

        }else if(this.itemStep.slug === 'bid-box-opening-technical'){
          this.showStep3 = true;
          this.step = 3 ;
          this.getItemByIdTest();

        }else if(this.itemStep.slug === 'technical-sheet-resulte'){
          this.showStep4 = true;
          this.step = 4 ;
          this.getItemByIdTest();

        }else if(this.itemStep.slug === 'bid-box-commerical-technical'){
          this.showStep5 = true;
          this.step = 5 ;
          this.getItemByIdTest();

        }



      }
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
 


         async getItemByIdTest(){

            let project_id = localStorage.getItem('ProjectID') ;

            axios.get('Steps/getById', { params: { project_id: project_id , step : this.step  } }).then(response => {
                if(response.data){
                  let data = response.data.items

                    if (typeof data === 'string') {
                      this.myData = JSON.parse(data); // إذا كانت نص JSON، حولها
                    } else if (typeof data === 'object') {
                      this.myData = data; // إذا كانت كائن جاهز، استخدمها مباشرة
                    }

                  

                }else{
                    this.swalFunction('error','Errors Happens 1')
                }
            }).catch((error)=>{
                    console.log(error)
                    this.swalFunction('error','Errors Happens 2')      
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

