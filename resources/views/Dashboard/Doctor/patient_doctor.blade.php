<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
    <link rel="stylesheet" href="{{ asset("assets/style/doctor/main_doctor.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/dashboard/aside.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/dashboard/list_page.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/dashboard/theme_dashboard.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/dashboard/add.css") }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <title>Document</title>
  </head>

  <body class="admin-dashboard doctor-dashboard">
    @php
      $doctor = auth('web')->user();
      $doctorName = trim(($doctor->name ?? '') !== ''
        ? $doctor->name
        : trim(($doctor->first_name ?? '') . ' ' . ($doctor->last_name ?? ''))
      );
      $doctorName = $doctorName ?: 'Doctor';
      $doctorImage = $doctor && $doctor->image
        ? asset('storage/' . ltrim(str_replace('/storage/', '', $doctor->image), '/'))
        : asset('assets/images/top-doctor2.jpg');
    @endphp

    <div class="container">
      <!-- aside -->
      <aside class="aside">
        <div class="title-head">
          <i class="fa-solid fa-heart-pulse"></i>
          <div class="title">
            <span>CarePlus</span>
            <span>Doctor Pannel</span>
          </div>
        </div>

        <div class="aside-head">
          <div class="upper-head">
            <a href={{ route("main_doctor") }}>
              <i class="fa-solid fa-house"></i>
              Dashboard
            </a>

            <a href="{{ route('appointment_doctor') }}">
              <i class="fa-solid fa-users"></i>
              Appointments
            </a>

            <a href="{{ route('patient_doctor') }}" class="active">
              <i class="fa-solid fa-calendar"></i>
              Patients
            </a>

            <a href="schedule_doctor.html">
              <i class="fa-regular fa-calendar"></i>
              Schedules
            </a>

            <a href="prescription_doctor.html">
              <i class="fa-solid fa-file-prescription"></i>
              Prescriptions
            </a>

            <a href="history_doctor.html">
              <i class="fa-solid fa-file-medical"></i>
              History
            </a>

            <a href="settings.html">
              <i class="fa-regular fa-clipboard"></i>
              Reports
            </a>
          </div>

          <div class="under-head">
            @csrf
            <div class="avatar-user">
              <div class="avatar-user-photo">
                <img src="{{ $doctorImage }}" alt="{{ $doctorName }}" />
              </div>
              <p>{{ $doctorName }}</p>
            </div>

            <a href="http://">
              <i class="fa-regular fa-circle-question"></i>
              Support
            </a>

            {{--
            <a href="login.html" name="logout">
              <i class="fa-solid fa-right-from-bracket"></i>
              Log Out
            </a>
            --}}

            <form action="{{ route('logout') }}" method="POST">
              @csrf

              <button type="submit" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                Log Out
              </button>
            </form>
          </div>
        </div>
      </aside>

      <main class="main">
        <!-- Header -->
        <div class="header">
          <button class="menu-toggle" id="menuToggle">
            <i class="fa-solid fa-bars"></i>
          </button>

          <!-- center -->
          <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search patients, records..." />
          </div>

          <!-- right -->
          <div class="head-right">
            <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
            <!-- Dark Mode -->
            <div class="mode-icon">
              <i id="theme-toggle" class="fa-regular fa-moon"></i>
            </div>

            <!-- Notification -->
            <div class="notification">
              <i class="fa-solid fa-bell"></i>
              <span class="dot"></span>
            </div>

            <div class="avata">
              <img src="{{ $doctorImage }}" alt="{{ $doctorName }}" />
            </div>
          </div>
        </div>

        <!-- container -->
        <section class="title-contain">
          <div class="title">
            <h4>NEW APPOINTMENT</h4>
            <h4>COMPLETED APPOINTMENTS</h4>
          </div>
          <div class="btn-add-appointment">
            <button type="button" data-open-appointment-modal>
              <i class="fa-solid fa-plus"></i>
              New Appointment
            </button>
          </div>
        </section>

        <section class="filter">
          <div class="search-appoint">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" placeholder="Search" />
          </div>

          <div class="date-filter">
            <input type="text" placeholder="Filter by Date" />
            <i class="fa-regular fa-calendar"></i>
          </div>
        </section>

        <form action="" class="table">
          <table>
            <thead>
              <tr>
                <th>
                  <div class="time-header">
                    Time
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
                <th>
                  <div class="time-header">
                    Date
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
                <th>
                  <div class="time-header">
                    Patient Name
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
                <th>
                  <div class="time-header">
                    Patient Age
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
                <th>
                  <div class="time-header">
                    Doctor
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
                <th>
                  <div class="time-header">
                    Fee Status
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
                <th>
                  <div class="time-header">
                    Action
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>9:00 AM</td>
                <td>5/11/2023</td>
                <td>
                  <div class="avata-user">
                    <img
                      src="./assets/images/dr-png-hero-section-683x1024.webp"
                      alt=""
                    />
                    <h5>Jonh</h5>
                  </div>
                </td>
                <td>32</td>
                <td>Dr.Heang</td>
                <td>Paid</td>
                <td>Request Fee</td>
                {{-- <td>
                    <div class="action-btn">
                        <button class="btn-comfirm">
                            Comfirm
                        </button>
                        <button class="btn-reject">
                            Reject
                        </button>
                    </div>
                </td> --}}
              </tr>
            </tbody>
          </table>
        </form>
      </main>
    </div>

    <div class="doctor-appointment-modal" data-appointment-modal hidden>
      <div class="doctor-appointment-modal__backdrop" data-close-appointment-modal></div>
      <section class="doctor-appointment-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="doctor-appointment-title">
        <div class="doctor-appointment-modal__header">
          <div class="doctor-appointment-modal__title-wrap">
            <span class="doctor-appointment-modal__icon">
              <i class="fa-regular fa-calendar-check"></i>
            </span>
            <h2 id="doctor-appointment-title">Add New Appointment</h2>
          </div>
          <button type="button" class="doctor-appointment-modal__close" aria-label="Close appointment form" data-close-appointment-modal>
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>

        <form class="doctor-appointment-form" action="#" method="POST">
          @csrf

          <div class="doctor-appointment-form__grid">
            <div class="doctor-appointment-form__left">
              <label class="doctor-appointment-form__label">
                <span class="doctor-appointment-form__label-icon">
                  <i class="fa-solid fa-user"></i>
                </span>
                <span>Select Patient <strong>*</strong></span>
              </label>

              <div class="doctor-appointment-form__search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search patient by name, phone..." />
                <i class="fa-solid fa-chevron-down"></i>
              </div>

              <div class="doctor-appointment-form__patient-card">
                <div class="doctor-appointment-form__avatar">
                  <img src="{{ asset('assets/images/dr-png-hero-section-683x1024.webp') }}" alt="John Doe" />
                </div>
                <div class="doctor-appointment-form__patient-info">
                  <h3>John Doe</h3>
                  <p><i class="fa-solid fa-phone"></i> 012 345 678</p>
                  <p class="doctor-appointment-form__meta"><i class="fa-solid fa-cake-candles"></i> Age: 32 years old</p>
                  <span>Patient ID: P001</span>
                </div>
              </div>
            </div>

            <div class="doctor-appointment-form__right">
              <div class="doctor-appointment-form__row">
                <div class="doctor-appointment-form__field-group">
                  <label class="doctor-appointment-form__label">
                    <span class="doctor-appointment-form__label-icon">
                      <i class="fa-regular fa-calendar"></i>
                    </span>
                    <span>Appointment Date <strong>*</strong></span>
                  </label>
                  <div class="doctor-appointment-form__field doctor-appointment-form__field--date">
                    <i class="fa-regular fa-calendar"></i>
                    <input type="date" value="2026-01-11" />
                    <i class="fa-solid fa-chevron-down"></i>
                  </div>
                </div>

                <div class="doctor-appointment-form__field-group">
                  <label class="doctor-appointment-form__label">
                    <span class="doctor-appointment-form__label-icon">
                      <i class="fa-regular fa-clock"></i>
                    </span>
                    <span>Appointment Time <strong>*</strong></span>
                  </label>
                  <div class="doctor-appointment-form__field doctor-appointment-form__field--time">
                    <i class="fa-regular fa-clock"></i>
                    <select>
                      <option>9:00 AM</option>
                      <option>9:30 AM</option>
                      <option>10:00 AM</option>
                      <option>11:00 AM</option>
                      <option>1:00 PM</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                  </div>
                </div>
              </div>

              <div class="doctor-appointment-form__field-group doctor-appointment-form__field-group--doctor">
                <label class="doctor-appointment-form__label">
                  <span class="doctor-appointment-form__label-icon">
                    <i class="fa-solid fa-user-doctor"></i>
                  </span>
                  <span>Doctor <strong>*</strong></span>
                </label>
                <div class="doctor-appointment-form__field doctor-appointment-form__field--select">
                  <div class="doctor-appointment-form__doctor-badge">
                    <img src="{{ asset('assets/images/top-doctor2.jpg') }}" alt="Dr. Sarah Johnson" />
                  </div>
                  <select>
                    <option>Dr. Sarah Johnson</option>
                    <option>Dr. Michael Chen</option>
                    <option>Dr. Emma Wilson</option>
                  </select>
                  <i class="fa-solid fa-chevron-down"></i>
                </div>
              </div>

              <div class="doctor-appointment-form__field-group">
                <label class="doctor-appointment-form__label">
                  <span class="doctor-appointment-form__label-icon">
                    <i class="fa-solid fa-notes-medical"></i>
                  </span>
                  <span>Reason for Visit <strong>*</strong></span>
                </label>
                <textarea class="doctor-appointment-form__textarea" placeholder="Enter reason for visit..."></textarea>
              </div>

              <label class="doctor-appointment-form__checkbox">
                <span class="doctor-appointment-form__checkbox-box">
                  <input type="checkbox" checked />
                  <i class="fa-solid fa-check"></i>
                </span>
                <span class="doctor-appointment-form__checkbox-text">Send Reminder (SMS/Email)</span>
              </label>
              <p class="doctor-appointment-form__helper">We will send a reminder before the appointment.</p>

              <div class="doctor-appointment-form__actions">
                <button type="button" class="doctor-appointment-form__cancel" data-close-appointment-modal>
                  <i class="fa-solid fa-xmark"></i>
                  Cancel
                </button>
                <button type="submit" class="doctor-appointment-form__submit">
                  <i class="fa-regular fa-calendar-plus"></i>
                  Save Appointment
                </button>
              </div>
            </div>
          </div>
        </form>
      </section>
    </div>

    <script src="{{ asset("assets/script/doctor/patient.js") }}"></script>
    <script src="{{ asset("assets/script/dark_mode.js") }}" type="module"></script>
    <script src="{{ asset("assets/script/menu_dashboard.js") }}"></script>
  </body>
</html>
