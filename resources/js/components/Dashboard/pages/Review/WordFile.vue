<template>
  <div class="card">
    <div class="row" style="margin-top:60px;">
      

  

<div class="documents-list">
  <div
    v-for="section in sections"
    :key="section.id"
    class="document-item mb-4 p-3 border rounded bg-light">
    <!-- Text Section -->
    <div v-if="section.type === 'text'" v-html="section.description">
      
    </div>


    <!-- Sheet Pricing Section -->
    <div v-else-if="section.type === 'PricingSheet'"> 
       <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Reference</th>
            <th>duration</th>
            <th>Quantity</th>
            <th>UOM</th>
            <th>Unit Price</th>
            <th>Total Price</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in itemsFlatTree" :key="item.id">
            <td>{{ index }}</td>
            <td :style="{ paddingLeft: item.level * 20 + 'px' }">{{ item.text }}</td>
            <td>{{ item.reference }}</td>
            <td>{{ item.duration }}</td>
            <td>{{ item.quantity }}</td>
            <td>{{ item.uom }}</td>
            <td>{{ item.unit_price }}</td>
            <td>{{ item.total_price }}</td>
          </tr>
        </tbody>
      </table>
    </div>


    <!-- Technical Section -->
    <div v-else-if="section.type === 'TechnicalSheet'"> 
        
        <TechnicalView></TechnicalView>

    </div>

  </div>
</div>


     

        
    </div>

    


  </div>

</template>





<script>



import axios from 'axios';
import { mapState } from 'vuex';
import TechnicalView from '../buyer/TechnicalView.vue';

 
import { nextTick } from 'vue';

 
export default {
  components: {
    TechnicalView
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
            itemsTree: [],
            itemsFlatTree: [],

        };
    },



 

   mounted() {
        this.fetchItemsSections()
        this.fetchItemsTree()

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
                confirmButton: "btn btn-info"
            }
        });
    },





    

    async fetchItemsTree() {
      this.isLoading = true;

      let rfp_id = JSON.parse(localStorage.getItem('RFPReview'));

      try {
        const response = await axios.get('/Gantt/gantt', {
          params: { rfp_id: rfp_id.id }
        });

        this.itemsTree = response.data.items;

        this.itemsFlatTree = this.buildTree(this.itemsTree, 0, 0);

      } catch (error) {
        Swal.fire({
          text: error.message || "Unexpected error",
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn btn-info"
          }
        });
      } finally {
        this.isLoading = false;
      }
    },

    buildTree(items, parentId = 0, level = 0) {
      let tree = [];
      items
        .filter(item => item.parent === parentId)
        .forEach(item => {
          tree.push({ ...item, level });
          tree = tree.concat(this.buildTree(items, item.id, level + 1));
        });
      return tree;
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
                      confirmButton: "btn btn-info"
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
