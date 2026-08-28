// DropDown Header
const dropdown = document.querySelector('.dropdown');
const btn = document.querySelector('.dropbtn');

btn.addEventListener('click', () => {
  dropdown.classList.toggle('active');
});

let appointments = JSON.parse(localStorage.getItem('appointments')) || [];

let doctors = JSON.parse(localStorage.getItem('doctors')) || [];

let patients = JSON.parse(localStorage.getItem('patients')) || [];

let editIndex = -1;

// Load dropdowns

function loadDropdowns() {
  const doctorSelect = document.getElementById('doctorSelect');

  const patientSelect = document.getElementById('patientSelect');

  doctorSelect.innerHTML = "<option value=''>Select Doctor</option>";

  patientSelect.innerHTML = "<option value=''>Select Patient</option>";

  doctors.forEach((doc) => {
    doctorSelect.innerHTML += `
        <option value="${doc.name}">
            ${doc.name}
        </option>
        `;
  });

  patients.forEach((patient) => {
    patientSelect.innerHTML += `
        <option value="${patient.name}">
            ${patient.name}
        </option>
        `;
  });
}

loadDropdowns();

// Save Appointment

document.getElementById('appointmentForm').addEventListener(
  'submit',

  function (e) {
    e.preventDefault();

    const appointment = {
      id: 'AP-' + Date.now(),

      patient: patientSelect.value,

      doctor: doctorSelect.value,

      date: appointmentDate.value,

      status: appointmentStatus.value,
    };

    if (editIndex === -1) {
      appointments.push(appointment);
    } else {
      appointment.id = appointments[editIndex].id;

      appointments[editIndex] = appointment;

      editIndex = -1;
    }

    saveAppointments();

    renderAppointments();

    this.reset();
  },
);

// Save LocalStorage

function saveAppointments() {
  localStorage.setItem(
    'appointments',

    JSON.stringify(appointments),
  );
}

// Render Table

function renderAppointments(list = appointments) {
  let html = '';

  list.forEach((appointment, index) => {
    html += `
        <tr>

            <td>
                ${appointment.id}
            </td>

            <td>
                ${appointment.patient}
            </td>

            <td>
                ${appointment.doctor}
            </td>

            <td>
                ${appointment.date}
            </td>

            <td>
                ${appointment.status}
            </td>

            <td>

                <button
                onclick=
                "editAppointment(${index})">

                Edit

                </button>

                <button
                onclick=
                "deleteAppointment(${index})">

                Delete

                </button>

            </td>

        </tr>
        `;
  });

  appointmentTable.innerHTML = html;
}

// Delete

function deleteAppointment(index) {
  if (confirm('Delete appointment?')) {
    appointments.splice(index, 1);

    saveAppointments();

    renderAppointments();
  }
}

// Edit

function editAppointment(index) {
  const appointment = appointments[index];

  patientSelect.value = appointment.patient;

  doctorSelect.value = appointment.doctor;

  appointmentDate.value = appointment.date;

  appointmentStatus.value = appointment.status;

  editIndex = index;
}

// Search

document.getElementById('searchAppointment').addEventListener(
  'keyup',

  function () {
    const keyword = this.value.toLowerCase();

    const filtered = appointments.filter(
      (appointment) =>
        appointment.patient.toLowerCase().includes(keyword) ||
        appointment.doctor.toLowerCase().includes(keyword) ||
        appointment.status.toLowerCase().includes(keyword),
    );

    renderAppointments(filtered);
  },
);

renderAppointments();

// -------------------------------------------------------------
// For backend
// -------------------------------------------------------------
// // DropDown Header
// const dropdown = document.querySelector('.dropdown');
// const btn = document.querySelector('.dropbtn');

// if (btn && dropdown) {
//   btn.addEventListener('click', () => {
//     dropdown.classList.toggle('active');
//   });
// }

// // -------------------------------------------------------------
// // Global Variables & DOM Elements
// // -------------------------------------------------------------
// let appointments = [];
// let doctors = [];
// let patients = [];
// let editingAppointmentId = null; // ប្រើ Database ID ជំនួសឱ្យ Edit Index

