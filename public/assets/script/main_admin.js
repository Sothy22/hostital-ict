document.addEventListener('DOMContentLoaded', () => {
  const user = JSON.parse(localStorage.getItem('user'));

  if (!user) {
    window.location.href = 'login.html';
    throw new Error('Not logged in, redirecting...');
  }

  const profileNameEl = document.getElementById('profileName');
  if (profileNameEl) profileNameEl.innerText = user.name;

  const doctors = JSON.parse(localStorage.getItem('doctors')) || [];
  const patients = JSON.parse(localStorage.getItem('patients')) || [];
  const appointments = JSON.parse(localStorage.getItem('appointments')) || [];

  if (document.getElementById('totalDoctors'))
    document.getElementById('totalDoctors').innerText = doctors.length;
  if (document.getElementById('totalPatients'))
    document.getElementById('totalPatients').innerText = patients.length;
  if (document.getElementById('totalAppointments'))
    document.getElementById('totalAppointments').innerText =
      appointments.length;
  if (document.getElementById('totalRevenue'))
    document.getElementById('totalRevenue').innerText = '$25,000';

  const table = document.getElementById('appointmentTable');
  if (table) {
    let rows = '';
    appointments.forEach((item) => {
      rows += `
            <tr>
                <td>${item.patient}</td>
                <td>${item.doctor}</td>
                <td>${item.date}</td>
                <td>${item.status}</td>
            </tr>
        `;
    });
    table.innerHTML = rows;
  }

  if (document.getElementById('revenueChart')) {
    new Chart(document.getElementById('revenueChart'), {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [
          { label: 'Revenue', data: [5000, 7000, 8000, 12000, 15000, 18000] },
        ],
      },
    });
  }

  if (document.getElementById('patientChart')) {
    new Chart(document.getElementById('patientChart'), {
      type: 'line',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{ label: 'Patients', data: [10, 15, 12, 18, 20, 16, 22] }],
      },
    });
  }
});

// document.addEventListener('DOMContentLoaded', async () => {
//   const token = localStorage.getItem('token');

//   if (!token) {
//     window.location.href = 'login.html';
//     return;
//   }

//   try {
//     const userRes = await fetch('/api/user/profile', {
//       headers: { Authorization: `Bearer ${token}` },
//     });

//     if (!userRes.ok) throw new Error('Unauthorized');
//     const user = await userRes.json();

//     const profileNameEl = document.getElementById('profileName');
//     if (profileNameEl) profileNameEl.innerText = user.name;

//     const [doctorsRes, patientsRes, appointmentsRes, revenueRes] =
//       await Promise.all([
//         fetch('/api/doctors', {
//           headers: { Authorization: `Bearer ${token}` },
//         }),
//         fetch('/api/patients', {
//           headers: { Authorization: `Bearer ${token}` },
//         }),
//         fetch('/api/appointments', {
//           headers: { Authorization: `Bearer ${token}` },
//         }),
//         fetch('/api/analytics/revenue', {
//           headers: { Authorization: `Bearer ${token}` },
//         }),
//       ]);

//     const doctors = await doctorsRes.json();
//     const patients = await patientsRes.json();
//     const appointments = await appointmentsRes.json();
//     const revenueData = await revenueRes.json();

//     if (document.getElementById('totalDoctors'))
//       document.getElementById('totalDoctors').innerText = doctors.length;
//     if (document.getElementById('totalPatients'))
//       document.getElementById('totalPatients').innerText = patients.length;
//     if (document.getElementById('totalAppointments'))
//       document.getElementById('totalAppointments').innerText =
//         appointments.length;
//     if (document.getElementById('totalRevenue'))
//       document.getElementById('totalRevenue').innerText =
//         revenueData.total || '$0';

//     const table = document.getElementById('appointmentTable');
//     if (table) {
//       let rows = '';
//       appointments.forEach((item) => {
//         rows += `
//                     <tr>
//                         <td>${item.patientName || item.patient}</td>
//                         <td>${item.doctorName || item.doctor}</td>
//                         <td>${item.date}</td>
//                         <td>${item.status}</td>
//                     </tr>
//                 `;
//       });
//       table.innerHTML = rows;
//     }

//     if (document.getElementById('revenueChart')) {
//       new Chart(document.getElementById('revenueChart'), {
//         type: 'bar',
//         data: {
//           labels: revenueData.labels || [
//             'Jan',
//             'Feb',
//             'Mar',
//             'Apr',
//             'May',
//             'Jun',
//           ],
//           datasets: [
//             {
//               label: 'Revenue',
//               data: revenueData.values || [0, 0, 0, 0, 0, 0],
//             },
//           ],
//         },
//       });
//     }

//     if (document.getElementById('patientChart')) {
//       const patientStatsRes = await fetch('/api/analytics/patients', {
//         headers: { Authorization: `Bearer ${token}` },
//       });
//       const patientStats = await patientStatsRes.json();

//       new Chart(document.getElementById('patientChart'), {
//         type: 'line',
//         data: {
//           labels: patientStats.labels || [
//             'Mon',
//             'Tue',
//             'Wed',
//             'Thu',
//             'Fri',
//             'Sat',
//             'Sun',
//           ],
//           datasets: [
//             {
//               label: 'Patients',
//               data: patientStats.values || [0, 0, 0, 0, 0, 0, 0],
//             },
//           ],
//         },
//       });
//     }
//   } catch (error) {
//     console.error('Error fetching data from database:', error);
//     window.location.href = 'login.html';
//   }
// });

// const dropdown = document.querySelector('.dropdown');
// const btn = document.querySelector('.dropbtn');

// if (btn && dropdown) {
//   btn.addEventListener('click', () => {
//     dropdown.classList.toggle('active');
//   });
// }
