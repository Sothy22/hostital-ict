document.addEventListener("DOMContentLoaded", () => {
    const prescriptionForm = document.getElementById("prescriptionForm");
    const prescriptionTable = document.getElementById("prescriptionTable");
    
    // Select the table row template from the tbody (first <tr> inside <tbody>)
    const rowTemplate = prescriptionTable ? prescriptionTable.querySelector("tbody tr") : null;

    // --- 1. EDIT MODE CHECK (When form page loads) ---
    const urlParams = new URLSearchParams(window.location.search);
    const editId = urlParams.get("editid"); 
    let isEditMode = false;

    if (editId && prescriptionForm) {
        isEditMode = true;
        const prescriptionsList = JSON.parse(localStorage.getItem("prescriptionsList")) || [];
        const prescriptionToEdit = prescriptionsList.find(p => p.id == editId);

        if (prescriptionToEdit) {
            const heading = document.querySelector(".page-header h2");
            if (heading) heading.textContent = "Edit Prescription Info";

            const saveBtn = document.querySelector(".save-btn");
            if (saveBtn) saveBtn.textContent = "Update Prescription";

            // Populate inputs with current object values
            document.getElementById("prescriptionName").value = prescriptionToEdit.name;
            document.getElementById("prescriptionMedication").value = prescriptionToEdit.medication;
            document.getElementById("prescriptionDosage").value = prescriptionToEdit.dosage;
            document.getElementById("prescriptionStatus").value = prescriptionToEdit.status;

            // Revert structured date string back to yyyy-mm-dd format for input fields
            const rawDate = new Date(prescriptionToEdit.date);
            if (!isNaN(rawDate)) {
                const yyyy = rawDate.getFullYear();
                const mm = String(rawDate.getMonth() + 1).padStart(2, '0');
                const dd = String(rawDate.getDate()).padStart(2, '0');
                document.getElementById("prescriptionDate").value = `${yyyy}-${mm}-${dd}`;
            } else {
                document.getElementById("prescriptionDate").value = prescriptionToEdit.date;
            }
        }
    }

    // --- 2. FORM SUBMISSION (Save New / Update Existing) ---
    if (prescriptionForm) {
        prescriptionForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const name = document.getElementById("prescriptionName").value.trim();
            const medication = document.getElementById("prescriptionMedication").value.trim();
            const dosage = document.getElementById("prescriptionDosage").value.trim();
            const date = document.getElementById("prescriptionDate").value;
            const status = document.getElementById("prescriptionStatus").value; 

            // Validation check matching the dropdown default labels
            if (!name || !medication || !dosage || !date || status === "Status") {
                alert("Please fill out all prescription details completely.");
                return;
            }

            let prescriptionsList = JSON.parse(localStorage.getItem("prescriptionsList")) || [];

            if (isEditMode) {
                // Update Existing Item
                prescriptionsList = prescriptionsList.map(prescription => {
                    if (prescription.id == editId) {
                        return {
                            ...prescription, 
                            name,
                            medication,
                            dosage,
                            date: formatDate(date),
                            status
                        };
                    }
                    return prescription;
                });
                alert("Prescription updated successfully!");
            } else {
                // Save New Item
                const newPrescription = {
                    id: Date.now(),
                    name,
                    medication,
                    dosage,
                    date: formatDate(date),
                    status
                };
                prescriptionsList.push(newPrescription);
                alert("Prescription successfully recorded!");
            }

            localStorage.setItem("prescriptionsList", JSON.stringify(prescriptionsList));
            window.location.href = "prescription_doctor.html"; // Adjust to exact list layout filename
        });

        // Handle cancel button click redirects
        const cancelBtn = prescriptionForm.querySelector(".cancel-btn");
        if (cancelBtn) {
            cancelBtn.addEventListener("click", (e) => {
                e.preventDefault();
                window.location.href = "prescription_doctor.html";
            });
        }
    }

    // --- 3. TABLE INITIALIZATION ---
    if (prescriptionTable && rowTemplate) {
        const tableBody = prescriptionTable.querySelector("tbody");
        rowTemplate.remove(); // Clean layout blueprint reference out of active elements tree
        renderPrescriptionTable(tableBody, rowTemplate);
    }
});

// --- 4. RENDER TABLE FUNCTION ---
function renderPrescriptionTable(tableBody, rowTemplate) {
    tableBody.innerHTML = "";
    
    // Always fetch fresh data references out of local memory inside render block
    const prescriptionsList = JSON.parse(localStorage.getItem("prescriptionsList")) || [];

    if (prescriptionsList.length === 0) {
        const emptyTr = document.createElement("tr");
        const emptyTd = document.createElement("td");
        emptyTd.colSpan = 6; // Matching structural header metrics length exactly
        emptyTd.style.textAlign = "center";
        emptyTd.style.padding = "20px";
        emptyTd.textContent = "No prescription records found.";
        emptyTr.appendChild(emptyTd);
        tableBody.appendChild(emptyTr);
        return;
    }

    prescriptionsList.forEach((prescription) => {
        const newRow = rowTemplate.cloneNode(true);

        // Map textual properties onto active node queries matching classes
        newRow.querySelector(".prescription-name").textContent = prescription.name;
        newRow.querySelector(".prescription-medication").textContent = prescription.medication;
        newRow.querySelector(".prescription-dosage").textContent = prescription.dosage;
        newRow.querySelector(".prescription-date").textContent = prescription.date;
        newRow.querySelector(".prescription-status").textContent = prescription.status;

        // Action Buttons Setup
        const editBtn = newRow.querySelector(".edit-btn");
        const deleteBtn = newRow.querySelector(".delete-btn");

        if (editBtn) {
            editBtn.addEventListener("click", () => {
                window.location.href = `add_prescription_doctor.html?editid=${prescription.id}`;
            });
        }

        if (deleteBtn) {
            deleteBtn.addEventListener("click", () => {
                if (confirm(`Are you sure you want to delete the prescription for ${prescription.name}?`)) {
                    // Re-fetch the layout elements in real-time to prevent scope-clash errors
                    const currentList = JSON.parse(localStorage.getItem("prescriptionsList")) || [];
                    const updatedList = currentList.filter(p => p.id !== prescription.id);
                    
                    localStorage.setItem("prescriptionsList", JSON.stringify(updatedList));
                    renderPrescriptionTable(tableBody, rowTemplate);
                }
            });
        }

        tableBody.appendChild(newRow);
    });
}

function formatDate(dateString) {
    const dateObj = new Date(dateString);
    if (isNaN(dateObj)) return dateString;

    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return dateObj.toLocaleDateString('en-US', options).replace(/,/g, '');
}