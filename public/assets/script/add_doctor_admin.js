document.addEventListener('DOMContentLoaded', () => {
  // ១. ពិនិត្យមើលការ Login
  //   const user = JSON.parse(localStorage.getItem('user'));
  //   if (!user) {
  //     window.location.href = 'login.html';
  //     throw new Error('Not logged in, redirecting...');
  //   }

  const profileNameEl = document.getElementById('profileName');
  if (profileNameEl) profileNameEl.innerText = user.name;

  const API_BASE_URL = 'http://localhost:8000/api';

  // ២. ទាញយក Form
  const form = document.querySelector('form');
  if (!form) return;

  // ៣. ចាប់ Event ពេល Submit Form
  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    // ប្រើ FormData សម្រាប់ផ្ញើទិន្នន័យ និង File រូបថតទៅ Laravel
    const formData = new FormData();

    // Select DOM Elements តាម Order/Type ក្នុង HTML របស់អ្នក
    const inputs = form.querySelectorAll('input');
    const selects = form.querySelectorAll('select');
    const textareas = form.querySelectorAll('textarea');

    // ចាក់ទិន្នន័យចូល FormData
    formData.append('full_name', inputs[0].value.trim());
    formData.append('department', selects[0].value);
    formData.append('specialization', inputs[1].value.trim());
    formData.append('email', inputs[2].value.trim());
    formData.append('phone', inputs[3].value.trim());
    formData.append('gender', selects[1].value);
    formData.append('dob', inputs[4].value);
    formData.append('experience', inputs[5].value);
    formData.append('consultation_fee', inputs[6].value);
    formData.append('qualification', inputs[7].value.trim());
    formData.append('availability', selects[2].value);

    // Photo File Upload
    const photoInput = form.querySelector('input[type="file"]');
    if (photoInput && photoInput.files[0]) {
      formData.append('photo', photoInput.files[0]);
    }

    formData.append('address', textareas[0].value.trim());
    formData.append('bio', textareas[1].value.trim());

    // Status (Active / Inactive)
    const activeRadio = form.querySelector('input[name="status"]:checked');
    const statusVal = activeRadio
      ? activeRadio.nextElementSibling.innerText.trim()
      : 'Active';
    formData.append('status', statusVal);

    try {
      // ៤. បញ្ជូនទៅ Laravel API
      const response = await fetch(`${API_BASE_URL}/doctors`, {
        method: 'POST',
        headers: {
          Accept: 'application/json',
        },
        body: formData,
      });

      const result = await response.json();

      if (response.ok) {
        alert(' បន្ថែមគ្រូពេទ្យជោគជ័យ!');
        window.location.href = './doctor_admin.html';
      } else {
        alert(
          ' មានបញ្ហា: ' + (result.message || 'សូមពិនិត្យមើលព័ត៌មានឡើងវិញ!'),
        );
      }
    } catch (error) {
      console.error('Error adding doctor:', error);
      alert(' មិនអាចភ្ជាប់ទៅកាន់ Server បានទេ!');
    }
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const photoInput = document.getElementById('photoInput');
  const imagePreview = document.getElementById('imagePreview');

  // Elements ដើមសម្រាប់លាក់/បង្ហាញ
  const uploadIcon = document.querySelector('.upload-icon');
  const uploadTitle = document.querySelector('.upload-box h4');
  const uploadSubtext = document.querySelector('.upload-box p');

  if (photoInput) {
    photoInput.addEventListener('change', function (event) {
      const file = event.target.files[0];

      if (file) {
        // ប្រើ FileReader ដើមី្បអាន File រូបថត
        const reader = new FileReader();

        reader.onload = function (e) {
          // ដាក់ប្រភពរូបភាព (Src) ទៅកាន់ Preview Tag
          imagePreview.src = e.target.result;
          imagePreview.style.display = 'block';

          // លាក់ Icon និង Text ដើមដើម្បីកុំឱ្យជាន់គ្នា
          if (uploadIcon) uploadIcon.style.display = 'none';
          if (uploadTitle) uploadTitle.style.display = 'none';
          if (uploadSubtext) uploadSubtext.style.display = 'none';
        };

        reader.readAsDataURL(file); // អានរូបជា Data URL
      } else {
        // ប្រសិនបើមិនបានជ្រើសរើស File វិញ
        imagePreview.style.display = 'none';
        imagePreview.src = '';

        if (uploadIcon) uploadIcon.style.display = 'block';
        if (uploadTitle) uploadTitle.style.display = 'block';
        if (uploadSubtext) uploadSubtext.style.display = 'block';
      }
    });
  }
});
