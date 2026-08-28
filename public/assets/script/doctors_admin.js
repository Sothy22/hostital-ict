// // DropDown Header
// const dropdown = document.querySelector('.dropdown');
// const btn = document.querySelector('.dropbtn');

// btn.addEventListener('click', () => {
//   dropdown.classList.toggle('active');
// });

// const user = JSON.parse(localStorage.getItem('user'));
// if (!user) {
//   window.location.href = 'login.html';
//   throw new Error('Not logged in!');
// }

// // ២. បង្កើត Variable សម្រាប់ទុកទិន្នន័យគ្រូពេទ្យ
// let doctors = JSON.parse(localStorage.getItem('doctors')) || [];
// let editIndex = -1;

// // ៣. មុខងារបន្ថែម ឬកែប្រែទិន្នន័យ (Add / Edit) ពេល Submit Form
// const doctorForm = document.getElementById('doctorForm');
// if (doctorForm) {
//   doctorForm.addEventListener('submit', function (e) {
//     e.preventDefault();

//     const doctor = {
//       name: document.getElementById('doctorName').value,
//       specialization: document.getElementById('specialization').value,
//       phone: document.getElementById('phone').value,
//     };

//     if (editIndex === -1) {
//       doctors.push(doctor); // បន្ថែមថ្មី
//     } else {
//       doctors[editIndex] = doctor; // កែប្រែលើទិន្នន័យចាស់
//       editIndex = -1;
//     }

//     localStorage.setItem('doctors', JSON.stringify(doctors)); // រក្សាទុក
//     doctorForm.reset();
//     renderDoctors();
//   });
// }

// // ៤. មុខងារបង្ហាញទិន្នន័យទៅក្នុងតារាង HTML
// function renderDoctors(list = doctors) {
//   const tableBody = document.getElementById('doctorTable');
//   if (!tableBody) return;

//   let html = '';
//   list.forEach((doctor, index) => {
//     html += `
//         <tr>
//             <td>${doctor.name}</td>
//             <td>${doctor.specialization}</td>
//             <td>${doctor.phone}</td>
//             <td>
//                 <button onclick="editDoctor(${index})">Edit</button>
//                 <button onclick="deleteDoctor(${index})">Delete</button>
//             </td>
//         </tr>`;
//   });
//   tableBody.innerHTML = html;
// }

// // ៥. មុខងារលុប (Delete) និង កែប្រែ (Edit)
// window.deleteDoctor = function (index) {
//   if (confirm('Delete this doctor?')) {
//     doctors.splice(index, 1);
//     localStorage.setItem('doctors', JSON.stringify(doctors));
//     renderDoctors();
//   }
// };

// window.editDoctor = function (index) {
//   const doctor = doctors[index];
//   document.getElementById('doctorName').value = doctor.name;
//   document.getElementById('specialization').value = doctor.specialization;
//   document.getElementById('phone').value = doctor.phone;
//   editIndex = index;
// };

// // ៦. មុខងារស្វែងរក (Search)
// const searchInput = document.getElementById('searchDoctor');
// if (searchInput) {
//   searchInput.addEventListener('keyup', function () {
//     const keyword = this.value.toLowerCase();
//     const filtered = doctors.filter(
//       (doc) =>
//         doc.name.toLowerCase().includes(keyword) ||
//         doc.specialization.toLowerCase().includes(keyword),
//     );
//     renderDoctors(filtered);
//   });
// }
// renderDoctors();

// document.addEventListener('DOMContentLoaded', async () => {
//   // ១. ពិនិត្យមើលការ Login (ដូចឧទាហរណ៍របស់អ្នក)
//   const user = JSON.parse(localStorage.getItem('user'));
//   if (!user) {
//     window.location.href = 'login.html';
//     throw new Error('Not logged in, redirecting...');
//   }

//   // ដាក់ឈ្មោះ Profile
//   const profileNameEl = document.getElementById('profileName');
//   if (profileNameEl) profileNameEl.innerText = user.name;

//   const API_BASE_URL = 'http://localhost:8000/api';

//   // ២. ទាញយក HTML Elements ដែលមានស្រាប់
//   const mainCard = document.querySelector('.main-card');
//   const templateCard = document.getElementById('doctor-template'); // Card ដើមក្នុង HTML

//   if (!mainCard || !templateCard) return;

//   // Function សម្រាប់ទាញយកទិន្នន័យពី API និងបំពេញចូល HTML Elements
//   async function fetchAndRenderDoctors(department = 'ALL') {
//     // លុប Card ទាំងអស់ចេញ លើកលែងតែ Template ដំបូង
//     const existingCards = mainCard.querySelectorAll(
//       '.doctor-card:not(#doctor-template)',
//     );
//     existingCards.forEach((card) => card.remove());

//     try {
//       let url = `${API_BASE_URL}/doctors`;
//       if (department !== 'ALL') {
//         url += `?department=${encodeURIComponent(department)}`;
//       }

//       const response = await fetch(url);
//       const resData = await response.json();

//       if (!response.ok || !resData.data) return;

//       const doctors = resData.data;

//       // រត់ Loop លើទិន្នន័យ ហើយចាក់ចូល HTML DOM
//       doctors.forEach((doc) => {
//         // Clone HTML Structure ដើមរបស់អ្នក
//         const cardNode = templateCard.cloneNode(true);
//         cardNode.removeAttribute('id');
//         cardNode.style.display = ''; // បង្ហាញ Card

