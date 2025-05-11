<template>
           
  <!--begin::Post-->
  <div class="content flex-column-fluid" id="kt_content">
    <!--begin::Card-->
    <div class="card">
      <!--begin::Card header-->
      <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
          <!--begin::Search-->
          <div class="d-flex align-items-center position-relative my-1">
            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
              <span class="path1"></span>
              <span class="path2"></span>
            </i>
            <input v-model="searchQuery" @input="searchItems" type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search Item ..." />
          </div>
          <!--end::Search-->
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
          <!--begin::Toolbar-->
          <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base" v-if="selectedItems.length === 0">
          
            <!--end::Menu 1-->
            <!--end::Filter-->
            <!--begin::Export-->
            <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_items">
            <i class="ki-duotone ki-exit-up fs-2">
              <span class="path1"></span>
              <span class="path2"></span>
            </i>Export</button>
            <!--end::Export-->
            <!--begin::Add user-->
            <button @click="getModalCreate()" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_item">
            <i class="ki-duotone ki-plus fs-2"></i>Add New</button>
            <!--end::Add user-->
          </div>
          <!--end::Toolbar-->
          <!--begin::Group actions-->
          <div class="d-flex justify-content-end align-items-center " v-if="selectedItems.length != 0" >
            <div class="fw-bold me-5">
            <span class="me-2" >{{ selectedItems.length }}</span>Selected</div>
            <button type="button" class="btn btn-danger"  @click="deleteSelected">Delete Selected</button>
          </div>
          <!--end::Group actions-->
          
         
        </div>
        <!--end::Card toolbar-->
      </div>
      <!--end::Card header-->
      <!--begin::Card body-->
      <div class="card-body py-4">
        <!--begin::Table-->
        <div v-if="isLoading">
          please wait ...
        </div>
        <table v-else class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
          <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
              <th class="w-10px pe-2">
                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                  <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" v-model="selectAll" @change="toggleAll" />
                </div>
              </th>
              <th class="min-w-125px">Name</th>
              <th class="min-w-125px">Status</th>
              <th class="min-w-125px">Joined Date</th>
              <th class="text-center min-w-100px">Actions</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 fw-semibold">
            <tr v-for="(item, index) in items" :key="item.id">
              <td >
                <div class="form-check form-check-sm form-check-custom form-check-solid">
                  <input v-model="selectedItems" :value="item.id" class="form-check-input" type="checkbox"  />
                </div>
              </td>


            

            

              <td class="align-items-center" style="margin-top: 15px;">
                <!--begin:: Avatar -->
               
                <!--end::Avatar-->
                <!--begin::User details-->
                <div class="d-flex flex-column">
                  <a href="#" class="text-gray-800 text-hover-primary mb-1">{{item.name}}</a>
                  <!-- <span>{{item.code}} </span> -->
                </div>
                <!--begin::User details-->
              </td>
              <td>
                <div v-if="item.status=='active'" class="badge badge-light-success fw-bold">{{item.status}}</div>
                <div v-else class="badge badge-light-danger fw-bold">{{item.status}}</div>
              </td>
              <td>{{item.created_at}}</td>
             

              <td class="text-end">
                 <div class="d-flex flex-center rounded p-4 h-80px mb-1 overlay">
                      <div class="overlay-wrapper text-gray-600">
                          <i @click="getModalEdit(item)" class="ki-duotone ki-notepad-edit fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>

                        


                        <div class="overlay-wrapper text-gray-600">
                          <i @click="deleteItem(item.id)" class="ki-duotone ki-trash-square fs-2x">
                           <span class="path1"></span>
                           <span class="path2"></span>
                           <span class="path3"></span>
                           <span class="path4"></span>
                          </i>
                        </div>
                            
                  </div>
              </td>
            </tr>
       
          </tbody>
        </table>

        <!-- <pagination begin  -->
        <pagination :totalItems="totalItems" :currentPage="currentPage" @page-changed="fetchItems"></pagination>
        <!-- <pagination end  -->

        <!--end::Table-->
      </div>
      <!--end::Card body-->
    </div>
    <!--end::Card-->
  </div>
  <!--end::Post-->













             

