// document.addEventListener('DOMContentLoaded', () => {
//   const menuToggle = document.getElementById('menuToggle');
//   const aside = document.querySelector('.aside');
//   const icon = menuToggle ? menuToggle.querySelector('i') : null;

//   if (!menuToggle || !aside) return;

//   menuToggle.addEventListener('click', () => {
//     aside.classList.toggle('active');

//     document.body.classList.toggle('sidebar-open');

//     if (aside.classList.contains('active')) {
//         icon.classList.replace('fa-bars', 'fa-xmark');
//     } else {
//         icon.classList.replace('fa-xmark', 'fa-bars');
//     }
// });

//   // បិទ Sidebar វិញនៅពេលចុចនៅខាងក្រៅ
//   document.addEventListener('click', (e) => {
//     if (!aside.contains(e.target) && !menuToggle.contains(e.target)) {
//       aside.classList.remove('active');
//       if (icon) {
//         icon.classList.replace('fa-xmark', 'fa-bars');
//       }
//     }
//   });
// });

document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.getElementById('menuToggle');
  const aside = document.querySelector('.aside');
  const icon = menuToggle ? menuToggle.querySelector('i') : null;

  if (!menuToggle || !aside) return;

  menuToggle.addEventListener('click', () => {
    aside.classList.toggle('active');
    document.body.classList.toggle('sidebar-open');

    if (icon) {
      if (aside.classList.contains('active')) {
        icon.classList.replace('fa-bars', 'fa-xmark');
      } else {
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
    }
  });

  document.addEventListener('click', (e) => {
    if (!aside.contains(e.target) && !menuToggle.contains(e.target)) {
      aside.classList.remove('active');
      document.body.classList.remove('sidebar-open'); // បន្ថែមចំណុចនេះដើម្បីដក class ចេញពី body ដែរ

      if (icon) {
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
    }
  });
});
