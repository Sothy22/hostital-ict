const dropdown = document.querySelector('.dropdown');
const btn = document.querySelector('.dropbtn');

if (btn && dropdown) {
  btn.addEventListener('click', () => {
    dropdown.classList.toggle('active');
  });
}
