import { doctorData } from '/assets/feth_data/doctors.js';
import { departmentData } from '../feth_data/departments.js';

// ==================== Active button header ====================
document.addEventListener('DOMContentLoaded', () => {
  const currentPage = window.location.pathname.split('/').pop();

  const links = document.querySelectorAll('.head-page a');

  links.forEach((link) => {
    const href = link.getAttribute('href');

    if (href === currentPage) {
      link.classList.add('active');
    }
  });
});

// Side Bar
document.addEventListener('DOMContentLoaded', () => {
  const menuBtn = document.getElementById('menu-btn');
  const closeBtn = document.getElementById('closeBtn');
  const headPage = document.getElementById('head-page');

  if (headPage) {
    if (menuBtn) {
      menuBtn.addEventListener('click', (event) => {
        event.stopPropagation();
        headPage.classList.add('show');
        menuBtn.classList.add('hidden');
      });
    }

    if (closeBtn) {
      closeBtn.addEventListener('click', (event) => {
        event.stopPropagation();
        headPage.classList.remove('show');
        if (menuBtn) menuBtn.classList.remove('hidden');
      });
    }

    document.addEventListener('click', (event) => {
      if (!headPage.contains(event.target) && event.target !== menuBtn) {
        headPage.classList.remove('show');
        if (menuBtn) menuBtn.classList.remove('hidden');
      }
    });
  }
});

// calender in contact
document.addEventListener('DOMContentLoaded', () => {
  const monthYearDisplay = document.getElementById('month-year-display');
  const daysContainer = document.getElementById('calendar-days-container');
  const prevBtn = document.getElementById('prev-month');
  const nextBtn = document.getElementById('next-month');

  if (monthYearDisplay && daysContainer && prevBtn && nextBtn) {
    let currentDate = new Date(2026, 5, 1);
    let selectedDateStr = '2026-06-09';

    const months = [
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
      'July',
      'August',
      'September',
      'October',
      'November',
      'December',
    ];

    function renderCalendar() {
      const year = currentDate.getFullYear();
      const month = currentDate.getMonth();

      monthYearDisplay.textContent = `${months[month]} ${year}`;

      const firstDayIndex = new Date(year, month, 1).getDay();
      const totalDays = new Date(year, month + 1, 0).getDate();
      const prevTotalDays = new Date(year, month, 0).getDate();

      let daysHTML = '';

      for (let i = firstDayIndex; i > 0; i--) {
        daysHTML += `<span class="day-muted">${prevTotalDays - i + 1}</span>`;
      }

      for (let day = 1; day <= totalDays; day++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const isSelected =
          dateStr === selectedDateStr ? 'class="day-selected"' : '';
        daysHTML += `<span ${isSelected} data-date="${dateStr}">${day}</span>`;
      }

      const totalGridCells = firstDayIndex + totalDays;
      const nextMonthPadding =
        totalGridCells % 7 === 0 ? 0 : 7 - (totalGridCells % 7);
      for (let j = 1; j <= nextMonthPadding; j++) {
        daysHTML += `<span class="day-muted">${j}</span>`;
      }

      daysContainer.innerHTML = daysHTML;

      // Day Selection Handler
      const activeDays = daysContainer.querySelectorAll('span:not(.day-muted)');
      activeDays.forEach((daySpan) => {
        daySpan.addEventListener('click', (e) => {
          const currentActive = daysContainer.querySelector('.day-selected');
          if (currentActive) currentActive.classList.remove('day-selected');

          e.target.classList.add('day-selected');
          selectedDateStr = e.target.getAttribute('data-date');
        });
      });
    }

    prevBtn.addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() - 1);
      renderCalendar();
    });

    nextBtn.addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() + 1);
      renderCalendar();
    });

    renderCalendar();
  }

  const timeButtons = document.querySelectorAll('.time-btn');
  if (timeButtons.length > 0) {
    timeButtons.forEach((button) => {
      button.addEventListener('click', (e) => {
        timeButtons.forEach((btn) => btn.classList.remove('active-slot'));
        e.target.classList.add('active-slot');
      });
    });
  }
});

// Dark Mode
document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.getElementById('theme-toggle');

  const saveTheme = localStorage.getItem('theme') || 'light';

  function applyTheme(theme) {
    if (theme === 'dark') {
      document.body.classList.add('dark-mode');
      toggle.classList.remove('fa-regular', 'fa-moon');
      toggle.classList.add('fa-solid', 'fa-sun');
    } else {
      document.body.classList.remove('dark-mode');
      toggle.classList.remove('fa-solid', 'fa-sun');
      toggle.classList.add('fa-regular', 'fa-moon');
    }
  }

  applyTheme(saveTheme);

  toggle.addEventListener('click', () => {
    const isDark = document.body.classList.contains('dark-mode');

    const nextTheme = isDark ? 'light' : 'dark';

    localStorage.setItem('theme', nextTheme);

    applyTheme(nextTheme);
  });
});

