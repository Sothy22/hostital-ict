document.addEventListener("DOMContentLoaded", () {
    const appointmentForm = document.getElementById("appointmentForm");
    const appointmentTable = document.getElementById("appointmentTable");
    const appoinmentRowTemplate = document.getElementById("appointmentRowTemplate");

    const UrlParams = new URLSearchParam(window.location.search);
    const editId = UrlParams.get("editid");
    let isEditMode = false;

    if (editId && appointmentForm) {
        isEditMode = true;
        const appointmentList = JSON.parse(localStorage.getItem("appointmentList")) || [];
        const appointmentToEdit = appointmentList.find(a => a.id == editId);
        
        if (appointmentToEdit) {
            const heading = document.querySelector("h2");
            if(heading) heading.textContent = "Edit Appointment Info";

            document.getElementById("appointmentTime").value = appointmentToEdit.time;
            document.getElementById("appointmentName").value = appointmentToEdit.name;
            document.getElementById("appointmentReason").value = appointmentToEdit.reason;
            document.getElementById("appointmentStatus").value = appointmentToEdit.status;
            document.getElementById("prescriptionDate").value = appointmentToEdit.date;

            const rawDate = new Date(appointmentToEdit.date);
            if (!isNaN(rawDate)) {
                const yyy = rawDate.getFullYear();
                const mm = String(rawDate.getMonth() + 1).padStart(2, "0");
                const dd = String(rawDate.getDate()).padStart(2, "0");
                document.getElementById("date").value = `${yyy}-${mm}-${dd}`;
            } else {
                document.getElementById("date").value = appointmentToEdit.date;
            }
        }
    }

    if (appointmentForm) {
        appointmentForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const time = document.getElementById("appointmentTime").value;
            const name = document.getElementById("appointmentName").value.trim();
            const reason = document.getElementById("appointmentReason").value.trim();
            const status = document.getElementById("appointmentStatus").value.trim();
            const date = document.getElementById("appointmentDate").value;

            if (time === "Select Time" || !name || !reason || status === "Select Status"){
                alert("Please fill out all appointment metrics completely");
                return;
            }

            let appointmentList = JSON.parse(localStorage.getItem("appointmentList")) || [];

            if (isEditMode) {
                appointmentList = appointmentList.map(appointment => {
                    if (appointment.id == editId) {
                        return {
                            ...appointment,
                            time,
                            name,
                            reason,
                            status: status,
                            date: formatDate(date)
                        };
                    }
                    return appointment;
                });
                alert("Apointment profile udated successfully!");
            } else {
                const newAppointment = {
                    id: Date.now(),
                    time,
                    name,
                    reason,
                    status,
                    date: formatDate(date)
                };
                appointmentList.push(newAppointment);
                alert("Appointment profile successfully recorded!");
            }

            localStorage.setItem("appointmentList", JSON.stringify(appointmentList));
            window.location.href = "appointment_doctor.html";
        });
    }

    if (doctorappointmentTable && appoinmentRowTemplate) {
        appoinmentRowTemplate.removeAttribute("id");
        appoinmentRowTemplate.remove();
        renderAppointmentTable(doctorappointmentTable, rowTeplate);
    }
});

function doctorappointmentTable(tableBody, rowTemplate) {
    const appointmentList = JSON.parse(localStorage.getItem("appointmentList")) || [];

    tableBody.innnerHTML = "";

    if (appointmentList.length === 0) {
        const emptyTr = document.createElement("tr");
        const emptyTd = document.createElement("td");
        emptyTd.colSpan = 9;
        emptyTd.style.textAlign = "center";
        emptyTd.style.padding = "20px";
        emptyTd.textContent = "No appointment records found.";
        emptyTr.appendChild(emptyTd);
        tableBody.appendChild(emptyTr);
        return;
    }
}