<!--begin::Modal - Add task-->
  <div class="modal fade" id="kt_modal_add_item" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-fullscreen">
      <!--begin::Modal content-->
      <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header" id="kt_modal_add_user_header">
          <!--begin::Modal title-->
          <h2 class="fw-bold">Add Edit {{routeSegment}}</h2>
          <!--end::Modal title-->
          <!--begin::Close-->
          <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" @click="closeModal">
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



           

             


            <div class="ritz grid-container" dir="ltr">
   <table class="waffle" cellspacing="0" cellpadding="0">
      
      <tbody>
         <tr style="height: 18px">
           
            <td class="s0" dir="ltr" colspan="2">RFP Title</td>
            <td class="s1" dir="ltr" colspan="2">Customer <br> Department</td>
            <td class="s2"></td>
            <td class="s2" dir="ltr" colspan="3">Project Duration</td>
            <td class="s3" dir="ltr" colspan="5">BUDGET</td>
            <td class="s4" dir="ltr" colspan="2">Reason for Approval</td>
            <td class="s5" dir="ltr" colspan="2">Technical Evaluation Committee (TEC)</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s6" dir="ltr" colspan="2">RT Toilets Rehabilitation project (Phase 2)</td>
            <td class="s7" dir="ltr" colspan="2" rowspan="2">Security</td>
            <td class="s8"></td>
            <td class="s7" dir="ltr" colspan="2" rowspan="2">xxxxx</td>
            <td class="s9" dir="ltr" rowspan="2">Months</td>
            <td class="s10" dir="ltr" colspan="2">PR xxxxxxxxxxx<br> Budget Availability</td>
            <td class="s10" dir="ltr" colspan="3">Comments</td>
            <td class="s9" dir="ltr" colspan="2" rowspan="2">Tender/Procurement Related Committees</td>
            <td class="s11" dir="ltr">Name</td>
            <td class="s11" dir="ltr">Department</td>
         </tr>
         <tr style="height: 18px">
           
            <td class="s12" dir="ltr" colspan="2">DACO-RFP-xxxxxxxxxx</td>
            <td class="s13"></td>
            <td class="s10" dir="ltr" colspan="2">xxxxxxxxx</td>
            <td class="s14" colspan="3"></td>
            <td class="s15" dir="ltr">xxxxxxxxx</td>
            <td class="s16" dir="ltr">P&amp;TA</td>
         </tr>
         <tr style="height: 18px">
           
            <td class="s5" dir="ltr" colspan="2">Proposed Bidders</td>
            <td class="s17" dir="ltr" colspan="6">Scope Overview:</td>
            <td class="s18" dir="ltr" colspan="7" rowspan="9">xxxxxxxxxxxxxxx</td>
            <td class="s15" dir="ltr">xxxxxxxxx</td>
            <td class="s16" dir="ltr">P&amp;TA</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s19" dir="ltr" colspan="2">Name</td>
            <td class="s20" dir="ltr" colspan="6">Tender Documents Chck list:</td>
            <td class="s15" dir="ltr">xxxxxxxxx</td>
            <td class="s21" dir="ltr">FRS</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">Al Busailli Contracting Co.</div>
            </td>
            <td class="s22" dir="ltr">Pre-Qualifed</td>
            <td class="s23" dir="ltr" colspan="5">Description</td>
            <td class="s23" dir="ltr">Yes / No</td>
            <td class="s15" dir="ltr">xxxxxxxxx</td>
            <td class="s16" dir="ltr">P&amp;TA (Engineering)</td>
         </tr>
         <tr style="height: 18px">
           
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">Rezayat Construction Co.</div>
            </td>
            <td class="s22" dir="ltr">Pre-Qualifed</td>
            <td class="s24" dir="ltr" colspan="5">Final RFP / Scope of Work Document</td>
            <td class="s25" dir="ltr">Yes</td>
            <td class="s15" dir="ltr">xxxxxxxxx</td>
            <td class="s16" dir="ltr">P&amp;TA (Execution)</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15" dir="ltr">ICAD</td>
            <td class="s22" dir="ltr">Pre-Qualifed</td>
            <td class="s24" dir="ltr" colspan="5">BOQ/Deliverables (Pricings Sheet)</td>
            <td class="s25" dir="ltr">Yes</td>
            <td class="s15" dir="ltr">xxxxxxxxx</td>
            <td class="s21" dir="ltr">A&amp;FM</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">Al Yamama Contracting</div>
            </td>
            <td class="s22" dir="ltr">Pre-Qualifed</td>
            <td class="s24" dir="ltr" colspan="5">Technical Criteras in RFP</td>
            <td class="s25" dir="ltr">Yes</td>
            <td class="s15" dir="ltr">xxxxxxxxx</td>
            <td class="s16" dir="ltr">Operations</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">Projects Links Co.</div>
            </td>
            <td class="s22" dir="ltr">Pre-Qualifed</td>
            <td class="s24" dir="ltr" colspan="5">Appendix to the RFP (Drawings/Datasheet Etc.)</td>
            <td class="s25" dir="ltr">Yes</td>
            <td class="s15"></td>
            <td class="s26"></td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">Al Balatin Contracting Co.</div>
            </td>
            <td class="s22" dir="ltr">Pre-Qualifed</td>
            <td class="s24" dir="ltr" colspan="5">DACO General Cotract with T&amp;C</td>
            <td class="s25" dir="ltr">Yes</td>
            <td class="s15"></td>
            <td class="s26"></td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">BTC (Baud Telecomm Company)</div>
            </td>
            <td class="s21" dir="ltr">Pre-Qualifed</td>
            <td class="s27" dir="ltr" colspan="5">Internal Technical Evaluation Sheet with Conditions &amp; score</td>
            <td class="s28" dir="ltr">Yes</td>
            <td class="s15"></td>
            <td class="s26"></td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">IIGCEST (Independent Innovation General Contracting)</div>
            </td>
            <td class="s22" dir="ltr">Pre-Qualifed</td>
            <td class="s29" dir="ltr" colspan="3">Technical Evaluation <br> Weight:</td>
            <td class="s30"></td>
            <td class="s30"></td>
            <td class="s31"></td>
            <td class="s32" dir="ltr" colspan="3">70%</td>
            <td class="s32"></td>
            <td class="s33 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:217px;left:-1px">Commercial Evaluation Weight</div>
            </td>
            <td class="s34" dir="ltr" colspan="2">30%</td>
            <td class="s15"></td>
            <td class="s26"></td>
         </tr>
         <tr style="height: 18px">
           
            <td class="s35"></td>
            <td class="s36"></td>
            <td class="s37" dir="ltr" colspan="6">Technical Passing Score :</td>
            <td class="s34" dir="ltr" colspan="7">70 out of 100</td>
            <td class="s15"></td>
            <td class="s26"></td>
         </tr>
         <tr style="height: 18px">
           
            <td class="s38"></td>
            <td class="s39"></td>
            <td class="s37" dir="ltr" colspan="6">How many Contractors to be awarded?</td>
            <td class="s40" dir="ltr">One</td>
            <td class="s40"></td>
            <td class="s41" dir="ltr" colspan="2">Contract period</td>
            <td class="s34" dir="ltr" colspan="3">xxxxx</td>
            <td class="s42"></td>
            <td class="s43"></td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s44" dir="ltr" colspan="2">RFP REVIEW TEAM</td>
            <td class="s45" colspan="6"></td>
            <td class="s46" colspan="7"></td>
            <td class="s5" dir="ltr" colspan="2">Commercial Evaluation Committee</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s47" dir="ltr">Name</td>
            <td class="s48" dir="ltr">Department</td>
            <td class="s45" colspan="6"></td>
            <td class="s34" colspan="7"></td>
            <td class="s47" dir="ltr">Name</td>
            <td class="s48" dir="ltr">Department</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">xxxxxxxxxxxxxxxxx</div>
            </td>
            <td class="s22" dir="ltr">P&amp;TA</td>
            <td class="s45" colspan="6"></td>
            <td class="s34" colspan="7"></td>
            <td class="s15" dir="ltr">Saleh S. Althamer</td>
            <td class="s26" dir="ltr">TPC</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">xxxxxxxxxxxxxxxxx</div>
            </td>
            <td class="s22" dir="ltr">P&amp;TA</td>
            <td class="s49"></td>
            <td class="s49"></td>
            <td class="s49"></td>
            <td class="s49"></td>
            <td class="s49"></td>
            <td class="s45"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s34"></td>
            <td class="s15" dir="ltr">Abdulaziz Alfarhan</td>
            <td class="s26" dir="ltr">TPC</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">xxxxxxxxxxxxxxxxx</div>
            </td>
            <td class="s21" dir="ltr">P&amp;TA [Enigneering]</td>
            <td class="s45" dir="ltr" colspan="6">Technical Evaluation :</td>
            <td class="s46" dir="ltr" colspan="7">As per Technical Criteria&#39;s in RFP &amp; TE sheet.</td>
            <td class="s15" dir="ltr">Shaijou Parambath</td>
            <td class="s26" dir="ltr">TPC</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">xxxxxxxxxxxxxxxxx</div>
            </td>
            <td class="s22" dir="ltr">A&amp;FM</td>
            <td class="s45" colspan="6"></td>
            <td class="s34" colspan="7"></td>
            <td class="s50" dir="ltr">(Add If any)</td>
            <td class="s16" dir="ltr">TPC</td>
         </tr>
         <tr style="height: 18px">
           
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">xxxxxxxxxxxxxxxxx</div>
            </td>
            <td class="s22" dir="ltr">FRS</td>
            <td class="s45" dir="ltr" colspan="6">Contracting strategy:</td>
            <td class="s34" dir="ltr" colspan="7">Award to One Vendor who is lowest price or highest Techno-Commercial Scored bidder</td>
            <td class="s50" dir="ltr">xxxxxx(Above 5M)</td>
            <td class="s16" dir="ltr">Finance</td>
         </tr>
         <tr style="height: 18px">
           
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">xxxxxxxxxxxxxxxxx</div>
            </td>
            <td class="s22" dir="ltr">Operation</td>
            <td class="s49"></td>
            <td class="s49"></td>
            <td class="s49"></td>
            <td class="s49"></td>
            <td class="s49"></td>
            <td class="s45"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s34"></td>
            <td class="s15"></td>
            <td class="s26"></td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:66px;left:-1px">xxxxxxxxxxxxxxxxx</div>
            </td>
            <td class="s22" dir="ltr">P&amp;TA [Execution]</td>
            <td class="s49"></td>
            <td class="s49"></td>
            <td class="s49"></td>
            <td class="s49"></td>
            <td class="s49"></td>
            <td class="s45"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s40"></td>
            <td class="s34"></td>
            <td class="s15"></td>
            <td class="s26"></td>
         </tr>
         <tr style="height: 18px">
           
            <td class="s15"></td>
            <td class="s51"></td>
            <td class="s52" dir="ltr" colspan="6">Other comments:</td>
            <td class="s53" colspan="7"></td>
            <td class="s54"></td>
            <td class="s55"></td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15"></td>
            <td class="s56"></td>
            <td class="s49" dir="ltr" colspan="6">Negotiation Process</td>
            <td class="s57" dir="ltr" colspan="7">Negotiations will be initiated with lowest price, highest Techno-Commercial Scored bidders</td>
            <td class="s5" dir="ltr" colspan="2">Negotiation Team</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s15"></td>
            <td class="s58"></td>
            <td class="s59" dir="ltr" colspan="6" rowspan="2">Cost Reduction Strategy (Alternative options)</td>
            <td class="s60" dir="ltr" colspan="7" rowspan="2">Objectives for the negotiation shall determine (but not limited to):<br> A detailed negotiation mechanism shall be developed by Procurement department based on outcome of bid evaluation.</td>
            <td class="s47" dir="ltr">Name</td>
            <td class="s48" dir="ltr">Department</td>
         </tr>
         <tr style="height: 18px">
           
            <td class="s15"></td>
            <td class="s58"></td>
            <td class="s61" dir="ltr" colspan="2">By TPC Team</td>
         </tr>
         <tr style="height: 18px">
           
            <td class="s11" dir="ltr" colspan="17">PRELIMINARY PROCUREMENT TIMEFRAME</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s2" dir="ltr" colspan="2">Milestone</td>
            <td class="s62 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:95px;left:-30px">RFP Review</div>
            </td>
            <td class="s63 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:68px;left:-3px">TPS <br> VPSS Approval</div>
            </td>
            <td class="s64" dir="ltr">RFP Release</td>
            <td class="s62 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:68px;left:-3px">Job-X <br> Site Visit</div>
            </td>
            <td class="s63 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:68px;left:-3px">Q&amp;A<br> (R 5, C10)</div>
            </td>
            <td class="s65" dir="ltr">BCD / Extension</td>
            <td class="s65" dir="ltr">TPO</td>
            <td class="s64" dir="ltr">TE</td>
            <td class="s63 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:68px;left:-3px">PCF<br> (If &lt;3 TE Qual)</div>
            </td>
            <td class="s65" dir="ltr">CPO</td>
            <td class="s64" dir="ltr">TECO</td>
            <td class="s63 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:68px;left:-3px">Negotiations</div>
            </td>
            <td class="s65" dir="ltr">PCE</td>
            <td class="s65" dir="ltr">NOA</td>
            <td class="s66" dir="ltr">Contract / PO</td>
         </tr>
         <tr style="height: 18px">
           
            <td class="s67" dir="ltr">Dates</td>
            <td class="s68" dir="ltr">11/14/2024</td>
            <td class="s69" dir="ltr">11/17/2024</td>
            <td class="s69" dir="ltr">11/18/2024</td>
            <td class="s69" dir="ltr">11/19/2024</td>
            <td class="s69" dir="ltr">11/26/2024</td>
            <td class="s69" dir="ltr">12/4/2024</td>
            <td class="s70" dir="ltr">12/15/2024</td>
            <td class="s69" dir="ltr">12/16/2024</td>
            <td class="s69" dir="ltr">12/18/2024</td>
            <td class="s69" dir="ltr">12/25/2024</td>
            <td class="s69" dir="ltr">12/26/2024</td>
            <td class="s69" dir="ltr">12/31/2024</td>
            <td class="s69" dir="ltr">1/6/2025</td>
            <td class="s69" dir="ltr">1/6/2025</td>
            <td class="s69" dir="ltr">1/9/2025</td>
            <td class="s71" dir="ltr">1/16/2025</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s72 softmerge" dir="ltr">
               <div class="softmerge-inner" style="width:647px;left:-1px">Required working days</div>
            </td>
            <td class="s73"></td>
            <td class="s74" dir="ltr">1</td>
            <td class="s75" dir="ltr">1</td>
            <td class="s75" dir="ltr">1</td>
            <td class="s76" dir="ltr">5</td>
            <td class="s76" dir="ltr">4</td>
            <td class="s76" dir="ltr">7</td>
            <td class="s76" dir="ltr">1</td>
            <td class="s76" dir="ltr">2</td>
            <td class="s76" dir="ltr">5</td>
            <td class="s75" dir="ltr">1</td>
            <td class="s75" dir="ltr">3</td>
            <td class="s75" dir="ltr">4</td>
            <td class="s75" dir="ltr">0</td>
            <td class="s75" dir="ltr">3</td>
            <td class="s77" dir="ltr">5</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s78"></td>
            <td class="s78"></td>
            <td class="s78"></td>
            <td class="s78"></td>
            <td class="s78"></td>
            <td class="s78"></td>
            <td class="s78"></td>
            <td class="s78"></td>
            <td class="s78"></td>
            <td class="s78"></td>
            <td class="s78"></td>
            <td class="s78"></td>
            <td class="s78"></td>
            <td class="s78"></td>
            <td class="s79"></td>
            <td class="s80" dir="ltr">Total working Days:</td>
            <td class="s81" dir="ltr">42</td>
         </tr>
         <tr style="height: 18px">
            
            <td class="s82" dir="ltr" colspan="2">Initiate<br> TPC</td>
            <td class="s82" dir="ltr" colspan="3">Endorsed by End-user</td>
            <td class="s82" dir="ltr" colspan="3">Recommend By TPC GM (A)</td>
            <td class="s82" dir="ltr" colspan="6">Comments</td>
            <td class="s11" dir="ltr" colspan="3">Approved by VP of Shared Services</td>
         </tr>
      </tbody>
   </table>
