<template>
  <div class="card">
    <div class="row" style="margin-top:60px;">
      

  
    <div class="documents-list">
    <div v-for="section in sections" :key="section.id" class="document-item mb-4 p-3 border rounded bg-light">
     
      
      <div  v-html="section.description"></div>
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
          

            sections:[],

        };
    },



 

   mounted() {
        this.fetchItemsSections()

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
 

    


    



     async fetchItemsSections(page,query = '') {
      let rfp_id = JSON.parse(localStorage.getItem('RFPReview'));
        this.isLoading = true;
          await axios.get('RFPStep/getAllItemsWordFile', {
              params: {
                pagination: 0,
                rfp_id: rfp_id.id,
              }
            })
              .then(response => {
                  this.sections = response.data.items;
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








</style>