// const doctorSelect = document.getElementById('doctorSelect');
// const patientSelect = document.getElementById('patientSelect');
// const appointmentForm = document.getElementById('appointmentForm');
// const appointmentDate = document.getElementById('appointmentDate');
// const appointmentStatus = document.getElementById('appointmentStatus');
// const appointmentTable = document.getElementById('appointmentTable');
// const searchAppointment = document.getElementById('searchAppointment');

// const token = localStorage.getItem('token'); // Auth Token សម្រាប់ Call API

// // -------------------------------------------------------------
// // ១. ទាញយកទិន្នន័យដំបូងទាំងអស់ពី Database (INIT DATA)
// // -------------------------------------------------------------
// async function initData() {
//   try { 7
//     const [doctorsRes, patientsRes, appointmentsRes] = await Promise.all([
//       fetch('/api/doctors', { headers: { Authorization: `Bearer ${token}` } }),
//       fetch('/api/patients', { headers: { Authorization: `Bearer ${token}` } }),
//       fetch('/api/appointments', {
//         headers: { Authorization: `Bearer ${token}` },
//       }),
//     ]);

//     if (!doctorsRes.ok || !patientsRes.ok || !appointmentsRes.ok) {
//       throw new Error('Failed to fetch initial data');
//     }

//     doctors = await doctorsRes.json();
//     patients = await patientsRes.json();
//     appointments = await appointmentsRes.json();

//     loadDropdowns();
//     renderAppointments(appointments);
//   } catch (error) {
//     console.error('Error initializing appointment page:', error);
//   }
// }

// // -------------------------------------------------------------
// // ២. បញ្ចូលជម្រើស Doctors & Patients ទៅក្នុង Dropdown
// // -------------------------------------------------------------
// function loadDropdowns() {
//   if (!doctorSelect || !patientSelect) return;

//   doctorSelect.innerHTML = "<option value=''>Select Doctor</option>";
//   patientSelect.innerHTML = "<option value=''>Select Patient</option>";

//   doctors.forEach((doc) => {
//     // ប្រើ ID ឬ Name អាស្រ័យលើការរៀបចំ Schema របស់ Database
//     const docId = doc._id || doc.id;
//     doctorSelect.innerHTML += `<option value="${docId}">${doc.name}</option>`;
//   });

//   patients.forEach((patient) => {
//     const patientId = patient._id || patient.id;
//     patientSelect.innerHTML += `<option value="${patientId}">${patient.name}</option>`;
//   });
// }

// // -------------------------------------------------------------
// // ៣. បង្ហាញទិន្នន័យលើ HTML Table (RENDER)
// // -------------------------------------------------------------
// function renderAppointments(list = appointments) {
//   if (!appointmentTable) return;

//   let html = '';

//   list.forEach((appointment) => {
//     const id = appointment._id || appointment.id;

//     // ករណី Backend ផ្ញើមកជា Object ឬ Text ធម្មតា
//     const patientName =
//       appointment.patientName ||
//       appointment.patient?.name ||
//       appointment.patient;
//     const doctorName =
//       appointment.doctorName || appointment.doctor?.name || appointment.doctor;

//     html += `
//         <tr>
//             <td>${appointment.customId || id}</td>
//             <td>${patientName}</td>
//             <td>${doctorName}</td>
//             <td>${appointment.date}</td>
//             <td>${appointment.status}</td>
//             <td>
//                 <button onclick="editAppointment('${id}')">Edit</button>
//                 <button onclick="deleteAppointment('${id}')">Delete</button>
//             </td>
//         </tr>
//         `;
//   });

//   appointmentTable.innerHTML = html;
// }

// // -------------------------------------------------------------
// // ៤. បង្កើត ឬ កែប្រែទិន្នន័យ Appointment (CREATE / UPDATE)
// // -------------------------------------------------------------
// if (appointmentForm) {
//   appointmentForm.addEventListener('submit', async function (e) {
//     e.preventDefault();

//     const appointmentData = {
//       patient: patientSelect.value,
//       doctor: doctorSelect.value,
//       date: appointmentDate.value,
//       status: appointmentStatus.value,
//     };

