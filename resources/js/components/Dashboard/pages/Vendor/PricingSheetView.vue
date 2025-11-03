<template>
  <div class="card">
    <div class="row" style="margin-top:60px;">
      <div class="documents-list">
        <div
          v-for="section in sections"
          :key="section.id"
          class="">
          <!-- Text Section -->
         <!--  <div v-if="section.type === 'text'" v-html="section.description">
            
          </div> -->


          <!-- Sheet Pricing Section -->
          <div v-if="section.type === 'PricingSheet'"> 
            <b>{{section.title}}</b>
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
                  <th>Question</th>
                </tr>
              </thead>
              <tbody>
              <template v-for="(item, index) in itemsFlatTree" :key="item.id">

                <!-- الصف العادي -->
                <tr>
                  <td>{{ index + 1 }}</td>
                  <td :style="{ paddingLeft: item.level * 20 + 'px' }">{{ item.text }}</td>
                  <td>{{ item.reference }}</td>
                  <td>{{ item.duration }}</td>
                  <td>{{ item.quantity }}</td>
                  <td>{{ item.uom }}</td>
                  <td>{{ item.unit_price }}</td>
                  <td>{{ item.total_price }}</td>
                  <td>
                    <button @click="getModalCreate(item.id)" class="btn btn-info">QNA</button>
                  </td>
                </tr>

                <!-- المجموع بعد آخر عنصر من نفس السكوب -->
                <tr
                  v-if="isLastChildInScope(index)"
                  class="table-light fw-bold"
                >
                  <td colspan="7" class="text-end">
                    {{ getRootName(item.id) }} Total (Excl. VAT/WHT)
                  </td>
                  <td colspan="2">SAR {{ getScopeTotal(getRootId(item.id)) }}</td>
                </tr>

              </template>

                <!-- المجموع العام -->
                <tr class="table-secondary">
                  <td colspan="7" class="text-end fw-bold">Overall Total</td>
                  <td colspan="2" class="fw-bold">SAR {{ overallPrice }}</td>
                </tr>
              </tbody>

             </table>

          </div>


          <!-- Technical Section -->
          <!-- <div v-else-if="section.type === 'TechnicalSheet'"> 
              <p>{{section.title}}</p>
              <TechnicalView></TechnicalView>

          </div> -->

        </div>
      </div>      
    </div>

  </div>





<!--begin::Modal - Add task-->
  <div class="modal fade" id="kt_modal_add_item" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
      <!--begin::Modal content-->
      <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header" id="kt_modal_add_user_header">
          <!--begin::Modal title-->
          <h2 class="fw-bold">Question </h2>
          <!--end::Modal title-->
          <!--begin::Close-->
          <div class="btn btn-icon btn-sm btn-active-icon-info" data-kt-users-modal-action="close" @click="closeModal">
            <i class="ki-duotone ki-cross fs-1">
              <span class="path1"></span>
              <span class="path2"></span>
            </i>
          </div>
          <!--end::Close-->
        </div>


        <div class="modal-body px-5 my-7">
          <form id="kt_modal_add_user_form" class="form" action="#">
            <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
            

              <div class="fv-row mb-7" >
                <label class="required fw-semibold fs-6 mb-2">Write Your Question </label>
                <textarea  rows="4" id="messageContent" maxlength="250"
                   v-model="formDataQuestion.question" value=""
                    placeholdr="Write Any Question Here..." class="form-control " >     
                </textarea>
              </div>

            </div>
            <div class="text-center pt-10">
              <button type="submit" class="btn btn-info" @click.prevent="sendQuestion()" :disabled="isLoading">
              <span  class="indicator-label">Submit</span>
              <span  class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
              </span>
            </button>

              <button style="margin: 7px;" type="submit" class="btn btn-secondary" @click.prevent="closeModal">
              <span  class="indicator-label">Canacel</span>
              
            </button>

            </div>



            <!--begin::Accordion - Old Questions-->
            <div class="separator my-10"></div>

           <div v-if="oldQuestions && oldQuestions.length">
              <h3 class="fw-bold mb-5 text-gray-800">
                🧠 Previous Questions
              </h3>

              <div class="accordion" id="kt_accordion_old_questions">
                <div
                  class="accordion-item"
                  v-for="(q, index) in oldQuestions"
                  :key="q.id"
                >
                  <h2 class="accordion-header" :id="'heading_' + index">
                    <button
                      class="accordion-button fs-6 fw-semibold text-gray-800 collapsed justify-content-between"
                      type="button"
                      data-bs-toggle="collapse"
                      :data-bs-target="'#collapse_' + index"
                      aria-expanded="false"
                      :aria-controls="'collapse_' + index"
                    >
                      <div class="d-flex align-items-center w-100 justify-content-between">
                        <div class="d-flex align-items-center">
                          <!-- 🔻 سهم الأكوردين على اليسار -->
                          <i class="ki-outline ki-down fs-3 me-3 rotate-icon"></i>
                          <span>{{ q.question }}</span>
                        </div>

                        <!-- ✅ الحالة -->
                        <span
                          class="badge"
                          :class="q.answer ? 'badge-light-success' : 'badge-light-warning'"
                        >
                          {{ q.answer ? 'Answered' : 'Pending' }}
                        </span>
                      </div>
                    </button>
                  </h2>

                  <div
                    :id="'collapse_' + index"
                    class="accordion-collapse collapse"
                    :aria-labelledby="'heading_' + index"
                    data-bs-parent="#kt_accordion_old_questions"
                  >
                    <div class="accordion-body text-gray-700">
                      <p v-if="q.answer">{{ q.answer }}</p>
                      <p v-else class="text-muted fst-italic">Not Found Answer.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <!--end::Accordion - Old Questions-->

          </form>
        </div>


      </div>
    </div>
  </div>
