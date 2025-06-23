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
import { onMounted, ref } from "vue";
import axios from "axios";
import 'dhtmlx-gantt/codebase/dhtmlxgantt.css';
import gantt from 'dhtmlx-gantt';


export default {
  name: 'GanttStyled',
  setup() {
    const selectedId = ref(null);

   function loadTasks() {
      axios.get('/Gantt/gantt')
        .then(res => {
          gantt.clearAll(); // ضروري لإزالة المهام السابقة
          gantt.parse({ data: res.data.items || [] }); // إعادة رسم المهام
        })
        .catch(() => {
          alert("فشل في تحميل المهام");
        });
    }


    onMounted(() => {
      gantt.config.show_chart = false;
      gantt.config.show_grid = true;
      gantt.config.readonly = false;

    gantt.config.columns = [
        { name: "text", label: "Description", tree: true, width: 200 },
        {
          name: "reference", label: "Reference", width: 100, template: function (task) {
            return `<input type="text" class="gantt-input" data-id="${task.id}" data-field="reference" value="${task.reference || ''}" />`;
          }
        },
        {
          name: "quantity", label: "Qty", width: 60, template: function (task) {
            return `<input type="number" class="gantt-input" data-id="${task.id}" data-field="quantity" value="${task.quantity || 1}" />`;
          }
        },
        {
          name: "uom", label: "UOM", width: 60, template: function (task) {
            return `<input type="text" class="gantt-input" data-id="${task.id}" data-field="uom" value="${task.uom || ''}" />`;
          }
        },
        {
          name: "unit_price", label: "Unit Price", width: 80, template: function (task) {
            return `<input type="number" class="gantt-input" data-id="${task.id}" data-field="unit_price" value="${task.unit_price || 0}" />`;
          }
        },
        {
          name: "total_price", label: "Total", width: 80, template: function (task) {
            return `<span>${task.total_price || 0}</span>`;
          }
        },
      ];


      gantt.init("gantt_here");
      loadTasks();

      gantt.attachEvent("onTaskSelected", function (id) {
        selectedId.value = id;
        return true;
      });

      gantt.attachEvent("onAfterTaskAdd", async (tempId, task) => {
        try {
          const response = await axios.post('/Gantt/gantt', task);
          const realId = response.data.items.id;

          if (!realId) throw new Error("ID غير صالح من السيرفر");

          // تأكد من وجود المهمة قبل التغيير
          if (gantt.isTaskExists(tempId)) {
            gantt.changeTaskId(tempId, realId);
          }

          // إعادة تحميل المهام لضمان التزامن مع قاعدة البيانات
          loadTasks();
        } catch (err) {
          // حذف المهمة المؤقتة إذا فشل الإرسال
          if (gantt.isTaskExists(tempId)) {
            gantt.deleteTask(tempId);
          }
          console.error("فشل في إضافة المهمة:", err);
          alert("فشل في حفظ المهمة");
        }
      });


      // gantt.attachEvent("onAfterTaskUpdate", async function (id, task) {
      //   try {
      //     await axios.put(`/Gantt/gantt/${id}`, {
      //       text: task.text,
      //       parent: task.parent,
      //       reference: task.reference,
      //       quantity: task.quantity,
      //       uom: task.uom,
      //       unit_price: task.unit_price,
      //       total_price: task.total_price
      //     });
      //   } catch (err) {
      //     console.error("فشل في تعديل المهمة:", err);
      //     alert("حدث خطأ أثناء التحديث");
      //   }
      // });


      gantt.attachEvent("onAfterTaskDelete", function (id) {
        axios.delete(`/Gantt/gantt/${id}`).then(() => {
          // لا حاجة لإعادة التحميل، تم الحذف من الواجهة
        }).catch(() => {
          alert("Failed to delete task.");
        });
      });


      document.addEventListener("change", function (e) {
        if (e.target.classList.contains("gantt-input")) {
          const id = e.target.dataset.id;
          const field = e.target.dataset.field;
          const value = e.target.value;

          const task = gantt.getTask(id);
          if (!task) return;

          // تعديل القيمة
          task[field] = (field === "quantity" || field === "unit_price") ? parseFloat(value) || 0 : value;

          // تحديث total_price تلقائيًا
          task.total_price = (parseFloat(task.quantity) || 0) * (parseFloat(task.unit_price) || 0);

          gantt.updateTask(id);

          // إرسال request
          axios.put(`/Gantt/gantt/${id}`, {
            text: task.text,
            parent: task.parent,
            reference: task.reference,
            uom: task.uom,
            quantity: task.quantity,
            unit_price: task.unit_price,
            total_price: task.total_price
          }).then(() => {
            console.log("Updated");
          }).catch((error) => {
            console.error("خطأ في الإرسال:", error);
          });
        }
      });


      document.querySelector('#gantt_here').addEventListener('change', (e) => {
            const input = e.target;
            const taskNode = input.closest("div[task_id]");
            if (!taskNode) return;

            const taskId = taskNode.getAttribute("task_id");
            const task = gantt.getTask(taskId);

            const column = input.closest("td[column_id]");
            if (!column) return;

            const columnId = column.getAttribute("column_id");
            const value = input.value;

            if (columnId === "reference") {
              task.reference = value;
            } else if (columnId === "quantity") {
              task.quantity = parseFloat(value) || 0;
            } else if (columnId === "uom") {
              task.uom = value;
            } else if (columnId === "unit_price") {
              task.unit_price = parseFloat(value) || 0;
            }

            // حساب تلقائي لـ total_price
            task.total_price = (task.quantity || 0) * (task.unit_price || 0);

            gantt.updateTask(taskId);

            // إرسال البيانات للسيرفر
            axios.put(`/Gantt/gantt/${taskId}`, {
              text: task.text,
              parent: task.parent,
              reference: task.reference,
              uom: task.uom,
              quantity: task.quantity,
              unit_price: task.unit_price,
              total_price: task.total_price
            }).catch(() => {
              alert("فشل في حفظ التعديلات تلقائيًا.");
            });
          });



    });

    const addGroup = () => {
      const task = {
        text: 'New Scope',
        duration: 1,
        open: true,
        quantity: 1,
        uom: 1,
        unit_price: 0,
        total_price: 0,
      };
      gantt.addTask(task);
    };

    const addChild = () => {
      if (!selectedId.value) return;
      const task = {
        text: 'New Child',
        parent: selectedId.value,
        duration: 1,
        quantity: 1,
        uom: 1,
        unit_price: 0,
        total_price: 0,
      };
      gantt.addTask(task);
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
      selectedId,
    };
  },
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
