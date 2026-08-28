document.addEventListener("DOMContentLoaded", () => {
    const patientForm = document.getElementById("patientForm");
    const doctorpatientTable = document.getElementById("doctorpatientTable");
    const rowTemplate = document.getElementById("patientRowTemplate");

    // --- 1. EDIT MODE CHECK (When page loads) ---
    const urlParams = new URLSearchParams(window.location.search);
    const editId = urlParams.get("editid"); 
    let isEditMode = false;

    if (editId && patientForm) {
        isEditMode = true;
        const patientList = JSON.parse(localStorage.getItem("patientsList")) || [];
        const patientToEdit = patientList.find(p => p.id == editId);

        if (patientToEdit) {
            const heading = document.querySelector("h2");
            if (heading) heading.textContent = "Edit Patient Info";

            document.getElementById("patientName").value = patientToEdit.name;
            document.getElementById("patientAge").value = patientToEdit.age;
            document.getElementById("patientGender").value = patientToEdit.gender;
            document.getElementById("patientPhone").value = patientToEdit.phone;
            document.getElementById("patientBlood").value = patientToEdit.blood;
            document.getElementById("patientStatus").value = patientToEdit.status;

            // Normalize saved formatted date string back into yyyy-mm-dd
            const rawDate = new Date(patientToEdit.lastVisit);
            if (!isNaN(rawDate)) {
                const yyyy = rawDate.getFullYear();
                const mm = String(rawDate.getMonth() + 1).padStart(2, '0');
                const dd = String(rawDate.getDate()).padStart(2, '0');
                document.getElementById("lastVisit").value = `${yyyy}-${mm}-${dd}`;
            } else {
                document.getElementById("lastVisit").value = patientToEdit.lastVisit;
            }
        }
    }

    // --- 2. FORM SUBMISSION (Add/Edit save) ---
    if (patientForm) {
        patientForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const name = document.getElementById("patientName").value.trim();
            const age = document.getElementById("patientAge").value.trim();
            const gender = document.getElementById("patientGender").value;
            const phone = document.getElementById("patientPhone").value.trim();
            const blood = document.getElementById("patientBlood").value; 
            const lastVisit = document.getElementById("lastVisit").value;
            const status = document.getElementById("patientStatus").value; 

            if (!name || !age || gender === "Select Gender" || !phone || blood === "Select Blood" || !lastVisit || status === "Select Status") {
                alert("Please fill out all patient metrics completely.");
                return;
            }

            let patientList = JSON.parse(localStorage.getItem("patientsList")) || [];

            if (isEditMode) {
                // Update Existing Item
                patientList = patientList.map(patient => {
                    if (patient.id == editId) {
                        return {
                            ...patient, 
                            name,
                            age,
                            gender,
                            phone,
                            blood,
                            lastVisit: formatDate(lastVisit),
                            status: status
                        };
                    }
                    return patient;
                });
                alert("Patient profile updated successfully!");
            } else {
                // Save New Item
                const newPatient = {
                    id: Date.now(),
                    name,
                    age,
                    gender,
                    phone,
                    blood,
                    lastVisit: formatDate(lastVisit),
                    status
                };
                patientList.push(newPatient);
                alert("Patient profile successfully recorded!");
            }

            localStorage.setItem("patientsList", JSON.stringify(patientList));
            window.location.href = "patient_doctor.html";
        });
    }

    // --- 3. TABLE INITIALIZATION ---
    if (doctorpatientTable && rowTemplate) {
        rowTemplate.removeAttribute("id");
        rowTemplate.remove();
        renderPatientTable(doctorpatientTable, rowTemplate);
    }
});

// --- 4. RENDER TABLE FUNCTION (With direct button handling) ---
function renderPatientTable(tableBody, rowTemplate) {
    const patientList = JSON.parse(localStorage.getItem("patientsList")) || [];

    tableBody.innerHTML = "";

    if (patientList.length === 0) {
        const emptyTr = document.createElement("tr");
        const emptyTd = document.createElement("td");
        emptyTd.colSpan = 9;
        emptyTd.style.textAlign = "center";
        emptyTd.style.padding = "20px";
        emptyTd.textContent = "No patient records found.";
        emptyTr.appendChild(emptyTd);
        tableBody.appendChild(emptyTr);
        return;
    }

    patientList.forEach((patient, index) => {
        const newRow = rowTemplate.cloneNode(true);

        // Format ID row numbers (01, 02...)
        const displayId = String(index + 1).padStart(2, "0");
        const idElement = newRow.querySelector(".patient-id");
        if (idElement) idElement.textContent = displayId;

        // Content layout targets
        newRow.querySelector(".patient-name").textContent = patient.name;
        newRow.querySelector(".patient-age").textContent = patient.age;
        newRow.querySelector(".patient-gender").textContent = patient.gender;
        newRow.querySelector(".patient-phone").textContent = patient.phone;
        newRow.querySelector(".patient-blood").textContent = patient.blood;
        newRow.querySelector(".patient-last-visit").textContent = patient.lastVisit;
        newRow.querySelector(".patient-status").textContent = patient.status;

        // Access your inline buttons directly
        const editBtn = newRow.querySelector(".edit-btn");
        const deleteBtn = newRow.querySelector(".delete-btn");

        // Simple Edit Button Click Action
        if (editBtn) {
            editBtn.addEventListener("click", () => {
                window.location.href = `add_patient_doctor.html?editid=${patient.id}`;
            });
        }

        // Simple Delete Button Click Action
        if (deleteBtn) {
            deleteBtn.addEventListener("click", () => {
                if (confirm(`Are you sure you want to delete ${patient.name}?`)) {
                    const updatedList = patientList.filter(p => p.id !== patient.id);
                    localStorage.setItem("patientsList", JSON.stringify(updatedList));
                    renderPatientTable(tableBody, rowTemplate);
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