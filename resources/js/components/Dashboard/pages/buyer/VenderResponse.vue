<template>
  <div class="tender-details-component">
    <!-- Tender Information Cards -->
    <div class="row g-5 g-xl-8 mb-5">
      <!-- Row 1 -->
      <div class="col-xl-3">
        <div class="card card-flush h-100">
          <div class="card-body p-5">
            <div class="fs-7 fw-bold text-gray-500 mb-2">Tender Title</div>
            <div class="fs-5 fw-bold text-gray-900">{{ tenderInfo.title }}</div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-3">
        <div class="card card-flush h-100">
          <div class="card-body p-5">
            <div class="fs-7 fw-bold text-gray-500 mb-2">Purchase Requisition No.</div>
            <div class="fs-5 fw-bold text-gray-900">{{ tenderInfo.purchaseRequisitionNo }}</div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-3">
        <div class="card card-flush h-100">
          <div class="card-body p-5">
            <div class="fs-7 fw-bold text-gray-500 mb-2">Budget</div>
            <div class="fs-5 fw-bold text-gray-900">{{ formatCurrency(tenderInfo.budget) }}</div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-3">
        <div class="card card-flush h-100">
          <div class="card-body p-5">
            <div class="fs-7 fw-bold text-gray-500 mb-2">PR Proponent</div>
            <div class="fs-5 fw-bold text-gray-900">{{ tenderInfo.prProponent }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-5 g-xl-8 mb-8">
      <!-- Row 2 -->
      <div class="col-xl-2">
        <div class="card card-flush h-100">
          <div class="card-body p-5">
            <div class="fs-7 fw-bold text-gray-500 mb-2">Tender Type</div>
            <div class="fs-5 fw-bold text-gray-900">{{ tenderInfo.tenderType }}</div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-2">
        <div class="card card-flush h-100">
          <div class="card-body p-5">
            <div class="fs-7 fw-bold text-gray-500 mb-2">Technical Evaluation</div>
            <div class="fs-5 fw-bold text-gray-900">{{ tenderInfo.technicalEvaluation }}</div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-2">
        <div class="card card-flush h-100">
          <div class="card-body p-5">
            <div class="fs-7 fw-bold text-gray-500 mb-2">Duration</div>
            <div class="fs-5 fw-bold text-gray-900">{{ tenderInfo.duration }}</div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-3">
        <div class="card card-flush h-100">
          <div class="card-body p-5">
            <div class="fs-7 fw-bold text-gray-500 mb-2">RFP Reference</div>
            <div class="fs-5 fw-bold text-gray-900">{{ tenderInfo.rfpReference }}</div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-3">
        <div class="card card-flush h-100">
          <div class="card-body p-5">
            <div class="fs-7 fw-bold text-gray-500 mb-2">End User</div>
            <div class="fs-5 fw-bold text-gray-900">{{ tenderInfo.endUser }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Vendors Table -->
    <div class="card card-flush">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
            <thead>
              <tr class="fw-bold text-muted bg-light">
                <th class="ps-4 min-w-50px">No.</th>
                <th class="min-w-150px">Vendor Name</th>
                <th class="min-w-120px">Submitted On</th>
                <th class="min-w-120px">Deadline</th>
                <th class="min-w-120px">Status</th>
                <th class="min-w-120px">Action</th>
                <th class="min-w-120px">Status</th>
                <th class="min-w-120px pe-4">Opened On</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="vendor in vendors" :key="vendor.no">
                <td class="ps-4">
                  <span class="text-dark fw-bold fs-6">{{ vendor.no }}</span>
                </td>
                <td>
                  <span class="text-dark fw-bold d-block fs-6">{{ vendor.name }}</span>
                </td>
                <td>
                  <span class="text-dark fw-bold d-block fs-6">{{ vendor.submittedOn }}</span>
                </td>
                <td>
                  <span class="text-dark fw-bold d-block fs-6">{{ vendor.deadline }}</span>
                </td>
                <td>
                  <span 
                    class="badge fs-7 fw-bold"
                    :class="getStatusBadgeClass(vendor.status)"
                  >
                    {{ vendor.status }}
                  </span>
                </td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <span 
                      class="badge fs-7 fw-bold"
                      :class="getActionBadgeClass(vendor.action)"
                    >
                      {{ vendor.action }}
                    </span>
                    <i class="ki-outline ki-document fs-3"></i>
                  </div>
                </td>
                <td>
                  <span 
                    class="badge fs-7 fw-bold"
                    :class="getSecondStatusBadgeClass(vendor.secondStatus)"
                  >
                    {{ vendor.secondStatus }}
                  </span>
                </td>
                <td class="pe-4">
                  <span class="text-dark fw-bold d-block fs-6">{{ vendor.openedOn }}</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TenderDetailsComponent',
  data() {
    return {
      tenderInfo: {
        title: 'Sliding door & Air curtains',
        purchaseRequisitionNo: '1200000222',
        budget: 60000000.00,
        prProponent: 'P&TA',
        tenderType: 'Competitive',
        technicalEvaluation: 'Pending',
        duration: '12 Months',
        rfpReference: 'RFP-12345-11301',
        endUser: 'Commercial'
      },
      vendors: [
        {
          no: 1,
          name: 'Vendor 1',
          submittedOn: 'Apr. 01, 2025',
          deadline: 'Apr. 01, 2025',
          status: 'Submitted',
          action: 'Completed',
          secondStatus: 'Opened',
          openedOn: 'Apr. 01, 2025'
        },
        {
          no: 2,
          name: 'Vendor 2',
          submittedOn: 'Apr. 01, 2025',
          deadline: 'Apr. 01, 2025',
          status: 'Submitted',
          action: 'Open',
          secondStatus: 'Pending',
          openedOn: '000. 00.0000'
        },
        {
          no: 3,
          name: 'Vendor 3',
          submittedOn: 'Apr. 01, 2025',
          deadline: 'Apr. 01, 2025',
          status: 'Declined',
          action: '',
          secondStatus: '',
          openedOn: ''
        },
        {
          no: 4,
          name: 'Vendor 4',
          submittedOn: 'Apr. 01, 2025',
          deadline: 'Apr. 01, 2025',
          status: 'Declined',
          action: '',
          secondStatus: '',
          openedOn: ''
        },
        {
          no: 5,
          name: 'Vendor 5',
          submittedOn: 'Apr. 01, 2025',
          deadline: 'Apr. 01, 2025',
          status: 'Declined',
          action: '',
          secondStatus: '',
          openedOn: ''
        }
      ]
    }
  },
  methods: {
    formatCurrency(value) {
      return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }).format(value);
    },
    getStatusBadgeClass(status) {
      const statusClasses = {
        'Submitted': 'badge-light-primary',
        'Declined': 'badge-light-danger'
      };
      return statusClasses[status] || 'badge-light-secondary';
    },
    getActionBadgeClass(action) {
      const actionClasses = {
        'Completed': 'badge-light-primary',
        'Open': 'badge-light-secondary'
      };
      return actionClasses[action] || 'badge-light-secondary';
    },
    getSecondStatusBadgeClass(status) {
      const statusClasses = {
        'Opened': 'badge-success',
        'Pending': 'badge-warning'
      };
      return statusClasses[status] || 'badge-light-secondary';
    }
  }
}
</script>

<style scoped>
.tender-details-component {
  padding: 20px;
}

.card-flush {
  box-shadow: 0 0 20px 0 rgba(76, 87, 125, 0.02);
}

.card-flush .card-body {
  background-color: #fff;
}

.table-responsive {
  overflow-x: auto;
}

.badge-success {
  background-color: #50cd89;
  color: #fff;
}

.badge-warning {
  background-color: #ffc700;
  color: #fff;
}
</style>
