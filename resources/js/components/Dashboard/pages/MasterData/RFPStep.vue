<template>
  <div class="card">
    <div class="row" style="margin-top:60px;">
      <!-- Stepper -->
      

      <div class="col-12 mb-4">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
          <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">RFP Dashboard</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="index.html" class="text-muted text-hover-info">RFP</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                
                <li class="breadcrumb-item text-muted">{{ breadcrumbLabel }}</li>

              </ul>

              <div class="row mb-7 d-flex" v-if="currentStep == 4">
                <div class="col-md-12 d-flex">
                  <label class="fw-semibold fs-6 mb-2 col-md-4" style="font-weight: bold; color: red; margin-top: 11px;">DeadLine Date</label>
                  <input
                    type="text"
                    name="first_name"
                    class="form-control form-control-solid"
                    placeholder="Date"
                    v-model="formDataDates.startDate"
                    required
                  />
                </div>
              </div>


            </div>
 

            <div class="d-flex align-items-center gap-2 gap-lg-3">
              <a href="#" class="btn btn-sm fw-bold btn-info" v-if="currentStep !== 0 "
                @click="setStep(currentStep -1)">Previous</a>
              <a href="#" class="btn btn-sm fw-bold btn-info" v-if="currentStep === 0" 
                @click="openList()">Back</a>
              <a href="#" class="btn btn-sm fw-bold btn-info"  v-if="currentStep == 1 && !formData.approve_for_review_team" @click="addEditItem(1)">save Draft</a>
              

              <a href="#" class="btn btn-sm fw-bold btn-info" disabled="currentStep === steps.length - 1" v-if="currentStep == 0 " @click="nextStep">Next</a>
              
              <a href="#" class="btn btn-sm fw-bold btn-info" v-if="currentStep == 1 && !formData.approve_for_review_team" @click="addEditItem(2)">Send To RFP Review Team</a>


              <a href="#"
                 class="btn btn-sm fw-bold btn-secondary disabled"
                 v-if="currentStep == 4 && disable == 0 && formData.publish_buyer"
                 style="pointer-events: none; opacity: 0.7;">
                Published
              </a>

              <a href="#"
                 class="btn btn-sm fw-bold btn-info"
                 v-else-if="currentStep == 4 && disable == 0"
                 @click="publish()">
                Publish
              </a>



            </div>
          </div>
        </div>

        <div class="d-flex align-items-center flex-wrap d-grid gap-2" style="gap:3.5rem !important;width: 84%;margin: auto;margin-top: 26px;margin-bottom: 20px;">

          <div class="d-flex align-items-center"  v-for="(step, index) in steps" 
                :key="index" 
                
                @click="setStep(index)">
            <!--begin::Symbol-->
            <div class="symbol symbol-30px symbol-circle me-3">
              <span class="symbol-label bg-light-info" >
                  
                  <i class="ki-duotone ki-black-right fs-2 text-gray-500" v-if="currentStep === index"></i>
                  <l v-else>{{index+1}}</l>

              </span>
            </div>
            <!--end::Symbol-->
            <!--begin::Info-->
            <div class="m-0">
              <span class="fw-semibold text-gray-500 d-block fs-8" style="cursor:pointer;"> {{ step }}</span>
            </div>
            <!--end::Info-->
          </div>
        </div>
      </div>


       
          
      <!-- Step 1: Kanban Board -->
      <div v-if="currentStep === 0" class="col-12">

          <div class="modal-body px-5 my-7">
          <form id="kt_modal_add_user_form" class="form" action="#" >
            <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">


                 
            <div class="row" v-if="formData && formData.ID_rfp">

              <div class="fv-row col-md-2">
                <label class="required fw-semibold fs-6 mb-2">Event ID Number</label>
                <input  type="text" name="name"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="ID Number" value="" v-model="formData.ID_rfp" required />
              </div>



                <div class="fv-row col-md-6">
                <label class="required fw-semibold fs-6 mb-2" for="name">Event Project Name</label>
                <input type="text" :name="'name'" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Name" value="" v-model="formData.name"   required />
              </div>


              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2">Event Business Unite </label>
                <input type="text" name="name"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Business" value="" v-model="formData.business_unite" required />
              </div>


              



              


               <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2">Event Type</label>
                <multiselect class="" v-model="formData.type_event" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsTypeEvents" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" ></multiselect>

              </div>
  

              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2">Event Category</label>
                <multiselect class="" v-model="formData.category" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsCategories" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" ></multiselect>

              </div>


              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2" for="name">Event Estimated Budget</label>
                <input type="text" :name="'name'" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Estimated Budget" value="" v-model="formData.estimated_budget"   required />
              </div>


              

              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2" for="name">Event  Location</label>
                <input type="text" :name="'name'" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Country , City " value="" v-model="formData.location"   required />
              </div>

              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2" for="name">Event  Currency</label>
                <input type="text" :name="'name'" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Currency" value="" v-model="formData.currency"   required />
              </div>


              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2" for="name">Event Due Date</label>
                <input type="date" :name="'name'" class="form-control form-control-solid mb-3 mb-lg-0"  value="" v-model="formData.due_date"   required />
              </div>


             
              <div class="fv-row col-md-12">
                <label class="required fw-semibold fs-6 mb-2" for="name">Event Project Description (Scope Overview) :</label>
                <textarea row="6" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Description" value="" v-model="formData.description" >
                  
                </textarea>
              </div>


              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2"> Contract Template Type </label>
                <multiselect class="" v-model="formData.contract" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsContracts" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" ></multiselect>

              </div>
 


              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2">Event Contract Duration</label>
               <input type="text" :name="'name'" class="form-control form-control-solid mb-3 mb-lg-0"  value="" v-model="formData.duration"   required />

              </div>

              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2">Number of Awarded Contractor</label>
                <input type="text" :name="'name'" class="form-control form-control-solid mb-3 mb-lg-0"  value="" v-model="formData.number_contractor"   required />

              </div>



              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2">Event Project Review Team</label>
                <multiselect class="" v-model="formData.review_team" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsUsers" :multiple="true" :taggable="false" :options-limit="10" :allow-empty="false" ></multiselect>

              </div>



              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2">Technical Evaluation Committee (TEC)</label>
                <multiselect class="" v-model="formData.technical_commite" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsUsers" :multiple="true" :taggable="false" :options-limit="10" :allow-empty="false" ></multiselect>

              </div>



              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2">Commercial Evaluation Committee</label>
                <multiselect class="" v-model="formData.commercial_commite" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsUsers" :multiple="true" :taggable="false" :options-limit="10" :allow-empty="false" ></multiselect>

              </div>



               <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2">Suggested Vendors</label>
                <multiselect class="" v-model="formData.vendors" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsVendors" :multiple="true" :taggable="false" :options-limit="10" :allow-empty="false" ></multiselect>

              </div>
 


              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2">SOI Teams (vendors Management)</label>
                <multiselect class="" v-model="formData.soi_team" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsUsers" :multiple="true" :taggable="false" :options-limit="10" :allow-empty="false" ></multiselect>

              </div>


              
              <div class="fv-row col-md-4">
                <label class="required fw-semibold fs-6 mb-2">Nogotiation Team</label>
                <multiselect class="" v-model="formData.nogotiation_team" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsUsers" :multiple="true" :taggable="false" :options-limit="10" :allow-empty="false" ></multiselect>

              </div>


              <div class="row" style="margin-top:50px;">


                <div class="fv-row col-md-4">
                  <label class="required fw-semibold fs-6 mb-2">Buyer Tender Team</label>
                  <multiselect class="" v-model="formData.buyer_tender_team" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsUsers" :multiple="true" :taggable="false" :options-limit="10" :allow-empty="false" ></multiselect>

                </div>




                <div class="fv-row col-md-4">
                  <label class="required fw-semibold fs-6 mb-2">Technical Passing Score :</label>
                 <input type="text" :name="'name'" class="form-control form-control-solid mb-3 mb-lg-0"  value="" v-model="formData.techinical_passing_score"   required />

                </div>
              </div>




              <div class="row" style="margin-top:50px;">


             

                  <div class="fv-row col-md-4">
                      <div class="form-check form-check-custom form-check-success form-check-solid" style="gap: 25px; color: rgb(255, 255, 255);"> 

                          <input class="form-check-input" type="checkbox" v-model="formData.check_1"  value=""><label class="form-check-label" for=""> Final RFP / Scope of Work Document </label>
                      </div>
                  </div>



                  <div class="fv-row col-md-4">
                      <div class="form-check form-check-custom form-check-success form-check-solid" style="gap: 25px; color: rgb(255, 255, 255);"> 

                          <input class="form-check-input" type="checkbox" v-model="formData.check_2"  value=""><label class="form-check-label" for=""> BOQ/Deliverables (Pricings Sheet) </label>
                      </div>
                  </div>



                  <div class="fv-row col-md-4">
                      <div class="form-check form-check-custom form-check-success form-check-solid" style="gap: 25px; color: rgb(255, 255, 255);"> 

                          <input class="form-check-input" type="checkbox" v-model="formData.check_3"  value=""><label class="form-check-label" for=""> Technical Criteras in RFP</label>
                      </div>
                  </div>

              </div>
 




              <div class="row" style="margin-top:50px;">


                  <div class="fv-row col-md-4">
                      <div class="form-check form-check-custom form-check-success form-check-solid " style="gap: 25px; color: rgb(255, 255, 255);"> 

                          <input class="form-check-input" type="checkbox" v-model="formData.check_4"  value=""><label class="form-check-label" for=""> Appendix to the RFP (Drawings/Datasheet Etc.) </label>
                      </div>
                  </div>



                  <div class="fv-row col-md-4">
                      <div class="form-check form-check-custom form-check-success form-check-solid" style="gap: 25px; color: rgb(255, 255, 255);"> 

                          <input class="form-check-input" type="checkbox" v-model="formData.check_5"  value=""><label class="form-check-label" for=""> DACO General Cotract with T&C </label>
                      </div>
                  </div>



                  <div class="fv-row col-md-4">
                      <div class="form-check form-check-custom form-check-success form-check-solid" style="gap: 25px; color: rgb(255, 255, 255);"> 

                          <input class="form-check-input" type="checkbox" v-model="formData.check_6" checked="" value=""><label class="form-check-label" for="">Internal Technical Evaluation Sheet with Conditions & score </label>
                      </div>
                  </div>

              </div>







               


             
            


              




              






              

            </div>

            </div>
           
          </form>
        </div>
         
      </div>



      <!-- Step 2 -->
      <div v-if="currentStep === 1" class="col-12">
        

        <div class="modal-body px-5 my-7" >
        
            <div class="row">
              <div class="fv-row col-md-4">
                  <label class="required fw-semibold fs-6 mb-2" for="name"> RFP Project Review Team Deadline  </label>
                  <input type="date" :name="'name'" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Date" value="" v-model="formData.review_team_deadline"   required />
              </div>

              <div class="col-md-4">
               

                <label class="required fw-semibold fs-6 mb-2" for="name"> SOI Vendor Response Deadline Days </label>
               
                    <div class="input-group mb-5">
                      <input
                        type="number"
                        class="form-control"
                        placeholder="Days"
                        aria-label="Deadline Days"
                        aria-describedby="basic-addon1"
                        v-model="formData.soi_days_deadline"
                      />

                      <span
                        class="input-group-text"
                        id="basic-addon1"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="5 Days Start Counting from the last RFP Approval ."
                        style="cursor: pointer;"
                      >
                        <i class="ki-duotone ki-information-5 fs-2x">
                     <span class="path1"></span>
                     <span class="path2"></span>
                     <span class="path3"></span>
                    </i>
                      </span>
                    </div>



              </div>




            </div>

            <div class="row">
              <div class="col-md-2">
                <div class="card card-flush">
                  <div class="card-header pt-5">
                    <h3 class="card-title text-gray-800">Sections</h3>
                  </div>
                  <div class="card-body" style="padding: 5px; cursor:pointer;" v-for="(section,index) in sections">
                    <div class="d-flex flex-stack" >
                      <div class="text-gray-700 fw-semibold fs-6 me-2" @click="sectionData(section.id)">{{section.title}}</div>
                     <!--  <div class="d-flex align-items-senter">
                        <i class="ki-duotone ki-arrow-up-right fs-2 text-success me-2">
                          <span class="path1"></span>
                          <span class="path2"></span>
                        </i>
                        <span class="text-gray-900 fw-bolder fs-6">7.8</span>
                        <span class="text-gray-500 fw-bold fs-6">/10</span>
                      </div> -->
                    </div>
                    <div class="separator separator-dashed my-3"></div>
                  </div>
                </div>
              </div>


              <div class="col-md-10">



                <div class="modal-body px-5 my-7"  v-if="click && formSection.type=='text'">
                  

            
                    <div style="display: flex; gap: 10px;">

                  
                      <div class="fv-row col-md-6">
                        <label class="required fw-semibold fs-6 mb-2" for="name"> Title</label>
                        <input type="text" :name="'name'" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Name" value="" v-model="formSection.title"   required />
                      </div>


                      <div class="fv-row col-md-6">
                        <label class="required fw-semibold fs-6 mb-2" for="name"> Order</label>
                        <input type="text" :name="'name'" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Order" value="" v-model="formSection.order"   required />
                      </div>

                    </div>


                    <div class="row">
                      
                      <div class="fv-row col-md-12" >
                        <label class="required fw-semibold fs-6 mb-2" for="name"> Description</label>
                          <div id="kt_docs_quill_basic" name="kt_docs_quill_basic" style="height: 450px;">
                        
                          </div>
                      </div>

                    </div>
                     
                      

                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" style="margin-top:25px;" @click="addEditSection()">Save changes</button>
                    </div>

                </div>





                  <div class="modal-body px-5 my-7" v-if="formSection.type == 'PricingSheet'">
                  
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">



                        <PricingSheet></PricingSheet>

                     
           




                      </div>
                         
                  </div>









                 <div class="modal-body px-5 my-7" v-if="formSection.type == 'TechnicalSheet'">
                  
                  <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                      <Technical></Technical>

                    </div>
                      

                   
                </div>





                <div class="modal-body px-5 my-7" v-if="formSection.type == 'PDFContract'">
                  
                  <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px" style="height: 500px;">

                      <PDFHtml></PDFHtml>

                    </div>
        
                </div>



              </div>
            </div>
        </div>
           
      </div>


        
      </div>

      <!-- Step 3 -->
      <div v-if="currentStep === 2" class="col-12">

        <VendorsResponseExcel></VendorsResponseExcel>

      </div>



      <!-- Step 4 -->
      <div v-if="currentStep === 3" class="col-12">

        <TPS></TPS>

      </div>


 

      <!-- Step 5 -->
      <div v-if="currentStep === 4" class="col-12">

        <WordFile></WordFile>

        <!-- Table Dates -->

          <table class="table table-bordered align-middle gs-0 gy-3">
            <thead>
              <tr class="fw-bold text-gray-800 bg-light">
                <th colspan="2" class="text-center">Start Date</th>
                <th colspan="2" class="text-center" v-for="(d, index) in formDataDates.days.slice(1)" :key="'date-head-' + index">
                  Day {{ index + 1 }}
                </th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td colspan="2" class="fw-semibold text-center text-gray-700">
                  {{ formDataDates.startDate }}
                </td>
                <td colspan="2" v-for="(d, index) in formDataDates.days.slice(1)" :key="'date-' + index" class="text-center text-gray-700">
                  {{ calculatedDates[index] }}
                </td>
              </tr>

              <tr class="fw-bold text-gray-800 bg-light">
                <td colspan="2" class="text-center">Working Days</td>
                <td
                  colspan="2"
                  v-for="(day, index) in formDataDates.days.slice(0, -1)"
                  :key="'day-' + index"
                  class="text-center text-gray-700"
                >
                  {{ day }}
                </td>
              </tr>
            </tbody>
          </table>



        <a href="#" class="btn btn-sm fw-bold btn-info" @click="PreivouesDate()">Go To Edit Date </a>

       
        <!-- Table Dates -->
          
      </div>



    </div>






      

    


  















