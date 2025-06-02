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
        <table class="table table-bordered table-striped align-middle table excel-like-table" >
          <tr class="background">
            <td colspan="18" >TENDER / PROCUREMENT  PLAN SHEET (TPS)</td>
          </tr>
          <tr class="background">
              <td colspan="2">RFP Title</td>
              <td >RFP NO :</td>
              <td colspan="2">Customer <br>Department</td>
              
              <td colspan="3">Project Duration</td>
            
              <td colspan="5">BUDGET</td>
              
              
              <td colspan="2">Reason for Approval</td>
              <td colspan="2">Technical Evaluation Committee (TEC)</td>
          </tr>
          <tr>
              <td colspan="2"><input type="text" class="form-control" v-model='formData.st1' ></td>
              <td ><input type="text" class="form-control" v-model='formData.st2' ></td>
              <td colspan="2">
                  
              <div class="fv-row mb-7">
                <multiselect class="" v-model="formData.department" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsDepartments" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" ></multiselect>

              </div>




              </td>
             
              
              <td colspan="3"> <input type="text" class="form-control" v-model='formData.st4' placeholder="Months"> </td>
              <td colspan="2"><input type="text" placeholder="SAR" class="form-control" v-model='formData.st5' > </td>
              <td colspan="3">  <input type="text" placeholder="Comment" class="form-control" v-model='formData.st6' > </td>
              
              <td colspan="2"> <input type="text" class="form-control" v-model='formData.st7' ></td>
              <td class="background">Name</td>
              <td class="background">Department</td>
          </tr>
          <tr>
              <td colspan="2" class="background">Proposed Bidders</td>
              <td colspan="6" class="background">Scope Overview: </td>
              
              <td colspan="7"> <input type="text" class="form-control" v-model="formData.st8"><br></td>
             
              <td>
                <multiselect class="" v-model="formData.R10" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R10" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>



          </tr>
          <tr>
              <td colspan="2">Name</td>
              <td colspan="6" class="background">Tender Documents Chck list:</td>
             
              <td colspan="7"><textarea type="text" class="form-control" v-model="formData.st18" rows="2"></textarea>  </td>
             
              <td>
                <multiselect class="ddddd" v-model="formData.R11" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              

              <td><multiselect disabled class="" v-model="formData.R11" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
          </tr>
          <tr>
              <td>
                
                <div class="fv-row mb-7">
                  
                  <multiselect class="" v-model="formData.u1" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsVendors" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
                </div>

              </td>
              <td>
                <select class="form-control border" v-model="formData.p1">
                  <option value="Pre-Qualifed">Pre-Qualifed</option>
                  <option value="Post-Qualifed">Post-Qualifed</option>
                </select>

              </td>

              <td colspan="5" class="background">Description</td>
            
              <td class="background">Yes / No</td>
              <td colspan="7"></td>
             
              <td>
                <multiselect class="" v-model="formData.R12" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R12" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
          </tr>
          <tr>
               <td>
                
                <div class="fv-row mb-7">
                  
                  <multiselect class="" v-model="formData.u2" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsVendors" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </div>

              </td>
              <td>
                <select class="form-control border" v-model="formData.p2">
                  <option value="Pre-Qualifed">Pre-Qualifed</option>
                  <option value="Post-Qualifed">Post-Qualifed</option>
                </select>

              </td>

              <td colspan="5" class="background">Final RFP / Scope of Work Document</td>
              
              <td class="background">Yes</td>
              <td colspan="7"></td>
             
              <td>
                <multiselect class="" v-model="formData.R13" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R13" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
          </tr>
          <tr>
               <td>
                
                <div class="fv-row mb-7">
                  
                  <multiselect class="" v-model="formData.u3" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsVendors" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </div>

              </td>
              <td>
                <select class="form-control border" v-model="formData.p3">
                  <option value="Pre-Qualifed">Pre-Qualifed</option>
                  <option value="Post-Qualifed">Post-Qualifed</option>
                </select>

              </td>
              <td colspan="5" class="background">BOQ/Deliverables (Pricings Sheet)</td>
              
              <td class="background">Yes</td>
              <td colspan="7"></td>
             
              <td>
                <multiselect class="" v-model="formData.R14" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R14" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
          </tr>
          <tr>
               <td>
                
                <div class="fv-row mb-7">
                  
                  <multiselect class="" v-model="formData.u4" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsVendors" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </div>

              </td>
              <td>
                <select class="form-control border" v-model="formData.p4">
                  <option value="Pre-Qualifed">Pre-Qualifed</option>
                  <option value="Post-Qualifed">Post-Qualifed</option>
                </select>

              </td>
              <td colspan="5" class="background">Technical Criteras in RFP</td>
             
              <td class="background">Yes</td>
              <td colspan="7"></td>
             
              <td>
                <multiselect class="" v-model="formData.R15" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R15" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
          </tr>
          <tr>
               <td>
                
                <div class="fv-row mb-7">
                  
                  <multiselect class="" v-model="formData.u5" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsVendors" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </div>

              </td>
              <td>
                <select class="form-control border" v-model="formData.p5">
                  <option value="Pre-Qualifed">Pre-Qualifed</option>
                  <option value="Post-Qualifed">Post-Qualifed</option>
                </select>

              </td>

              <td colspan="5" class="background">Appendix to the RFP (Drawings/Datasheet Etc.)</td>
              
              <td class="background">Yes</td>
              <td colspan="7"></td>
            
              <td></td>
              <td></td>
          </tr>
          <tr>
               <td>
                
                <div class="fv-row mb-7">
                  
                  <multiselect class="" v-model="formData.u6" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsVendors" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </div>

              </td>
              <td>
                <select class="form-control border" v-model="formData.p6">
                  <option value="Pre-Qualifed">Pre-Qualifed</option>
                  <option value="Post-Qualifed">Post-Qualifed</option>
                </select>

              </td>

              <td colspan="5" class="background">DACO General Cotract with T&amp;C</td>
              
              <td class="background">Yes</td>
              <td colspan="7"></td>
             
              <td></td>
              <td></td>
          </tr>
          <tr>
               <td>
                
                <div class="fv-row mb-7">
                  
                  <multiselect class="" v-model="formData.u7" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsVendors" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </div>

              </td>
              <td>
                <select class="form-control border" v-model="formData.p7">
                  <option value="Pre-Qualifed">Pre-Qualifed</option>
                  <option value="Post-Qualifed">Post-Qualifed</option>
                </select>

              </td>

              <td colspan="5" class="background">Internal Technical Evaluation Sheet with Conditions &amp; score</td>
              
              <td class="background">Yes</td>
              <td colspan="7"></td>
              
              <td></td>
              <td></td>
          </tr>
          <tr>
               <td>
                
                <div class="fv-row mb-7">
                  
                  <multiselect class="" v-model="formData.u8" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="ItemsVendors" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </div>

              </td>
              <td>
                <select class="form-control border" v-model="formData.p8">
                  <option value="Pre-Qualifed">Pre-Qualifed</option>
                  <option value="Post-Qualifed">Post-Qualifed</option>
                </select>

              </td>

              <td colspan="6" class="background"> 

                <div class="form-check form-check-custom form-check-success form-check-solid" style="gap:25px;color: #fff;">
                  Technical Evaluation & Weight:
                   <input  class="form-check-input" type="checkbox" value="" checked />
                   <label class="form-check-label" for="">
                       weight
                   </label>


                   <input  class="form-check-input" type="checkbox" value="" checked />
                   <label class="form-check-label" for="">
                       Min Price
                   </label>
               </div>

             </td>
              
              <td colspan="4"><input type="text" class="form-control" v-model="formData.st9">%</td>
             
              <td colspan="2" class="background">Commercial Evaluation Weight</td>
              <td ><input type="text" class="form-control" v-model="formData.st10">%</td>
              <td></td>
              <td></td>
          </tr>
          <tr>
              <td></td>
              <td></td>
              <td colspan="6" class="background">Technical Passing Score :</td>
              
              <td colspan="7"><input type="text" class="form-control" v-model="formData.st11" placeholder="70 out of 100"></td>
              
              <td></td>
              <td></td>
          </tr>
          <tr>
              <td></td>
              <td></td>
              <td colspan="6" class="background">How many Contractors to be awarded? </td>
              
              <td colspan="2"><input type="text" class="form-control" v-model="formData.st12" placeholder="One"></td>
              <td colspan="2" class="background">Contract period </td>
              <td colspan="3"><input type="text" class="form-control" v-model="formData.st13" placeholder=""></td>
          
              <td></td>
              <td></td>
          </tr>
          <tr>
              <td colspan="2" class="background">RFP REVIEW TEAM</td>
              <td colspan="6"></td>
              
              <td colspan="7"></td>
              
              <td colspan="2" class="background">Commercial Evaluation Committee</td>
          </tr>
          <tr>
              <td>Name</td>
              <td>Department</td>
              <td colspan="6"></td>
             
              <td colspan="7"></td>
              
              <td>Name</td>
              <td>Department</td>
          </tr>
          <tr>
              <td>
                <multiselect class="" v-model="formData.R1" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R1" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>



              <td colspan="6"></td>
            
              <td colspan="7"></td>
              
              <td>
                <multiselect class="" v-model="formData.R20" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R20" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
          </tr>
          <tr>
               <td>
                <multiselect class="" v-model="formData.R2" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R2" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>

              <td colspan="6"></td>
              
              <td colspan="7"></td>
             
              <td>
                <multiselect class="" v-model="formData.R21" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R21" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
          </tr>
          <tr>
               <td>
                <multiselect class="" v-model="formData.R3" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R3" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>

              <td colspan="6" class="background">Technical Evaluation :</td>
              
              <td colspan="7"><input type="text" class="form-control" v-model="formData.st20" placeholder=""></td>
              
              <td>
                <multiselect class="" v-model="formData.R22" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R22" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
          </tr>
          <tr>
               <td>
                <multiselect class="" v-model="formData.R4" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R4" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>

              <td colspan="6"></td>
              
              <td colspan="7"></td>
              
              <td>
                <multiselect class="" v-model="formData.R23" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R23" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
          </tr>
          <tr>
               <td>
                <multiselect class="" v-model="formData.R5" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R5" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>

              <td colspan="6" class="background">Contracting strategy:</td>
             
              <td colspan="7"> <input type="text" class="form-control" v-model="formData.st14" placeholder=""></td>
              
              <td>
                <multiselect class="" v-model="formData.R24" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R24" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
          </tr>
          <tr>
               <td>
                <multiselect class="" v-model="formData.R6" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R6" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>

              <td colspan="6"></td>
              <td colspan="7"></td>
           
              
              <td></td>
              <td></td>
          </tr>
          <tr>
               <td>
                <multiselect class="" v-model="formData.R7" tag-placeholder="Select " placeholder="Search ..." label="name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>
              <td><multiselect disabled class="" v-model="formData.R7" tag-placeholder="Select " placeholder="Search ..." label="department_name" track-by="id" :options="itemsUsersDefualt" :multiple="false" :taggable="false" :options-limit="10" :allow-empty="false" >
                    
                  </multiselect>
              </td>

              <td colspan="6"></td>
            
              <td colspan="7"></td>
          
              <td></td>
              <td></td>
          </tr>
          <tr>
              <td></td>
              <td></td>
              <td colspan="6" class="background"> Other comments:</td>
              
              <td colspan="7"></td>
             
              <td></td>
              <td></td>
          </tr>
          <tr>
              <td></td>
              <td></td>
              <td colspan="6" class="background">Negotiation Process</td>
              
              <td colspan="7"><input type="text" class="form-control" v-model="formData.st21" placeholder=""></td>
              
              <td colspan="2" class="background">Negotiation Team</td>
          </tr>
          <tr>
              <td></td>
              <td></td>
              <td colspan="6" class="background">Cost Reduction Strategy (Alternative options)</td>
              
              <td colspan="7"><input type="text" class="form-control" v-model="formData.st15" placeholder=""></td>
             
              <td>Name</td>
              <td>Department</td>
          </tr>
          <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td colspan="7"></td>
            
              <td colspan="2">By TPC Team</td>
          </tr>
          <tr>
              <td colspan="17">PRELIMINARY PROCUREMENT TIMEFRAME</td>
             
          </tr>
          <tr class="background">
            <td colspan="2">Milestone</td>
            <td v-for="(milestone, index) in milestones" :key="index" colspan="2">{{ milestone }}</td>
          </tr>
           <tr>
        <td colspan="2" class="background">Start Date</td>
        <td colspan="2">
          <input type="date" v-model="formData.startDate" class="form-control" />
        </td>
        <td v-for="(d, index) in formData.days.slice(1)" :key="'date-' + index" colspan="2">
          {{ calculatedDates[index] }}
        </td>
      </tr>
      <tr>
        <td colspan="2" class="background">Working Days</td>
        <td v-for="(day, index) in formData.days" :key="'day-' + index" colspan="2">
          <input type="number" class="form-control" v-model.number="formData.days[index]" min="0" />
        </td>
      </tr>
          <tr>
              <td colspan="14"></td>
              
           
              <td colspan="3">Total working Days:</td>
          </tr>


          <tr>
              <td colspan="2">Initiate<br>TPC</td>
              <td colspan="3">Endorsed by End-user  </td>
              
              <td colspan="3">Recommend By TPC GM (A)</td>
              
              <td colspan="6">Comments</td>
              
            
              <td colspan="3">Approved by VP of Shared Services</td>
              
          </tr>


          <tr>
              <td colspan="2"></td>
              <td colspan="3"></td>
              
              <td colspan="3"></td>
              
              <td colspan="6"></td>
              
            
              <td colspan="3"></td>
              
          </tr>



          



          <tr>
           <td :colspan="18/ItemsUsersApproval.length" class="label_text text-center" v-for="(user,index) in ItemsUsersApproval" :key="user.id">{{user.name}}<br>{{user.position}}</td>
          


          
       </tr>

       <tr>
           <td :colspan="18/ItemsUsersApproval.length" class="label_text text-center" v-for="(user,index) in ItemsUsersApproval" :key="user.id"><input type="text" class="form-control" v-model="formData['app' + user.id]" />________________</td>
           
          
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
                st12: '',
                st13: '',
                st14: '',
                st15: '',
                st20:'',
                st21:'',
                step: 2,

                u1:'',
                u2:'',
                u3:'',
                u4:'',
                u5:'',
                u6:'',
                u7:'',
                u8:'',
                department:'',

                p1:'',
                p2:'',
                p3:'',
                p4:'',
                p5:'',
                p6:'',
                p7:'',
                p8:'',
               

                R1:'',
                R10:'',
                R11:'',
                R12:'',
                R13:'',
                R14:'',
                R15:'',
                R20:'',
                R21:'',
                R22:'',
                R23:'',
                R24:'',

                startDate: '2024-11-17',
                days: [0, 0, 0, 0, 0, 0, 0,0], 
            },
 
            itemsDepartments:[],
            itemsUsersDefualt:[],
            itemsAllSteps:[],


            selectedValues:{},

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
      this.ItemsUsersApproval.forEach(user => {
        this.$set(this.formData, 'app' + user.id, '');
      });

    },

    computed: {
          locale() {
              return this.$route.params.locale;
          },

          calculatedDates() {
              let result = [];
              let current = this.formData.startDate ? new Date(this.formData.startDate) : null;

              for (let i = 0; i < this.formData.days.length; i++) {
                if (!current || !this.formData.days[i]) {
                  result.push('');
                  continue;
                }

                current = new Date(current); // clone current
                current.setDate(current.getDate() + this.formData.days[i]);
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
                    this.isLoading = false;


                    const raw = localStorage.getItem('itemStep');
                      if (raw) {
                        this.itemStep = JSON.parse(raw);

                        this.ItemsUsersApproval = this.itemStep.users;
                    }

                  
                     
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
                           
                            

                            if (data.st5 &&  !this.formData.st1 ) {
                              this.formData.st1 =  data.st5 ;
                            }


                            if (data.st20 &&  !this.formData.st8 ) {
                              this.formData.st8 =  data.st20 ;
                            }




                            // if (data.R1 && data.R1.name) {
                            //   console.log(`step ${item.step} has R1 user:`, data.R1.name);
                            // }


                            for (let key in data) {
                              console.log(`Key: ${key} | Value:`, data[key]);
                            }
                            
                          });




                })




                })
                .catch(error => {
                  
                  this.swalFunction('error','Error Happens 55')

                   this.isLoading = false;
                });
        },
 

        // async fetchItemsAllSteps() {
        //   this.isLoading = true;
        //      await axios.get('Project/getAllItemsAllSteps', {
        //         params: {
        //           project_id: localStorage.getItem('ProjectID'),
        //         }
        //       })
        //         .then(response => {
        //             this.itemsAllSteps = response.data.items;
        //             this.isLoading = false;


        //             this.itemsAllSteps.forEach(item => {
        //               let data = JSON.parse(item.data_json);
                     

        //               if (this.formData.st1) {
        //                 this.formData.st1 =  data.st5 ;
        //               }


        //               if (data.R1 && data.R1.name) {
        //                 console.log(`step ${item.step} has R1 user:`, data.R1.name);
        //               }


        //               for (let key in data) {
        //                 console.log(`Key: ${key} | Value:`, data[key]);
        //               }

        //             });




        //         })
        //         .catch(error => {
                  
        //           this.swalFunction('error','Error Happens 55')

        //            this.isLoading = false;
        //         });
        // },








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

.multiselect__select{
  display: none;
}
</style>