<!--begin::Modal - Add task-->





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

            formDataQuestion:{
              rfp_id:null,
              item_id:null,
              question:null,
            },


            rfp_id:null,
            item_id:null,
            overallPrice:null,
            oldQuestions:[], 

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
 


        getModalCreate(item_id) {
          this.item_id = item_id;
          this.formDataQuestion = {
            questionable_type: "App\\Models\\GanttTask", 
            questionable_id: item_id, 
            question: null,
          };
          this.fetchItemsQuestions();
          $('#kt_modal_add_item').modal('show');
        },
        


        closeModal(){
          $('#kt_modal_add_item').modal('hide');
        },

  

        getRootId(id) {
            let item = this.itemsTree.find(i => i.id === id);
            while (item && item.parent !== 0) {
              item = this.itemsTree.find(i => i.id === item.parent);
            }
            return item ? item.id : null;
          },

          getRootName(id) {
            const rootId = this.getRootId(id);
            const root = this.itemsTree.find(i => i.id === rootId);
            return root ? root.text : '';
          },

          getScopeTotal(rootId) {
            const scopeItems = this.itemsTree.filter(i => this.getRootId(i.id) === rootId);
            return scopeItems.reduce((sum, i) => sum + parseFloat(i.total_price || 0), 0).toFixed(2);
          },

          isLastChildInScope(index) {
            const current = this.itemsFlatTree[index];
            const next = this.itemsFlatTree[index + 1];
            const currentRoot = this.getRootId(current.id);
            const nextRoot = next ? this.getRootId(next.id) : null;
            return currentRoot !== nextRoot; // يعني انتهى السكوب الحالي
          },

 

    

        async fetchItemsTree() {
            this.isLoading = true;

            let rfp_id = JSON.parse(localStorage.getItem('RFPReview'));

            try {
              const response = await axios.get('/Gantt/gantt', {
                params: { rfp_id: rfp_id.id }
              });

              this.itemsTree = response.data.items;
              const totalSum = this.itemsTree.reduce((sum, item) => {
                return sum + parseFloat(item.total_price || 0);
              }, 0);

              this.overallPrice = totalSum;

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
        this.rfp_id = rfp_id.id
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


 

     sendQuestion() {

        this.isLoading = true;
        this.formDataQuestion.rfp_id = this.rfp_id;
        this.formDataQuestion.item_id = this.item_id;

        axios.post('BuyerTps/sendQuestion',this.formDataQuestion).then((response)=>{
            this.isLoading = false;
            if(response.data.items){
              this.formDataQuestion.question = '';
              this.fetchItemsQuestions()
                this.swalFunction('success','Send Question Successfully')
                // this.closeModal()
            }else{
               this.swalFunction('error',response.data.message)
            }             
          
          }).catch(error => {
              this.isLoading = false;
              this.swalFunction('error',error)
          });
      },



    async fetchItemsQuestions() {
      this.isLoading = true;
      try {
        const response = await axios.get('BuyerTps/getAllItemsQuestions', {
          params: {
            questionable_type: "App\\Models\\GanttTask", 
            questionable_id: this.item_id,         
            rfp_id: this.rfp_id,         
          },
        });
        this.oldQuestions = response.data.items;
      } catch (error) {
        this.swalFunction("error", error.message);
      } finally {
        this.isLoading = false;
      }
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


 

.rotate-icon {
  transition: transform 0.3s ease !important;
}

.accordion-button:not(.collapsed) .rotate-icon {
  transform: rotate(180deg) !important;
}


.accordion-button::after {
  display: none !important;
}

</style>