</template>





<script>



import axios from 'axios';
import Pagination from '../../layout/pagination.vue';
import { mapState } from 'vuex';
import Multiselect from 'vue-multiselect'
import Quill from 'quill';
import QuillBetterTable from 'quill-better-table';
import 'quill/dist/quill.snow.css';
import 'quill-better-table/dist/quill-better-table.css';
import PricingSheet from '../buyer/PricingSheet.vue';
import Technical from '../buyer/Technical.vue';
import PDFHtml from '../buyer/PDFHtml.vue';
import VendorsResponseExcel from '../buyer/VendorsResponseExcel.vue';
import TPS from '../buyer/TPS.vue';
import WordFile from '../Review/WordFile.vue';
 Quill.register({
  'modules/better-table': QuillBetterTable
}, true);

import { nextTick } from 'vue';

 
export default {
  components: {
    Pagination,Multiselect,PricingSheet,Technical,PDFHtml,VendorsResponseExcel,TPS,WordFile
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
            ItemsContracts: [],
            sections :[],
            ItemsUsers:[],
            ItemsVendors:[],
            ItemsTypeEvents:[],

            searchQuery: '',
            formData: {
                ID_rfp:'',
                business_unite: '',
                type_event: '',
                category: '',
                contract: '',
                name: '',
                estimated_budget: '',
                description: '',
                draft: '',
            },

            currentStep: 0,
            steps: ["Create RFP", "Scope Review", "Soi Response" , "TPS", "RFP Publish", "Selection","Award"],

            logo:'',
            quill: null,
            click:false,
            formDataDates: {
                

              
              startDate: '2024-11-17',
                days: [0, 0, 0, 0, 0, 0, 0,0],
              },
              disable: 1,


            
            ItemID: null,
            URL:'RFPStep/createItem',

            formSection:{},

        };
    },



 

   mounted() {
        this.fetchItemsCategories()
        // this.fetchItemsSections()
        this.getItemById()
        // this.fetchItemsVendors()
        this.fetchItemsUsers()

        this.fetchItemsRFPObject()



       document.addEventListener('DOMContentLoaded', function () {
          const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
          tooltipTriggerList.map(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
          });
        });



    }, 

    computed: {
      locale() {
              return this.$route.params.locale;
          },


           breadcrumbLabel() {
            switch (this.currentStep) {
              case 0:
                return 'Event';
              case 1:
                return 'Approval';
              case 2:
                return 'Publish';
              case 3:
                return 'Done';
              default:
                return 'Dashboards';
            }
          },


          calculatedDates() {
              let result = [];
              let current = this.formDataDates.startDate ? new Date(this.formDataDates.startDate) : null;

              for (let i = 0; i < this.formDataDates.days.length; i++) {
                if (!current || !this.formDataDates.days[i]) {
                  result.push('');
                  continue;
                }

                current = new Date(current); // clone current
                current.setDate(current.getDate() + this.formDataDates.days[i]);
                result.push(current.toISOString().split('T')[0]);
              }

              return result;
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
 

     setStep(index) {
     
      this.currentStep = index;
    },



    async nextStep() {
        if (this.currentStep == 0) {
            const success = await this.addEditItem();
            if (!success) {
                return; // ❌ لا تنتقل إذا فشل
            }
        }

        if (this.currentStep < this.steps.length - 1) {
            this.currentStep++;
        }
    },



    openList(){
      this.$router.push({ path: `/${this.locale}/dashboard/master_data/projects/rfp-index` });
    },
 

    prevStep() {
      if (this.currentStep > 0) {
        this.getItemById()
        this.currentStep--;
      }
    },




    

      async fetchItemsCategories() {
          axios.get('/ItemsCategories/getAllItems?pagination=0', {
              params: {
                  pagination: 0,
                  // type: 'category'
              }
          })
          .then(response => {

            this.ItemsOverall = response.data.items;
              this.itemsCategories = this.ItemsOverall.filter(item => item.type && item.type.name === "category");
              this.ItemsContracts = this.ItemsOverall.filter(item => item.type && item.type.name === "contract");
              this.ItemsTypeEvents = this.ItemsOverall.filter(item => item.type && item.type.name === "event_type");
          })
          .catch(error => {
              console.log(error);
          });
      },




      async addEditItem(Draft = 0) {
          this.isLoading = true;
          this.formData.draft = Draft;

          if (this.currentStep == 0) {
              this.formData.category_id = this.formData.category.id;
              this.formData.contract_id = this.formData.contract.id;
              this.formData.type_event_id = this.formData.type_event.id;
          }




          if(Draft == 2 && this.formData.review_team_deadline == null ){
              this.swalFunction('info', 'Please Fill Date DeadLine and Days .');
              return ;
          }



          if (Draft == 2) {
            this.formData.approve_for_review_team = 'now';
          }

          if (this.ItemID && this.ItemID != '') {
              this.formData.Item_id = this.ItemID;
              this.URL = 'RFPStep/editItem';
          }

          try {
              const response = await axios.post(this.URL, this.formData);
              this.isLoading = false;

              if (response.data.items) {
                  this.formData = response.data.items;
                  localStorage.setItem('object_rfp', JSON.stringify(this.formData));
                  localStorage.setItem('RFPItem', JSON.stringify(this.formData));
 

                  this.sections = this.formData.sections;

                  this.formData.review_team = JSON.parse(this.formData.review_team);
                  this.formData.soi_team = JSON.parse(this.formData.soi_team);
                  this.formData.nogotiation_team = JSON.parse(this.formData.nogotiation_team);
                  this.formData.buyer_tender_team = JSON.parse(this.formData.buyer_tender_team);
                  this.formData.commercial_commite = JSON.parse(this.formData.commercial_commite);
                  this.formData.technical_commite = JSON.parse(this.formData.technical_commite);
                  this.formData.vendors = JSON.parse(this.formData.vendors);

                  for (let i = 1; i <= 6; i++) {
                      const key = `check_${i}`;
                      this.formData[key] = this.formData[key] == 1;
                  }

                  let message = 'Saved Draft Successfully';
                  if (Draft == 2) {
                      message = 'Sent To Review Team Successfully';
                      this.swalFunction('info', message);
                  }

                  return true; // ✅ نجح
              } else {
                  swal.fire({
                      text: response.data.message,
                      icon: 'error',
                      timer: false,
                      button: true,
                  });
                  return false; // ❌ فشل
              }
          } catch (error) {
              this.isLoading = false;
              swal.fire({
                  text: error.message || "Error occurred",
                  icon: 'error',
                  timer: false,
                  button: true,
              });
              return false; // ❌ فشل
          }
      },





      KcEditor(){

           if (this.quill) return;

           this.quill = new Quill('#kt_docs_quill_basic', {
              theme: 'snow',
              modules: {
                toolbar: [
                  [{ header: [1, 2, false] }],
                  ['bold', 'italic', 'underline'],
                  [{ color: [] }, { background: [] }],
                  ['image', 'code-block'],
                  ['table'] 
                ],
                'better-table': {
                  operationMenu: {
                    items: {
                      unmergeCells: {
                        text: 'Unmerge Cells',
                      }
                    },
                    color: {
                      colors: ['red', 'green', 'yellow', 'blue', 'white'],
                      text: 'Background Colors:'
                    }
                  }
                }
              }
            });

        this.quill.root.innerHTML = ''

      },





    sectionData(ID) {
      localStorage.setItem('section_id',ID);
      this.click = true;
      this.formSection = this.formData.sections.find(item => item.id === ID);

      nextTick(() => {
        this.KcEditor();
        this.quill.root.innerHTML = this.formSection.description || '';
      });
    },



    addEditSection(){

          
        this.isLoading = true;

         const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

           let form = new FormData();
           
            form.append('title', this.formSection.title);
            
            let content = this.quill.root.innerHTML; 
            form.append('description', content);
            form.append('order', this.formSection.order);
            form.append('Item_id', this.formSection.id);
           
         
         
          axios.post('RFPStep/editItemStep',form,config).then((response)=>{
               this.isLoading = false;
              if(response.data.items){
                 
                 let data = response.data.items


                this.formData = data;
         
                localStorage.setItem('RFPItem', JSON.stringify(this.formData));
                this.sections = this.formData.sections


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

 

    async getItemById(){

     let savedItem = localStorage.getItem('RFPItem');
       

      if (!savedItem) {
        return false;
      }


      let object;
      try {
        object = JSON.parse(savedItem);
      } catch (e) {
        object = savedItem;
      }
      
      this.ItemID = object.id ;



      axios.get('RFPStep/getById', { params: { ID: object.id } }).then(response => {
          if(response.data){
            let data = response.data.items
            this.formData = data;
         
            localStorage.setItem('RFPItem', JSON.stringify(this.formData));
             this.sections = this.formData.sections
            this.formData.review_team =  JSON.parse(this.formData.review_team)
            this.formData.soi_team =  JSON.parse(this.formData.soi_team)
            this.formData.nogotiation_team =  JSON.parse(this.formData.nogotiation_team)
            this.formData.buyer_tender_team = JSON.parse(this.formData.buyer_tender_team);
            this.formData.commercial_commite =  JSON.parse(this.formData.commercial_commite)
            this.formData.technical_commite =  JSON.parse(this.formData.technical_commite)
            this.formData.vendors =  JSON.parse(this.formData.vendors)

            for (let i = 1; i <= 6; i++) {
              const key = `check_${i}`;
              this.formData[key] = this.formData[key] == 1;
            }



          }else{
              swalFunction('error','Errors happens')
          }
      }).catch((error)=>{
        this.swalFunction('error',error)
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
                this.ItemsUsers = response.data.items;
                this.ItemsVendors = this.ItemsUsers.filter(item => item.user_type && item.user_type === "vendor");
                // this.ItemsVendors = this.items.filter(item => item.type && item.type.name === "vendors");
                console.log(this.ItemsVendors)

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
 


    async fetchItemsVendors() {
      this.isLoading = true;
         await axios.get('ItemsCategories/getAllItems', {
            params: {
              pagination: 0,
            }
          })
            .then(response => {
                this.items = response.data.items;
                this.ItemsVendors = this.items.filter(item => item.type && item.type.name === "vendors");
                // this.ItemsCriteria = this.items.filter(item => item.type && item.type.name === "criteria");
                this.isLoading = false;


            })
            .catch(error => {
              
              this.swalFunction('error','Error Happens 55')

               this.isLoading = false;
            });
    },


    async fetchItemsRFPObject() {
        this.isLoading = true;
          await axios.get('RFPStep/getById', {
              params: {
                ID:this.ItemID,
              }
            })
              .then(response => { 
                  this.RfpObject = response.data.items;
                  this.formDataDates = JSON.parse(this.RfpObject.data_json_tps);
                  this.disable = response.data.message


                                 
              })
              .catch(error => {
                console.log(error)
                 this.swalFunction('error','Error Happens 77')
                 this.isLoading = false;

              }); 
   
     },



    async PreivouesDate(){

      this.currentStep = 3;

    },


    publish(){

        this.isLoading = true;  

         swal.fire({
            text: "Are you sure ?",
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
              axios.post('BuyerTps/publish',{ rfp_id: this.ItemID })
                .then(() => {
                      this.getItemById()
                      this.swalFunction('success', 'Publish successfully')
 
                })
                .catch(error => {
                  swal.fire({
                    text: 'Error Publish the item. Please try again.', 
                    icon: 'error',
                    confirmButtonText: "Ok",
                    buttonsStyling: false,
                    customClass: {
                      confirmButton: "btn btn-light-info"
                    }
                  });
                });
            } else if (result.isDenied) {
              swal.fire({
                text: 'The Publish has been canceled.', 
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








  },
};
</script>



<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>

.multiselect__option--highlight {
    background: #7239EA !important;
    outline: none;
    color: #fff;}

   

    .multiselect__tag-icon:after {
    color: #7239EA;
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



.multiselect__tag {
    background: #7239EA !important;
}







</style>