</div>








            </div>
            <div class="text-center pt-10">
            <button type="submit" class="btn btn-primary" @click.prevent="addEditItem" :disabled="isLoading">
              <span  class="indicator-label">Submit</span>
              <span  class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
              </span>
            </button>

              <button style="margin: 7px;" type="submit" class="btn btn-secondary" @click.prevent="closeModal">
              <span  class="indicator-label">Canacel</span>
              
            </button>

            </div>
          </form>
        </div>


      </div>
    </div>
  </div>
<!--begin::Modal - Add task-->


           

    




             
</template>

<script>


import axios from 'axios';
import Pagination from '../../layout/pagination.vue';
import { mapState } from 'vuex';
import Multiselect from 'vue-multiselect'


 
export default {
  props: ['object'],
  components: {
    Pagination,Multiselect
  },
    data() {
        return {
            languages:{},
            totalItems: 0, // إجمالي العناصر (يمكن تحديثه بناءً على الاستجابة)
            currentPage: 1,
            selectedItems: [], // Selected items for deletion
            selectAll: false, // To track if all items are selected
            searchQuery: '', // الكلمة المفتاحية للبحث
            isLoading: false, // حالة التحميل
            items: [], 
            itemsCategories: [], 
            searchQuery: '',
            formData: {
                category:'',
                code: '',
                link: '',
                logo: '',
            },

            logo:'',

            
            ItemID: null,
            URL:'ItemsObjects/createItem',

            routeSegment: this.object,
        };
    },


    mounted() {
       
        this.fetchItems(this.currentPage);
        
    },


   
    methods: {

        onFileChange(e) {

            const file = e.target.files[0];
            if (file) {
              this.logo = e.target.files[0];
                this.formData.logo = URL.createObjectURL(file);
            }
        },



        getModalCreate(){
          this.URL = 'ItemsObjects/createItem'
          this.resetItem();
          $('#kt_modal_add_item').modal('show');
          this.titleModal = 'اضافة جديد '
          this.fetchItemsCategories()


        },

 
        getModalEdit(item){
            this.ItemID = item.id
            this.resetItem();
            $('#kt_modal_add_item').modal('show');
            this.titleModal = 'تعديل البيانات'
            this.getItemById() 
            this.URL = 'ItemsObjects/editItem'
            this.fetchItemsCategories()
        },


      

        closeModal(){
            $('#kt_modal_add_item').modal('hide');
            this.URL = 'ItemsObjects/createItem'
            this.ItemID = null
            // this.resetMark();
        },


      

        resetItem(){
          this.formData.code=''
          this.formData =  {
                category:'',
                code: '',
                link: '',
                logo: '',
            }
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


        searchItems() {
          this.fetchItems(this.searchQuery); // استدعاء الدالة مع الكلمة المفتاحية
        },


        // جلب جميع المستخدمين
        async fetchItems(page,query = '') {
          this.currentPage = page;
          this.isLoading = true;
            await axios.get('ItemsObjects/getAllItems', {
                params: {
                  search: this.searchQuery,  // تمرير قيمة البحث
                  pagination: 1,
                  page:page,
                  object: this.routeSegment,
                }
              })
                .then(response => {
                    this.items = response.data.items.data;
                    this.isLoading = false;
                    this.totalItems = response.data.items.total
                    this.languages = this.$store.state.languages ;

                    console.log(this.languages)
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

        async fetchItemsCategories() {
            const typeList = ['category'];
            axios.get('/ItemsCategories/getAllItems?pagination=0', {
                params: {
                    pagination: 0,
                    object: this.routeSegment
                }
            })
            .then(response => {
                this.itemsCategories = response.data.items;
            })
            .catch(error => {
                console.log(error);
            });
        },


    
       

        addEditItem() {

          
          this.isLoading = true;

           
           const config = {
                  headers: {
                      'content-type': 'multipart/form-data'
                  }
              }

             let form = new FormData();
              form.append('code', this.formData.code);
              if (this.formData.link) {
                form.append('link', this.formData.link);
              }
              

              form.append('type', this.routeSegment);
             this.languages.forEach((element) => { 
                  form.append('name_' + element.lang, this.formData['name_' + element.lang]); 
                  form.append('description_' + element.lang, this.formData['description_' + element.lang]); 
              });

             if(this.routeSegment == 'standards' || this.routeSegment == 'drawings'){

                  form.append('category_id', this.formData.category.id);
             }
             
              if (this.formData.logo) {
                form.append('logo', this.logo);
              }
           
            if(this.ItemID != ''){
               form.append('Item_id', this.ItemID);
            }
             
          axios.post(this.URL,form,config).then((response)=>{
                 this.isLoading = false;
                if(response.data.items){
                   swal.fire({
                    text: "تم حفظ التغييرات بنجاح",
                    icon: "success",
                    timer: 2000,
                    button: false
                    }); 
                    this.closeModal()
                    this.fetchItems()           

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

            axios.get('ItemsObjects/getById', { params: { ID: this.ItemID } }).then(response => {
                if(response.data){
                  let data = response.data.items
                  let translations = response.data.items.translations
                  this.resetItem()

                  this.formData = data;
                   translations.forEach((element) => { 
                              this.formData['name_'+element.locale] = element.name; 
                              this.formData['description_'+element.locale] = element.description; 
                        });



                }else{
                    Swal.fire({
                        text: "Error happens",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
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


      


        deleteItem(id) {
          swal.fire({
            text: "Are you sure you want to delete this item?",
            icon: "warning",
            buttonsStyling: false,
            showDenyButton: true,
            confirmButtonText: "Yes",
            denyButtonText: 'No',
            customClass: {
              confirmButton: "btn btn-primary",
              denyButton: "btn btn-light-danger"
            }
          }).then((result) => {
            if (result.isConfirmed) {
              // إذا تم تأكيد الحذف
              axios.delete(`ItemsObjects/deleteItem/${id}`)
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
                      confirmButton: "btn btn-light-primary"
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
                  confirmButton: "btn btn-light-primary"
                }
              });
            }
          });
        },

       toggleAll() {
          if (this.selectAll) {
            this.selectedItems = this.items.map(item => item.id);
          } else {
            this.selectedItems = [];
          }

        },
      
        deleteSelected() {
          this.selectedItems.forEach(id => {
            this.deleteItem(id);
          });
          this.selectedItems = [];
          this.selectAll = false;
        },
      
     
  },

   watch: {
    // راقب تغيير المسار للتحديث عند الانتقال بين الصفحات
    '$route.params.object': {
      immediate: true, // تشغيل التحديث عند تحميل الصفحة
      handler(newVal) {
        // تحديث الـ breadcrumb بناءً على قيمة :object الجديدة
        this.$route.meta.breadcrumb = `${newVal.charAt(0).toUpperCase() + newVal.slice(1)} Management`;
      }
    }
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




     .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }











.ritz .waffle a { color: inherit; }.ritz .waffle .s60{border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:18pt;vertical-align:top;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s45{border-right:1px SOLID #000000;background-color:#7030a0;text-align:right;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s0{border-bottom:1px SOLID #ffffff;border-right:1px SOLID #ffffff;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:20pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s8{border-right:1px SOLID #ffffff;background-color:#bfbfbf;text-align:center;font-weight:bold;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s39{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#ff0000;font-family:Arial;font-size:14pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s65{border-bottom:1px SOLID #ffffff;border-right:1px SOLID #ffffff;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:17pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s68{border-bottom:1px SOLID #ffffff;border-right:1px SOLID #ffffff;background-color:#7030a0;text-align:right;color:#51154a;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s82{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;font-weight:bold;color:#000000;font-family:Arial;font-size:16pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s18{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:16pt;vertical-align:top;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s29{border-bottom:1px SOLID #d9d9d9;background-color:#7030a0;text-align:right;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s28{background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s77{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#e49edd;text-align:center;color:#000000;font-family:Arial;font-size:17pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s20{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #d9d9d9;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:20pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s56{border-bottom:1px SOLID #002060;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:14pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s81{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:14pt;vertical-align:top;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s26{border-bottom:1px SOLID #002060;border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;color:#000000;font-family:Arial;font-size:15pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s63{border-left:none;border-bottom:1px SOLID #ffffff;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:17pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s33{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #d9d9d9;background-color:#7030a0;text-align:left;color:#ffffff;font-family:Arial;font-size:16pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s35{border-bottom:1px SOLID #002060;border-right:1px SOLID #002060;background-color:#ffffff;text-align:left;color:#ff0000;font-family:Arial;font-size:15pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s9{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#bfbfbf;text-align:center;font-weight:bold;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s11{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;font-weight:bold;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s7{border-bottom:1px SOLID #000000;background-color:#bfbfbf;text-align:center;font-weight:bold;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s58{border-bottom:1px SOLID #002060;border-right:1px SOLID #002060;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:14pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s17{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #d9d9d9;background-color:#7030a0;text-align:right;font-weight:bold;color:#ffffff;font-family:Arial;font-size:20pt;vertical-align:top;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s52{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#7030a0;text-align:right;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s36{border-bottom:1px SOLID #002060;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#ff0000;font-family:Arial;font-size:14pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s71{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#e1e1e1;text-align:center;font-weight:bold;color:#000000;font-family:Arial;font-size:17pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s10{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#bfbfbf;text-align:center;font-weight:bold;color:#000000;font-family:Arial;font-size:16pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s25{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #d9d9d9;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:top;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s44{border-bottom:1px SOLID #000000;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s12{border-bottom:1px SOLID #000000;border-right:1px SOLID #ffffff;background-color:#ffffff;text-align:center;font-weight:bold;color:#000066;font-family:Arial;font-size:16pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s31{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #d9d9d9;background-color:#7030a0;text-align:left;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s67{border-bottom:1px SOLID #ffffff;background-color:#7030a0;text-align:right;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s47{border-bottom:1px SOLID #002060;border-right:1px SOLID #002060;background-color:#ffffff;text-align:center;font-weight:bold;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s4{border-bottom:1px SOLID #ffffff;border-right:1px SOLID #000000;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s22{border-bottom:1px SOLID #002060;border-right:1px SOLID #000000;background-color:#ffff00;text-align:center;color:#000000;font-family:Arial;font-size:14pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s64{border-right:none;border-bottom:1px SOLID #ffffff;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:17pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s37{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #d9d9d9;background-color:#7030a0;text-align:right;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s43{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;color:#000000;font-family:Arial;font-size:15pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s41{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #d9d9d9;background-color:#7030a0;text-align:right;color:#ffffff;font-family:Arial;font-size:16pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s13{border-bottom:1px SOLID #000000;border-right:1px SOLID #ffffff;background-color:#bfbfbf;text-align:center;font-weight:bold;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s79{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;font-weight:bold;color:#000000;font-family:Arial;font-size:18pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s59{background-color:#7030a0;text-align:right;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:top;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s42{border-bottom:1px SOLID #000000;border-right:1px SOLID #002060;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:15pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s72{border-right:none;border-bottom:1px SOLID #ffffff;background-color:#7030a0;text-align:left;font-weight:bold;color:#ffffff;font-family:Arial;font-size:16pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s19{border-bottom:1px SOLID #002060;border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;font-weight:bold;color:#000000;font-family:Arial;font-size:16pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s23{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #d9d9d9;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s24{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #d9d9d9;background-color:#7030a0;text-align:right;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:top;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s40{border-bottom:1px SOLID #d9d9d9;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s70{border-bottom:1px SOLID #000000;border-right:1px SOLID #ffffff;background-color:#e1e1e1;text-align:center;font-weight:bold;color:#ff0000;font-family:Arial;font-size:17pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s2{border-bottom:1px SOLID #ffffff;border-right:1px SOLID #ffffff;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s3{border-bottom:1px SOLID #000000;border-right:1px SOLID #ffffff;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:20pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s48{border-bottom:1px SOLID #002060;border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;font-weight:bold;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s1{border-bottom:1px SOLID #ffffff;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s51{border-bottom:1px SOLID #002060;border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;color:#000000;font-family:Arial;font-size:14pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s53{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s49{background-color:#7030a0;text-align:right;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s30{border-bottom:1px SOLID #d9d9d9;background-color:#7030a0;text-align:left;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s74{border-left:none;border-bottom:1px SOLID #000000;background-color:#e49edd;text-align:center;color:#000000;font-family:Arial;font-size:17pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s54{border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:center;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s32{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #d9d9d9;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s15{border-bottom:1px SOLID #002060;border-right:1px SOLID #002060;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:15pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s61{border-bottom:1px SOLID #002060;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s27{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #d9d9d9;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s73{border-left:none;background-color:#7030a0;text-align:left;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s5{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s50{border-bottom:1px SOLID #002060;border-right:1px SOLID #002060;background-color:#ffff00;text-align:left;color:#000000;font-family:Arial;font-size:15pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s80{border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:right;color:#000000;font-family:Arial;font-size:14pt;vertical-align:top;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s6{border-right:1px SOLID #ffffff;background-color:#ffffff;text-align:center;font-weight:bold;color:#000066;font-family:Arial;font-size:16pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s34{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s62{border-left:none;border-right:none;border-bottom:1px SOLID #ffffff;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:17pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s76{border-bottom:1px SOLID #000000;background-color:#94dcf8;text-align:center;color:#000000;font-family:Arial;font-size:17pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s66{border-bottom:1px SOLID #ffffff;border-right:1px SOLID #000000;background-color:#7030a0;text-align:center;font-weight:bold;color:#ffffff;font-family:Arial;font-size:17pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s57{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#ff0000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s38{border-bottom:1px SOLID #000000;border-right:1px SOLID #002060;background-color:#ffffff;text-align:left;color:#ff0000;font-family:Arial;font-size:15pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s16{border-bottom:1px SOLID #002060;border-right:1px SOLID #000000;background-color:#ffff00;text-align:center;color:#000000;font-family:Arial;font-size:15pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s21{border-bottom:1px SOLID #002060;border-right:1px SOLID #002060;background-color:#ffff00;text-align:center;color:#000000;font-family:Arial;font-size:14pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s69{border-bottom:1px SOLID #000000;border-right:1px SOLID #ffffff;background-color:#e1e1e1;text-align:center;font-weight:bold;color:#000000;font-family:Arial;font-size:17pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s14{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#bfbfbf;text-align:left;font-weight:bold;color:#000000;font-family:Arial;font-size:16pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s46{border-bottom:1px SOLID #d9d9d9;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:Arial;font-size:18pt;vertical-align:top;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s75{border-bottom:1px SOLID #000000;background-color:#e49edd;text-align:center;color:#000000;font-family:Arial;font-size:17pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s55{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;color:#000000;font-family:Arial;font-size:18pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s78{border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:left;font-weight:bold;color:#000000;font-family:Arial;font-size:18pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}
</style>

