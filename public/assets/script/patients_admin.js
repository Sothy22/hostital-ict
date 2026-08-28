// DropDown Header
const dropdown = document.querySelector('.dropdown');
const btn = document.querySelector('.dropbtn');

btn.addEventListener('click', () => {
  dropdown.classList.toggle('active');
});

let patients = JSON.parse(localStorage.getItem('patients')) || [];

let editIndex = -1;

const patientForm = document.getElementById('patientForm');

patientForm.addEventListener('submit', function (e) {
  e.preventDefault();

  const patient = {
    id: 'PT-' + Date.now(),

    name: patientName.value,

    age: patientAge.value,

    gender: patientGender.value,

    phone: patientPhone.value,
  };

  if (editIndex === -1) {
    patients.push(patient);
  } else {
    patient.id = patients[editIndex].id;

    patients[editIndex] = patient;

    editIndex = -1;
  }

  savePatients();

  renderPatients();

  patientForm.reset();
});

function savePatients() {
  localStorage.setItem('patients', JSON.stringify(patients));
}

function renderPatients(list = patients) {
  let html = '';

  list.forEach((patient, index) => {
    html += `

        <tr>

            <td>${patient.id}</td>

            <td>${patient.name}</td>

            <td>${patient.age}</td>

            <td>${patient.gender}</td>

            <td>${patient.phone}</td>

            <td>

                <button
                onclick="editPatient(${index})">

                Edit

                </button>

                <button
                onclick="deletePatient(${index})">

                Delete

                </button>

            </td>

        </tr>

        `;
  });

  patientTable.innerHTML = html;
}

function deletePatient(index) {
  if (confirm('Delete Patient?')) {
    patients.splice(index, 1);

    savePatients();

    renderPatients();
  }
}

function editPatient(index) {
  const patient = patients[index];

  patientName.value = patient.name;

  patientAge.value = patient.age;

  patientGender.value = patient.gender;

  patientPhone.value = patient.phone;

  editIndex = index;
}

document.getElementById('searchPatient').addEventListener(
  'keyup',

  function () {
    const keyword = this.value.toLowerCase();

    const filtered = patients.filter(
      (patient) =>
        patient.name.toLowerCase().includes(keyword) ||
        patient.phone.includes(keyword) ||
        patient.id.toLowerCase().includes(keyword),
    );

    renderPatients(filtered);
  },
);

renderPatients();

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
// let patients = [];
// let editingPatientId = null; // ប្រើ ID របស់ Database ជំនួសឱ្យ Edit Index

// const patientForm = document.getElementById('patientForm');
// const patientName = document.getElementById('patientName');
// const patientAge = document.getElementById('patientAge');
// const patientGender = document.getElementById('patientGender');
// const patientPhone = document.getElementById('patientPhone');
// const patientTable = document.getElementById('patientTable');
// const searchPatient = document.getElementById('searchPatient');

// const token = localStorage.getItem('token'); // Auth Token សម្រាប់ Call API

// // -------------------------------------------------------------
// // ១. ទាញយក Patients ទាំងអស់ពី Database (READ)
// // -------------------------------------------------------------
// async function fetchPatients() {
//   try {
//     const res = await fetch('/api/patients', {
//       headers: { Authorization: `Bearer ${token}` },
//     });

//     if (!res.ok) throw new Error('Failed to fetch patients');

//     patients = await res.json();
//     renderPatients(patients);
//   } catch (error) {
//     console.error('Error loading patients:', error);
//   }
// }

// // -------------------------------------------------------------
// // ២. បង្ហាញទិន្នន័យលើ HTML Table (RENDER)
// // -------------------------------------------------------------
// function renderPatients(list = patients) {
//   let html = '';

//   list.forEach((patient) => {
//     // ប្រើ patient._id ឬ patient.id តាម Database (Mongo/MySQL)
//     const id = patient._id || patient.id;

