<template>
  <div>
    <!-- الأزرار -->
    <div class="d-flex gap-2 mb-4">
      <button @click="addGroup" class="btn btn-sm btn-success">
        <i class="bi bi-folder-plus"></i> Add Scope
      </button>

      <button @click="addChild" :disabled="!selectedId" class="btn btn-sm btn-primary">
        <i class="bi bi-plus-square"></i> Add Child
      </button>

      <button @click="deleteTask" :disabled="!selectedId" class="btn btn-sm btn-danger">
        <i class="bi bi-trash"></i> Delete Group
      </button>
    </div>

    <!-- جانت -->
    <div id="gantt_here" style="width: 100%; height: 450px;"></div>
  </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import 'dhtmlx-gantt/codebase/dhtmlxgantt.css';
import gantt from 'dhtmlx-gantt';

export default {
  name: 'GanttStyled',
  setup() {
    const selectedId = ref(null);
    let itemCounter = 1;

    onMounted(() => {
      gantt.config.show_chart = false;
      gantt.config.show_grid = true;
      gantt.config.readonly = false;

      gantt.attachEvent("onTaskSelected", function (id) {
        selectedId.value = id;
        return true;
      });

      gantt.config.columns = [
        {
          name: "number",
          label: "#",
          width: 30,
          template: task => task.number || ""
        },
        {
          name: "text",
          label: "Description of Design Deliverable  Scope",
          width: 300,
          tree: true
        },
        {
          name: "reference",
          label: "References",
          width: 120,
          template: task => `
            <div class="gantt-input-cell">
              <input type="text" value="${task.reference || ''}" class="gantt-input" />
            </div>
          `
        },
        {
          name: "quantity",
          label: "Quantity",
          width: 80,
          template: task => `
            <div class="gantt-input-cell">
              <input type="number" value="${task.quantity || 1}" class="gantt-input" />
            </div>
          `
        },
        {
          name: "uom",
          label: "UOM",
          width: 80,
          template: task => `
            <div class="gantt-input-cell">
              <input type="text" value="${task.uom || ''}" class="gantt-input" />
            </div>
          `
        },
        {
          name: "unit_price",
          label: "Unit Price SAR",
          width: 100,
          template: task => `
            <div class="gantt-input-cell">
              <input type="number" value="${task.unit_price || 0}" class="gantt-input" />
            </div>
          `
        },
        {
          name: "total_price",
          label: "Total Price SAR",
          width: 120,
          template: task => `
            <div class="gantt-input-cell">
              <input type="number" value="${task.total_price || 0}" class="gantt-input" />
            </div>
          `
        }
      ];

      gantt.init("gantt_here");

      gantt.parse({
        data: [
          // نموذج بيانات إن أردت تجربته:
          // { id: 1, number: 1, text: "Site Inspection", start_date: "2025-06-25", duration: 1, open: true },
          // { id: 2, number: 2, text: "Topographic Survey", start_date: "2025-06-26", duration: 1, parent: 1, reference: "R1", quantity: 1, uom: "LS", unit_price: 5000, total_price: 5000 }
        ]
      });
    });

    const addGroup = () => {
      const id = gantt.uid();
      gantt.addTask({
        id,
        number: itemCounter++,
        text: "New Scope",
        start_date: "2025-06-10",
        duration: 1,
        open: true
      });
      gantt.selectTask(id);
    };

    const addChild = () => {
      if (!selectedId.value) return;
      const id = gantt.uid();
      gantt.addTask({
        id,
        number: itemCounter++,
        text: "New Child",
        start_date: "2025-06-11",
        duration: 1,
        parent: selectedId.value,
        reference: "",
        quantity: 1,
        uom: "",
        unit_price: 0,
        total_price: 0
      });
      gantt.selectTask(id);
    };

    const deleteTask = () => {
      if (!selectedId.value) return;
      gantt.deleteTask(selectedId.value);
      selectedId.value = null;
    };

    return {
      addGroup,
      addChild,
      deleteTask,
      selectedId
    };
  }
};
</script>

<style scoped>
.gantt-input-cell {
  padding: 0;
  margin: 0;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-sizing: border-box;
}

.gantt-input {
  width: 100%;
  height: 100%;
  padding: 4px 6px;
  font-size: 13px;
  border: none;
  background-color: transparent;
  box-sizing: border-box;
}

.gantt-input:focus {
  outline: none;
  background-color: #f5f5f5;
}
</style>

<style>
.gantt_grid_data .gantt_cell {
  padding: 0 !important;
}
</style>