//     try {
//       if (editingAppointmentId === null) {
//         // ១. បង្កើត Appointment ថ្មី (POST)
//         const res = await fetch('/api/appointments', {
//           method: 'POST',
//           headers: {
//             'Content-Type': 'application/json',
//             Authorization: `Bearer ${token}`,
//           },
//           body: JSON.stringify(appointmentData),
//         });

//         if (!res.ok) throw new Error('Failed to create appointment');
//       } else {
//         // ២. កែប្រែ Appointment (PUT / PATCH)
//         const res = await fetch(`/api/appointments/${editingAppointmentId}`, {
//           method: 'PUT',
//           headers: {
//             'Content-Type': 'application/json',
//             Authorization: `Bearer ${token}`,
//           },
//           body: JSON.stringify(appointmentData),
//         });

//         if (!res.ok) throw new Error('Failed to update appointment');
//         editingAppointmentId = null;
//       }

//       appointmentForm.reset();
//       fetchAppointments(); // Re-fetch ដើម្បី Update ទិន្នន័យថ្មី
//     } catch (error) {
//       console.error('Error saving appointment:', error);
//       alert('Error saving appointment data!');
//     }
//   });
// }

// // -------------------------------------------------------------
// // ៥. ទាញយកតែ Appointments ឡើងវិញ
// // -------------------------------------------------------------
// async function fetchAppointments() {
//   try {
//     const res = await fetch('/api/appointments', {
//       headers: { Authorization: `Bearer ${token}` },
//     });

//     if (!res.ok) throw new Error('Failed to fetch appointments');

//     appointments = await res.json();
//     renderAppointments(appointments);
//   } catch (error) {
//     console.error('Error fetching appointments:', error);
//   }
// }

// // -------------------------------------------------------------
// // ៦. ជ្រើសរើសទិន្នន័យមកដាក់ក្នុង Form ដើម្បី Edit
// // -------------------------------------------------------------
// window.editAppointment = function (id) {
//   const appointment = appointments.find((ap) => (ap._id || ap.id) == id);

//   if (appointment) {
//     patientSelect.value = appointment.patient?._id || appointment.patient;
//     doctorSelect.value = appointment.doctor?._id || appointment.doctor;
//     appointmentDate.value = appointment.date;
//     appointmentStatus.value = appointment.status;

//     editingAppointmentId = id; // រក្សាទុក ID សម្រាប់ធ្វើការ Update
//   }
// };

// // -------------------------------------------------------------
// // ៧. លុប Appointment ចេញពី Database (DELETE)
// // -------------------------------------------------------------
// window.deleteAppointment = async function (id) {
//   if (confirm('Delete appointment?')) {
//     try {
//       const res = await fetch(`/api/appointments/${id}`, {
//         method: 'DELETE',
//         headers: { Authorization: `Bearer ${token}` },
//       });

//       if (!res.ok) throw new Error('Failed to delete appointment');

//       fetchAppointments(); // Reload ទិន្នន័យឡើងវិញ
//     } catch (error) {
//       console.error('Error deleting appointment:', error);
//       alert('Could not delete appointment!');
//     }
//   }
// };

// // -------------------------------------------------------------
// // ៨. មុខងារស្វែងរក (SEARCH - Client Side Filtering)
// // -------------------------------------------------------------
// if (searchAppointment) {
//   searchAppointment.addEventListener('keyup', function () {
//     const keyword = this.value.toLowerCase();

//     const filtered = appointments.filter((ap) => {
//       const patientName = (
//         ap.patientName ||
//         ap.patient?.name ||
//         ap.patient ||
//         ''
//       ).toLowerCase();
//       const doctorName = (
//         ap.doctorName ||
//         ap.doctor?.name ||
//         ap.doctor ||
//         ''
//       ).toLowerCase();
//       const status = (ap.status || '').toLowerCase();

//       return (
//         patientName.includes(keyword) ||
//         doctorName.includes(keyword) ||
//         status.includes(keyword)
//       );
//     });

//     renderAppointments(filtered);
//   });
// }

// // ដំណើការទាញយកទិន្នន័យពី Database ពេល Load Page
// document.addEventListener('DOMContentLoaded', initData);