//     html += `
//             <tr>
//                 <td>${patient.customId || id}</td>
//                 <td>${patient.name}</td>
//                 <td>${patient.age}</td>
//                 <td>${patient.gender}</td>
//                 <td>${patient.phone}</td>
//                 <td>
//                     <button onclick="editPatient('${id}')">Edit</button>
//                     <button onclick="deletePatient('${id}')">Delete</button>
//                 </td>
//             </tr>
//         `;
//   });

//   if (patientTable) {
//     patientTable.innerHTML = html;
//   }
// }

// // -------------------------------------------------------------
// // ៣. បង្កើត ឬ កែប្រែទិន្នន័យ (CREATE / UPDATE)
// // -------------------------------------------------------------
// if (patientForm) {
//   patientForm.addEventListener('submit', async function (e) {
//     e.preventDefault();

//     const patientData = {
//       name: patientName.value,
//       age: patientAge.value,
//       gender: patientGender.value,
//       phone: patientPhone.value,
//     };

//     try {
//       if (editingPatientId === null) {
//         // ១. បង្កើតថ្មី (POST)
//         const res = await fetch('/api/patients', {
//           method: 'POST',
//           headers: {
//             'Content-Type': 'application/json',
//             Authorization: `Bearer ${token}`,
//           },
//           body: JSON.stringify(patientData),
//         });

//         if (!res.ok) throw new Error('Failed to create patient');
//       } else {
//         // ២. កែប្រែ (PUT / PATCH)
//         const res = await fetch(`/api/patients/${editingPatientId}`, {
//           method: 'PUT',
//           headers: {
//             'Content-Type': 'application/json',
//             Authorization: `Bearer ${token}`,
//           },
//           body: JSON.stringify(patientData),
//         });

//         if (!res.ok) throw new Error('Failed to update patient');
//         editingPatientId = null; // Reset editing ID មកវិញ
//       }

//       patientForm.reset();
//       fetchPatients(); // ទាញយកទិន្នន័យថ្មីពី Database មក Refresh Table
//     } catch (error) {
//       console.error('Error saving patient:', error);
//       alert('Error saving patient data!');
//     }
//   });
// }

// // -------------------------------------------------------------
// // ៤. ជ្រើសរើសទិន្នន័យមកដាក់ក្នុង Form ដើម្បី Edit
// // -------------------------------------------------------------
// function editPatient(id) {
//   const patient = patients.find((p) => (p._id || p.id) == id);

//   if (patient) {
//     patientName.value = patient.name;
//     patientAge.value = patient.age;
//     patientGender.value = patient.gender;
//     patientPhone.value = patient.phone;

//     editingPatientId = id; // រក្សាទុក ID សម្រាប់ធ្វើការ Update
//   }
// }

// // -------------------------------------------------------------
// // ៥. លុបទិន្នន័យចេញពី Database (DELETE)
// // -------------------------------------------------------------
// async function deletePatient(id) {
//   if (confirm('Delete Patient?')) {
//     try {
//       const res = await fetch(`/api/patients/${id}`, {
//         method: 'DELETE',
//         headers: { Authorization: `Bearer ${token}` },
//       });

//       if (!res.ok) throw new Error('Failed to delete patient');

//       fetchPatients(); // Reload ទិន្នន័យឡើងវិញ
//     } catch (error) {
//       console.error('Error deleting patient:', error);
//       alert('Could not delete patient!');
//     }
//   }
// }

// // -------------------------------------------------------------
// // ៦. ស្វែងរក (SEARCH - Client Side Filtering)
// // -------------------------------------------------------------
// if (searchPatient) {
//   searchPatient.addEventListener('keyup', function () {
//     const keyword = this.value.toLowerCase();

//     const filtered = patients.filter((patient) => {
//       const patientId = (patient.customId || patient._id || patient.id || '')
//         .toString()
//         .toLowerCase();
//       const name = (patient.name || '').toLowerCase();
//       const phone = (patient.phone || '').toString();

//       return (
//         name.includes(keyword) ||
//         phone.includes(keyword) ||
//         patientId.includes(keyword)
//       );
//     });

//     renderPatients(filtered);
//   });
// }

// // ទាញយកទិន្នន័យដំបូងពេល Load Page
// document.addEventListener('DOMContentLoaded', fetchPatients);