/// count number in home page on section 2
document.addEventListener('DOMContentLoaded', () => {
  const stats = document.querySelectorAll('.stat-number');

  const animateCounter = (element) => {
    const text = element.innerText.trim();

    const targetNumber = parseInt(text.replace(/[^0-9]/g, ''), 10);

    const suffix = text.replace(/[0-9,]/g, '');

    if (isNaN(targetNumber)) return;

    let start = 0;
    const duration = 2000;
    const frameRate = 1000 / 60;
    const totalFrames = Math.round(duration / frameRate);
    const increment = targetNumber / totalFrames;

    let currentFrame = 0;

    element.innerText = '0' + suffix;

    const counter = setInterval(() => {
      currentFrame++;
      start += increment;

      if (currentFrame >= totalFrames) {
        clearInterval(counter);
        element.innerText = text;
      } else {
        element.innerText = Math.floor(start) + suffix;
      }
    }, frameRate);
  };

  const observer = new IntersectionObserver(
    (entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px',
    },
  );

  stats.forEach((stat) => observer.observe(stat));
});

// ==================== ALL DOCTOR SECTION ====================
document.addEventListener('DOMContentLoaded', () => {
  const grid = document.getElementById('doctorsGrid');
  const firstCard = document.getElementById('doctorCard');
  const viewAllBtn = document.querySelector('.btn button');

  // ប្រសិនបើរកមិនឃើញ Element សំខាន់ៗទេ មិនបាច់រត់កូដខាងក្រោមឡើយ (ការពារ Error)
  if (!grid || !firstCard) return;

  let visibleCount = 6;

  function renderDoctors() {
    grid
      .querySelectorAll('.doctor-card:not(#doctorCard)')
      .forEach((card) => card.remove());

    // ត្រូវប្រាកដថាមានទិន្នន័យ doctorData ជាមុនសិន
    if (typeof doctorData === 'undefined') return;

    const items = doctorData.slice(0, visibleCount);

    items.forEach((doctor, index) => {
      let card;

      if (index === 0) {
        card = firstCard;
      } else {
        card = firstCard.cloneNode(true);
        grid.appendChild(card);
      }

      // បង្ការការគាំងករណីរកមិនឃើញ class ខាងក្នុង Card
      const img = card.querySelector('.doctorImage');
      if (img) {
        img.src = doctor.image;
        img.alt = doctor.name;
      }

      if (card.querySelector('.doctorName'))
        card.querySelector('.doctorName').textContent = doctor.name;
      if (card.querySelector('.doctorDepartment'))
        card.querySelector('.doctorDepartment').textContent = doctor.department;
      if (card.querySelector('.doctorRating'))
        card.querySelector('.doctorRating').textContent = doctor.rating;
      if (card.querySelector('.doctorExperience'))
        card.querySelector('.doctorExperience').textContent = doctor.experience;
      if (card.querySelector('.doctorAvailable')) {
        card.querySelector('.doctorAvailable').textContent = doctor.available
          ? 'Available'
          : 'Unavailable';
      }
    });

    if (viewAllBtn) {
      if (visibleCount >= doctorData.length) {
        viewAllBtn.style.display = 'none';
      } else {
        viewAllBtn.style.display = 'block';
      }
    }
  }

  renderDoctors();

  if (viewAllBtn) {
    viewAllBtn.addEventListener('click', () => {
      visibleCount += 6;
      renderDoctors();
    });
  }
});

// ==================== ALL DEPARTMENTS SECTION ====================
// document.addEventListener('DOMContentLoaded', () => {
//   const departmentsGrid = document.getElementById('departmentsGrid');
//   const firstCard = document.getElementById('depCard');
//   const viewAllBtn = document.getElementById('viewAllBtn');

//   // 👉 ការពារ Error: បើគ្មានប្លុក Departments ក្នុងទំព័រនេះទេ ឱ្យវារំលងតែម្តង
//   if (!departmentsGrid || !firstCard) {
//     console.log(
//       'រកមិនឃើញ departmentsGrid ឬ depCard ឡើយ។ រំលងការ Render ទិន្នន័យនេះ។',
//     );
//     return;
//   }

//   let visibleCount = 6;

//   function renderDepartments() {
//     // ប្រើប្រាស់ដោយសុវត្ថិភាព
//     departmentsGrid
//       .querySelectorAll('.dep-card:not(#depCard)')
//       .forEach((card) => card.remove());

//     // ត្រូវប្រាកដថាមានទិន្នន័យ departmentData
//     if (typeof departmentData === 'undefined') return;

//     const items = departmentData.slice(0, visibleCount);

//     items.forEach((dep, index) => {
//       let card;

//       if (index === 0) {
//         card = firstCard;
//       } else {
//         card = firstCard.cloneNode(true);
//         departmentsGrid.appendChild(card);
//       }

//       // បង្ការការគាំងករណីរកមិនឃើញ class ខាងក្នុង Card
//       const managerImg = card.querySelector('.managerImage');
//       if (managerImg) {
//         managerImg.src = dep.managerImage;
//         managerImg.alt = dep.managerName;
//       }

//       if (card.querySelector('.managerName'))
//         card.querySelector('.managerName').textContent = dep.managerName;
//       if (card.querySelector('.departmentTitle'))
//         card.querySelector('.departmentTitle').textContent = dep.title;
//       if (card.querySelector('.dep-des'))
//         card.querySelector('.dep-des').textContent = dep.description;
//       if (card.querySelector('.departmentBtn'))
//         card.querySelector('.departmentBtn').textContent = dep.linkText;
//     });

//     if (viewAllBtn) {
//       if (visibleCount >= departmentData.length) {
//         viewAllBtn.style.display = 'none';
//       } else {
//         viewAllBtn.style.display = 'block';
//       }
//     }
//   }

//   renderDepartments();

//   if (viewAllBtn) {
//     viewAllBtn.addEventListener('click', () => {
//       visibleCount += 6;
//       renderDepartments();
//     });
//   }
// });
