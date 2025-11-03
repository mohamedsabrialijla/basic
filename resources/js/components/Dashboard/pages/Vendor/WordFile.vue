<template>
  <div class="card">
    <div class="row" style="margin-top:60px;">

        <div class="documents-list">
          <div
            v-for="section in sections"
            :key="section.id"
            class="document-item mb-4 p-3 border rounded bg-light" @click="openSectionModal(section)">
            <!-- Text Section -->
            <div v-if="section.type === 'text'" v-html="section.description">
              
            </div>


            <!-- Sheet Pricing Section -->
            <div v-else-if="section.type === 'PricingSheet'"> 
              <p>{{section.title}}</p>
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
        <p>{{section.title}}</p>
        <TechnicalView></TechnicalView>

    </div>

  </div>
</div>

    </div>
  
    <!-- Modal -->
    <div class="modal fade" id="sectionQuestionModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="fw-bold">Send Question for: {{ selectedSection?.title }}</h2>
            <div class="btn btn-icon btn-sm btn-active-icon-info" @click="closeModal">
              <i class="ki-duotone ki-cross fs-1"></i>
            </div>
          </div>

          <div class="modal-body px-5 my-7">
            <textarea 
              v-model="formData.question" 
              rows="4" 
              placeholder="Write your question here..." 
              class="form-control"
            ></textarea>

            <button 
              class="btn btn-info mt-3"
              :disabled="isLoading"
              @click="sendQuestion"
            >
              Submit
            </button>

            <!-- Previous Questions Accordion -->
            <div class="separator my-5"></div>

            <div v-if="oldQuestions.length">
              <h3 class="fw-bold mb-3">🧠 Previous Questions</h3>

              <div class="accordion" id="accordionOldQuestions">
                <div
                  class="accordion-item"
                  v-for="(q, index) in oldQuestions"
                  :key="q.id"
                >
                  <h2
                    class="accordion-header d-flex align-items-center justify-content-between"
                    :id="'heading_' + index"
                  >
                    <button
                      class="accordion-button fs-6 fw-semibold text-gray-800 collapsed flex-grow-1 text-start"
                      type="button"
                      data-bs-toggle="collapse"
                      :data-bs-target="'#collapse_' + index"
                      aria-expanded="false"
                      :aria-controls="'collapse_' + index"
                    >
                      <!-- 🔹 سهم على اليسار -->
                      <i class="ki-outline ki-down fs-5 me-2"></i>
                      {{ q.question }}
                    </button>

                    <!-- 🔸 الحالة -->
                    <span
                      class="badge ms-3"
                      :class="q.answer ? 'badge-light-success' : 'badge-light-warning'"
                    >
                      {{ q.answer ? 'Answered' : 'Pending' }}
                    </span>
                  </h2>

                  <div
                    :id="'collapse_' + index"
                    class="accordion-collapse collapse"
                    :aria-labelledby="'heading_' + index"
                    data-bs-parent="#accordionOldQuestions"
                  >
                    <div class="accordion-body text-gray-700">
                      <p v-if="q.answer">{{ q.answer }}</p>
                      <p v-else class="text-muted fst-italic">Not Answered Yet.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

  <div v-else class="text-muted mt-2">No previous questions.</div>
</div>

        </div>
      </div>
    </div>
    <!-- End Modal -->

  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      sections: [],
      selectedSection: null,
      oldQuestions: [],
      formData: {
        question: null,
      },
      isLoading: false,
    };
  },
  mounted() {
    this.fetchSections();
  },
  methods: {
    swalFunction(type, text) {
      Swal.fire({
        text,
        icon: type,
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: { confirmButton: "btn btn-primary" },
      });
    },

    async fetchSections() {
      let rfp_id = JSON.parse(localStorage.getItem("RFPReview"));
      this.isLoading = true;
      try {
        const response = await axios.get("RFPStep/getAllItemsWordFile", {
          params: { rfp_id: rfp_id.id },
        });
        this.sections = response.data.items;
      } catch (error) {
        this.swalFunction("error", error.message || "Unexpected error");
      } finally {
        this.isLoading = false;
      }
    },

    openSectionModal(section) {
      this.selectedSection = section;
      this.formData.question = null;
      this.fetchOldQuestions(section.id);
      $('#sectionQuestionModal').modal('show');
    },

    closeModal() {
      const modalEl = document.getElementById("sectionQuestionModal");
      const modal = bootstrap.Modal.getInstance(modalEl);
      if (modal) modal.hide();
    },

    async sendQuestion() {
      if (!this.formData.question?.trim()) return;

      this.isLoading = true;
      try {
        const payload = {
          questionable_id: this.selectedSection.id,
          questionable_type: "App\\Models\\RFPWord",
          question: this.formData.question,
        };
        const response = await axios.post("/BuyerTps/sendQuestion", payload);
        if (response.data.items) {
          this.formData.question = null;
          this.fetchOldQuestions(this.selectedSection.id);
          this.swalFunction("success", "Question sent successfully");
        } else {
          this.swalFunction("error", response.data.message);
        }
      } catch (error) {
        this.swalFunction("error", error.message || "Unexpected error");
      } finally {
        this.isLoading = false;
      }
    },

    async fetchOldQuestions(sectionId) {
      try {
        const response = await axios.get("/BuyerTps/getAllItemsQuestions", {
          params: {
            questionable_id: sectionId,
            questionable_type: "App\\Models\\RFPWord",
          },
        });
        this.oldQuestions = response.data.items || [];
      } catch (error) {
        this.swalFunction("error", error.message || "Cannot fetch questions");
      }
    },
  },
};
</script>

<style>
  
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