//         // Selector & Fill Data (ដូចឧទាហរណ៍ Dashboard របស់អ្នក)
//         const ratingEl = cardNode.querySelector('.rating');
//         if (ratingEl) {
//           ratingEl.childNodes[0].textContent = ` ${doc.rating || 4.8} `;
//           const span = ratingEl.querySelector('span');
//           if (span) span.innerText = `(${doc.reviews_count || 201})`;
//         }

//         const imgEl = cardNode.querySelector('.doctor-avatar img');
//         if (imgEl) {
//           imgEl.src = doc.photo || './assets/images/top-doctor1.jpg';
//           imgEl.alt = doc.full_name || 'Doctor';
//         }

//         const nameEl = cardNode.querySelector('.doctor-info h3');
//         if (nameEl) nameEl.innerText = doc.full_name;

//         const addressEl = cardNode.querySelector('.doctor-info p');
//         if (addressEl) addressEl.innerText = doc.address || 'N/A';

//         const deptEl = cardNode.querySelector('.depart-info');
//         if (deptEl)
//           deptEl.innerText = (doc.department || 'GYNOCOLOGY').toUpperCase();

//         const metaBtns = cardNode.querySelectorAll('.meta button');
//         if (metaBtns[0]) {
//           metaBtns[0].childNodes[
//             metaBtns[0].childNodes.length - 1
//           ].textContent = ` ${doc.availability || 'Available'}`;
//         }
//         if (metaBtns[1]) {
//           metaBtns[1].childNodes[
//             metaBtns[1].childNodes.length - 1
//           ].textContent = ` ${doc.phone || 'Make a call'}`;
//         }

//         // ដាក់ Card ចូលទៅក្នុង .main-card
//         mainCard.appendChild(cardNode);
//       });
//     } catch (error) {
//       console.error('Error fetching doctors:', error);
//     }
//   }

//   // ផ្ទុកទិន្នន័យលើកដំបូង
//   await fetchAndRenderDoctors('ALL');

//   // ៣. Filter តាម Filter Buttons (ALL, CARDIOLOGY, ...)
//   const deptButtons = document.querySelectorAll('.head-card button');
//   deptButtons.forEach((btn) => {
//     btn.addEventListener('click', (e) => {
//       const selectedDept = e.target.innerText.trim();
//       fetchAndRenderDoctors(selectedDept);
//     });
//   });
// });

document.addEventListener('DOMContentLoaded', () => {
  const user = JSON.parse(localStorage.getItem('user'));
  if (!user) {
    window.location.href = 'login.html';
    return;
  }

  const mainCard = document.querySelector('.main-card');
  const templateCard = document.getElementById('doctor-template');

  if (!mainCard || !templateCard) return;

  function renderDoctors(departmentFilter = 'ALL') {
    // លុប Card ចាស់ៗចេញ លើកលែងតែ Template (#doctor-template)
    const existingCards = mainCard.querySelectorAll(
      '.doctor-card:not(#doctor-template)',
    );
    existingCards.forEach((card) => card.remove());

    // ទាញយកទិន្នន័យពី LocalStorage
    let doctors = JSON.parse(localStorage.getItem('doctors')) || [];

    // Filter តាម Department
    if (departmentFilter !== 'ALL') {
      doctors = doctors.filter(
        (doc) =>
          doc.department.toUpperCase() === departmentFilter.toUpperCase(),
      );
    }

    // រត់ Loop បំពេញទិន្នន័យចូល DOM
    doctors.forEach((doc) => {
      const cardNode = templateCard.cloneNode(true);
      cardNode.removeAttribute('id');
      cardNode.style.display = '';

      // Rating
      const ratingEl = cardNode.querySelector('.rating');
      if (ratingEl) {
        ratingEl.childNodes[0].textContent = ` ${doc.rating || '5.0'} `;
        const span = ratingEl.querySelector('span');
        if (span) span.innerText = `(${doc.reviews_count || 0})`;
      }

      // Photo
      const imgEl = cardNode.querySelector('.doctor-avatar img');
      if (imgEl) imgEl.src = doc.photo || './assets/images/top-doctor1.jpg';

      // Doctor Info
      const nameEl = cardNode.querySelector('.doctor-info h3');
      if (nameEl) nameEl.innerText = doc.full_name;

      const addressEl = cardNode.querySelector('.doctor-info p');
      if (addressEl) addressEl.innerText = doc.address;

      // Department
      const deptEl = cardNode.querySelector('.depart-info');
      if (deptEl) deptEl.innerText = (doc.department || '').toUpperCase();

      // Meta Buttons (Availability & Phone)
      const metaBtns = cardNode.querySelectorAll('.meta button');
      if (metaBtns[0]) {
        metaBtns[0].childNodes[metaBtns[0].childNodes.length - 1].textContent =
          ` ${doc.availability}`;
      }
      if (metaBtns[1]) {
        metaBtns[1].childNodes[metaBtns[1].childNodes.length - 1].textContent =
          ` ${doc.phone}`;
      }

      mainCard.appendChild(cardNode);
    });
  }

  // បង្ហាញ Doctors លើកដំបូង
  renderDoctors('ALL');

  // Filter តាម Buttons (ALL, CARDIOLOGY, ...)
  const deptButtons = document.querySelectorAll('.head-card button');
  deptButtons.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      renderDoctors(e.target.innerText.trim());
    });
  });
});
